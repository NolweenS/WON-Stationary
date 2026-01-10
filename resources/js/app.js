import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Global Loading State Handler
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Check if form is valid first (HTML5 validation)
            if (!this.checkValidity()) return;

            // Find the submit button
            const submitBtn = this.querySelector('button[type="submit"]');

            if (submitBtn && !submitBtn.classList.contains('no-loading')) {
                // Prevent double submission
                if (submitBtn.disabled) {
                    e.preventDefault();
                    return;
                }

                // Store original content
                const originalContent = submitBtn.innerHTML;
                const originalWidth = submitBtn.offsetWidth;

                // Set fixed width to prevent jumping
                submitBtn.style.width = `${originalWidth}px`;

                // Disable button and show spinner
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75', 'cursor-wait');
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="inline-block">Laden...</span>
                `;

                // If the form submission is prevented by other scripts (like AJAX),
                // we might need to reset this. But for standard forms, the page reload handles it.
            }
        });
    });
});
