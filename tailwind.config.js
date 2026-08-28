import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
            },
            colors: {
                brand: {
                    black: '#050811',
                    charcoal: '#0a0f1d',
                    concrete: '#1e293b',
                    surface: '#0f172a',
                },
                purple: {
                    deep: '#3b0764',
                    dark: '#581c87',
                    DEFAULT: '#7e22ce',
                    light: '#a855f7',
                    glow: '#c084fc',
                },
                orange: {
                    DEFAULT: '#f97316',
                    hover: '#ea580c',
                    light: '#fdba74',
                },
                primary: {
                    DEFAULT: '#f97316', // Construction Orange
                    hover: '#ea580c',
                    light: '#fdba74',
                }
            },
            boxShadow: {
                'glow-purple': '0 0 30px rgba(126, 34, 206, 0.35)',
                'glow-orange': '0 0 30px rgba(249, 115, 22, 0.35)',
                'glass-card': '0 8px 32px 0 rgba(0, 0, 0, 0.37)',
            },
        },
    },

    plugins: [forms],
};
