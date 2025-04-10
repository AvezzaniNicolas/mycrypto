// comparisonModule.js
const ComparisonManager = {
    maxSelection: 2,
    selected: [],
    elements: {
      compareBtn: document.getElementById('compare-btn'),
      comparisonContainer: document.getElementById('comparison-container'),
      closeComparison: document.getElementById('close-comparison')
    },
  
    init() {
      this.setupEventListeners();
      this.updateUI();
    },
  
    setupEventListeners() {
      this.elements.compareBtn.addEventListener('click', () => this.compare());
      this.elements.closeComparison.addEventListener('click', () => this.reset());
      
      // Delegación de eventos para los botones de selección
      document.addEventListener('click', (e) => {
        if (e.target.classList.contains('select-btn')) {
          this.handleSelection(e);
        }
      });
    },
  
    handleSelection(event) {
      event.preventDefault();
      const card = event.target.closest('.crypto-card');
      const cryptoId = card.getAttribute('data-id');
      const cryptoName = card.querySelector('h2').textContent;
      
      const index = this.selected.findIndex(item => item.id === cryptoId);
      if (index === -1) {
        if (this.selected.length < this.maxSelection) {
          this.selected.push({ id: cryptoId, name: cryptoName });
          event.target.textContent = 'Deseleccionar';
        } else {
          alert(`Solo puedes seleccionar ${this.maxSelection} criptomonedas`);
          return;
        }
      } else {
        this.selected.splice(index, 1);
        event.target.textContent = 'Seleccionar para comparar';
      }
      
      this.updateSelectedCards();
      this.updateUI();
    },
  
    updateSelectedCards() {
      document.querySelectorAll('.crypto-card').forEach(card => {
        const cryptoId = card.getAttribute('data-id');
        const isSelected = this.selected.some(item => item.id === cryptoId);
        
        card.classList.toggle('selected', isSelected);
      });
    },
  
    updateUI() {
      this.elements.compareBtn.textContent = `Comparar (${this.selected.length}/${this.maxSelection})`;
      this.elements.compareBtn.disabled = this.selected.length !== this.maxSelection;
    },
  
    async compare() {
      if (this.selected.length !== this.maxSelection) {
        alert(`Selecciona exactamente ${this.maxSelection} criptomonedas`);
        return;
      }
      
      this.elements.comparisonContainer.style.display = 'block';
      document.getElementById('coin1-name').textContent = this.selected[0].name;
      document.getElementById('coin2-name').textContent = this.selected[1].name;
      
      // Destruir gráficos existentes
      ['comparison-chart1', 'comparison-chart2'].forEach(id => {
        const chart = Chart.getChart(id);
        if (chart) chart.destroy();
      });
      
      // Renderizar nuevos gráficos
      await ChartManager.renderChart('comparison-chart1', this.selected[0].id, this.selected[0].name);
      await ChartManager.renderChart('comparison-chart2', this.selected[1].id, this.selected[1].name);
      
      this.elements.comparisonContainer.scrollIntoView({ behavior: 'smooth' });
    },
  
    reset() {
      this.elements.comparisonContainer.style.display = 'none';
      this.selected = [];
      this.updateSelectedCards();
      this.updateUI();
    },
  
    addComparisonButtons() {
      document.querySelectorAll('.crypto-card:not(.has-comparison-btn)').forEach(card => {
        card.classList.add('has-comparison-btn');
        const selectBtn = document.createElement('button');
        selectBtn.className = 'select-btn btn';
        selectBtn.textContent = 'Seleccionar para comparar';
        
        const actionsDiv = card.querySelector('.crypto-actions') || 
                          card.querySelector('.crypto-header') || 
                          card;
        actionsDiv.appendChild(selectBtn);
      });
    }
  };