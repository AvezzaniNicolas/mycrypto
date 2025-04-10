// main.js
document.addEventListener('DOMContentLoaded', () => {
    // Inicializar módulos
    DarkMode.init();
    ChartManager.initializeCharts();
    ComparisonManager.init();
    
    // Configurar eventos para nuevas tarjetas
    const observer = new MutationObserver(mutations => {
      mutations.forEach(mutation => {
        if (mutation.addedNodes.length) {
          ChartManager.initializeCharts();
          ComparisonManager.addComparisonButtons();
        }
      });
    });
    
    observer.observe(document.querySelector('.crypto-grid'), {
      childList: true,
      subtree: true
    });
  });