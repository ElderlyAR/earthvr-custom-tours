import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import persist from '@alpinejs/persist';
import axios from 'axios';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.plugin(focus);
Alpine.plugin(persist);
Alpine.start();

// Set up CSRF token for axios
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}

// Global event bus
window.EventBus = {
    events: {},
    
    on(event, callback) {
        if (!this.events[event]) {
            this.events[event] = [];
        }
        this.events[event].push(callback);
    },
    
    off(event, callback) {
        if (this.events[event]) {
            this.events[event] = this.events[event].filter(cb => cb !== callback);
        }
    },
    
    emit(event, data) {
        if (this.events[event]) {
            this.events[event].forEach(callback => callback(data));
        }
    }
};

// Auto-dismiss alerts after 5 seconds
document.addEventListener('DOMContentLoaded', () => {
    const alerts = document.querySelectorAll('[role="alert"]');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 500);
            }
        }, 5000);
    });
});

// Form validation helpers
window.validateForm = {
    isEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    },
    
    isNumeric(value) {
        return !isNaN(parseFloat(value)) && isFinite(value);
    },
    
    isRequired(value) {
        return value !== null && value !== undefined && value.trim() !== '';
    },
    
    minLength(value, length) {
        return value.length >= length;
    },
    
    maxLength(value, length) {
        return value.length <= length;
    }
};

// Accessibility improvements
document.addEventListener('keydown', (e) => {
    // Add keyboard navigation for custom components
    if (e.key === 'Escape') {
        // Close any open modals or dropdowns
        const modals = document.querySelectorAll('[x-data][x-show]');
        modals.forEach(modal => {
            if (modal.__x && modal.__x.$data.open) {
                modal.__x.$data.open = false;
            }
        });
    }
});

// Detect dark mode preference
if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    document.documentElement.classList.add('dark-mode-detected');
}

// Listen for dark mode changes
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
    if (e.matches) {
        document.documentElement.classList.add('dark-mode-detected');
    } else {
        document.documentElement.classList.remove('dark-mode-detected');
    }
});

// Initialize any components that need JavaScript
document.addEventListener('DOMContentLoaded', () => {
    // Add any component initialization here
});