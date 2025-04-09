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

// Favoritos - Ahora se manejan principalmente desde el servidor
// Esta función solo para feedback visual
function updateFavoriteButtons() {
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Feedback visual inmediato
            this.classList.toggle('active');
            
            // El formulario se enviará automáticamente al servidor
        });
    });
}

// Botón de favoritos para mostrar la lista
const favoritesBtn = document.getElementById('favorites-btn');
favoritesBtn.addEventListener('click', () => {
    // Desplazarse a la sección de favoritos
    document.querySelector('.profile-section:nth-of-type(3)').scrollIntoView({ 
        behavior: 'smooth' 
    });
});

// Gráficos
function renderChart(canvasId, cryptoId, cryptoName) {
    fetch(`https://api.coingecko.com/api/v3/coins/${cryptoId}/market_chart?vs_currency=usd&days=7`)
        .then(response => response.json())
        .then(data => {
            const prices = data.prices.map(price => price[1]);
            const dates = data.prices.map(price => {
                const date = new Date(price[0]);
                return date.toLocaleDateString('es-ES', { weekday: 'short' });
            });
            
            const ctx = document.getElementById(canvasId).getContext('2d');
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
        });
}

// Inicializar gráficos
document.querySelectorAll('.crypto-card').forEach(card => {
    const cryptoId = card.getAttribute('data-id');
    const cryptoName = card.querySelector('h2').textContent;
    renderChart(`chart-${cryptoId}`, cryptoId, cryptoName);
});

// Comparador
const compareBtn = document.getElementById('compare-btn');
const comparisonContainer = document.getElementById('comparison-container');
const closeComparison = document.getElementById('close-comparison');
let selectedForComparison = [];

document.querySelectorAll('.crypto-card').forEach(card => {
    card.addEventListener('click', (e) => {
        // No hacer nada si se hace clic en el botón de favoritos o en un enlace
        if (e.target.closest('.favorite-btn') || e.target.tagName === 'A') return;
        
        const cryptoId = card.getAttribute('data-id');
        const cryptoName = card.querySelector('h2').textContent;
        
        if (selectedForComparison.length < 2 && !selectedForComparison.some(item => item.id === cryptoId)) {
            selectedForComparison.push({ id: cryptoId, name: cryptoName });
            card.style.border = '2px solid #6c5ce7';
            
            if (selectedForComparison.length === 2) {
                compareCoins();
            }
        }
    });
});

compareBtn.addEventListener('click', () => {
    if (selectedForComparison.length === 2) {
        compareCoins();
    } else {
        alert('Selecciona 2 criptomonedas haciendo clic en sus tarjetas');
    }
});

closeComparison.addEventListener('click', () => {
    comparisonContainer.style.display = 'none';
    selectedForComparison = [];
    document.querySelectorAll('.crypto-card').forEach(card => {
        card.style.border = 'none';
    });
});

function compareCoins() {
    comparisonContainer.style.display = 'block';
    document.getElementById('coin1-name').textContent = selectedForComparison[0].name;
    document.getElementById('coin2-name').textContent = selectedForComparison[1].name;
    
    // Destruir gráficos anteriores si existen
    const chart1 = Chart.getChart('comparison-chart1');
    const chart2 = Chart.getChart('comparison-chart2');
    if (chart1) chart1.destroy();
    if (chart2) chart2.destroy();
    
    renderChart('comparison-chart1', selectedForComparison[0].id, selectedForComparison[0].name);
    renderChart('comparison-chart2', selectedForComparison[1].id, selectedForComparison[1].name);
    
    // Desplazarse a la sección de comparación
    comparisonContainer.scrollIntoView({ behavior: 'smooth' });
}

// Inicializar botones de favoritos al cargar
updateFavoriteButtons();