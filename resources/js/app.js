import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Theme store for Dark/Light mode persistence
Alpine.store('theme', {
    dark: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggle() {
        this.dark = !this.dark;
        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
        this.apply();
    },
    apply() {
        if (this.dark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    },
    init() {
        this.apply();
    }
});

// Toast notification helper
Alpine.store('toast', {
    show: false,
    message: '',
    type: 'success', // success, error, info
    notify(msg, type = 'success') {
        this.message = msg;
        this.type = type;
        this.show = true;
        setTimeout(() => {
            this.show = false;
        }, 4000);
    }
});

Alpine.start();
