// Modo oscuro
const darkModeToggle = document.getElementById('dark-mode-toggle');
const body = document.body;

if (localStorage.getItem('darkMode') === 'enabled') {
    body.classList.add('dark-mode');
    darkModeToggle.checked = true;
}

darkModeToggle.addEventListener('change', () => {
    if (darkModeToggle.checked) {
        body.classList.add('dark-mode');
        localStorage.setItem('darkMode', 'enabled');
    } else {
        body.classList.remove('dark-mode');
        localStorage.setItem('darkMode', 'disabled');
    }
});

// Función para renderizar gráficos
function renderChart(canvasId, cryptoId, cryptoName) {
    const canvasElement = document.getElementById(canvasId);
    
    if (!canvasElement) {
        console.error(`No se encontró el canvas con ID: ${canvasId}`);
        return;
    }

    fetch(`https://api.coingecko.com/api/v3/coins/${cryptoId}/market_chart?vs_currency=usd&days=7`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la API: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const prices = data.prices.map(price => price[1]);
            const dates = data.prices.map(price => {
                const date = new Date(price[0]);
                return date.toLocaleDateString('es-ES', { weekday: 'short' });
            });
            
            const ctx = canvasElement.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: `Precio de ${cryptoName} (7 días)`,
                        data: prices,
                        borderColor: '#6c5ce7',
                        backgroundColor: 'rgba(108, 92, 231, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error al obtener datos del gráfico:', error);
            canvasElement.parentElement.innerHTML = `<p class="chart-error">No se pudo cargar el gráfico</p>`;
        });
}

// Inicializar gráficos
function initializeCharts() {
    document.querySelectorAll('.crypto-card').forEach(card => {
        const cryptoId = card.getAttribute('data-id');
        const cryptoName = card.querySelector('h2').textContent;
        const canvasId = `chart-${cryptoId}`;
        
        if (document.getElementById(canvasId)) {
            renderChart(canvasId, cryptoId, cryptoName);
        } else {
            console.warn(`Canvas no encontrado para ${cryptoName} (ID: ${canvasId})`);
        }
    });
}

// Favoritos
function updateFavoriteButtons() {
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            this.classList.toggle('active');
        });
    });
}

// Comparador
const compareBtn = document.getElementById('compare-btn');
const comparisonContainer = document.getElementById('comparison-container');
const closeComparison = document.getElementById('close-comparison');
let selectedForComparison = [];

function updateSelectedCards() {
    document.querySelectorAll('.crypto-card').forEach(card => {
        const cryptoId = card.getAttribute('data-id');
        const isSelected = selectedForComparison.some(item => item.id === cryptoId);
        card.style.border = isSelected ? '2px solid #6c5ce7' : '1px solid #ddd';
        card.style.boxShadow = isSelected ? '0 0 10px rgba(108, 92, 231, 0.5)' : 'none';
    });
}

function addComparisonButtons() {
    document.querySelectorAll('.crypto-card').forEach(card => {
        const selectBtn = document.createElement('button');
        selectBtn.className = 'select-btn';
        selectBtn.innerHTML = 'Seleccionar para comparar';
        
        const actionsDiv = card.querySelector('.crypto-actions') || card;
        actionsDiv.appendChild(selectBtn);
        
        selectBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            
            const cryptoId = card.getAttribute('data-id');
            const cryptoName = card.querySelector('h2').textContent;
            const index = selectedForComparison.findIndex(item => item.id === cryptoId);
            
            if (index === -1) {
                if (selectedForComparison.length < 2) {
                    selectedForComparison.push({ id: cryptoId, name: cryptoName });
                } else {
                    selectedForComparison[0] = { id: cryptoId, name: cryptoName };
                }
            } else {
                selectedForComparison.splice(index, 1);
            }
            
            updateSelectedCards();
            compareBtn.textContent = `Comparar (${selectedForComparison.length}/2)`;
            compareBtn.disabled = selectedForComparison.length !== 2;
        });
    });
}

function compareCoins() {
    if (selectedForComparison.length !== 2) {
        alert('Por favor, selecciona exactamente 2 criptomonedas para comparar');
        return;
    }
    
    comparisonContainer.style.display = 'block';
    document.getElementById('coin1-name').textContent = selectedForComparison[0].name;
    document.getElementById('coin2-name').textContent = selectedForComparison[1].name;
    
    const chart1 = Chart.getChart('comparison-chart1');
    const chart2 = Chart.getChart('comparison-chart2');
    if (chart1) chart1.destroy();
    if (chart2) chart2.destroy();
    
    renderChart('comparison-chart1', selectedForComparison[0].id, selectedForComparison[0].name);
    renderChart('comparison-chart2', selectedForComparison[1].id, selectedForComparison[1].name);
    
    comparisonContainer.scrollIntoView({ behavior: 'smooth' });
}

// Event listeners
compareBtn.addEventListener('click', compareCoins);
closeComparison.addEventListener('click', () => {
    comparisonContainer.style.display = 'none';
    selectedForComparison = [];
    updateSelectedCards();
    compareBtn.textContent = 'Comparar';
    compareBtn.disabled = false;
});

// Inicialización completa
document.addEventListener('DOMContentLoaded', () => {
    initializeCharts();
    updateFavoriteButtons();
    addComparisonButtons();
    
    compareBtn.textContent = 'Comparar (0/2)';
    compareBtn.disabled = true;
});

// Reinicializar gráficos cuando se añadan nuevas tarjetas (por búsqueda)
document.addEventListener('newCryptoCardsAdded', () => {
    initializeCharts();
    addComparisonButtons();
});