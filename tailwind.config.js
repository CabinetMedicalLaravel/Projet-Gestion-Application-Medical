import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
    "./resources/**/*.blade.php", // C'est cette ligne qui est CRUCIALE
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
    theme: {
        extend: {
            colors: {
                dental: {
                    'dark': '#0D47A1',   // Bleu Marine (Titres)
                    'main': '#1976D2',   // Bleu Royal (Boutons)
                    'accent': '#1E88E5', // Bleu Vif (Hover)
                    'light': '#2196F3',  // Bleu Ciel (Badges)
                    'soft': '#1565C0',   // Bleu Intermédiaire
                },
            },
        },
    },
};