import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // We voegen Inter toe als standaard sans font
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                // We voegen Cormorant toe als serif font (voor titels)
                serif: ['Cormorant', ...defaultTheme.fontFamily.serif],
            },
            // Hier voegen we kleurenpalet toe
            colors: {
                primary: '#3E2C22',    // Donkerbruin
                secondary: '#8C7B70',  // Taupe/Grijs-bruin
                nude: '#FDFBF7',       // Achtergrond warm wit
                beige: '#F5F0EB',      // Lichte achtergrond vlakken
                border: '#EAE5DE',     // Lichte lijnen
                softpink: '#D4A59A',   // Accent
            }
        },
    },

    plugins: [forms],
};
