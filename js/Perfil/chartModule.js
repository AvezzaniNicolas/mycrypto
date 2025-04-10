// chartModule.js
const ChartManager = {
    async fetchChartData(cryptoId) {
      try {
        const response = await fetch(
          `https://api.coingecko.com/api/v3/coins/${cryptoId}/market_chart?vs_currency=usd&days=7`
        );
        if (!response.ok) throw new Error(`API Error: ${response.status}`);
        return await response.json();
      } catch (error) {
        console.error('Error fetching chart data:', error);
        throw error;
      }
    },
  
    processChartData(data) {
      return {
        prices: data.prices.map(price => price[1]),
        dates: data.prices.map(price => 
          new Date(price[0]).toLocaleDateString('es-ES', { weekday: 'short' })
        )
      };
    },
  
    createChart(canvasId, cryptoName, chartData) {
      const ctx = document.getElementById(canvasId).getContext('2d');
      return new Chart(ctx, {
        type: 'line',
        data: {
          labels: chartData.dates,
          datasets: [{
            label: `Precio de ${cryptoName} (7 días)`,
            data: chartData.prices,
            borderColor: '#6c5ce7',
            backgroundColor: 'rgba(108, 92, 231, 0.1)',
            tension: 0.4,
            fill: true
          }]
        },
        options: {
          responsive: true,
          plugins: { legend: { position: 'top' } },
          scales: { y: { beginAtZero: false } }
        }
      });
    },
  
    async renderChart(canvasId, cryptoId, cryptoName) {
      const canvasElement = document.getElementById(canvasId);
      if (!canvasElement) {
        console.error(`Canvas no encontrado: ${canvasId}`);
        return;
      }
  
      try {
        const rawData = await this.fetchChartData(cryptoId);
        const chartData = this.processChartData(rawData);
        this.createChart(canvasId, cryptoName, chartData);
      } catch (error) {
        canvasElement.parentElement.innerHTML = `
          <p class="chart-error">No se pudo cargar el gráfico</p>
        `;
      }
    },
  
    initializeCharts() {
      document.querySelectorAll('.crypto-card').forEach(card => {
        const cryptoId = card.getAttribute('data-id');
        const cryptoName = card.querySelector('h2').textContent;
        const canvasId = `chart-${cryptoId}`;
        
        if (document.getElementById(canvasId)) {
          this.renderChart(canvasId, cryptoId, cryptoName);
        }
      });
    }
  };