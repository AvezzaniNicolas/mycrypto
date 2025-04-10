// darkModeModule.js
const DarkMode = {
    init() {
      this.toggle = document.getElementById('dark-mode-toggle');
      this.body = document.body;
      this.loadPreference();
      this.toggle.addEventListener('change', () => this.toggleMode());
    },
  
    loadPreference() {
      if (localStorage.getItem('darkMode') === 'enabled') {
        this.body.classList.add('dark-mode');
        this.toggle.checked = true;
      }
    },
  
    toggleMode() {
      if (this.toggle.checked) {
        this.body.classList.add('dark-mode');
        localStorage.setItem('darkMode', 'enabled');
      } else {
        this.body.classList.remove('dark-mode');
        localStorage.setItem('darkMode', 'disabled');
      }
    }
  };