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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['"Space Grotesk"', 'Inter', ...defaultTheme.fontFamily.sans],
                mono: ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', 'monospace'],
            },
            colors: {
                brand: {
                    darkest: '#0D0D0D',  // Deep Charcoal (Page background)
                    dark: '#171717',     // Charcoal (Card & container surfaces)
                    concrete: '#242424', // Dark Concrete (Borders & elevated panels)
                    medium: '#525252',   // Medium Gray (Gridlines & structural lines)
                    muted: '#A3A3A3',    // Muted Gray (Secondary typography)
                    offwhite: '#F3F1EC', // Off White (High-contrast body & numbers)
                    white: '#FFFFFF',    // Pure White (Headings)
                    orange: '#E05A1B',   // Muted Construction Orange / Amber
                    'orange-light': '#F97316',
                    'orange-dark': '#C2410C',
                    yellow: '#E5A93C',   // Restrained Caution Yellow / Ochre
                },
                primary: {
                    DEFAULT: '#E05A1B',
                    hover: '#C2410C',
                    light: '#F97316',
                },
            },
            boxShadow: {
                'industrial-card': '0 4px 20px -2px rgba(0, 0, 0, 0.7), 0 0 0 1px #242424',
                'industrial-hover': '0 12px 30px -4px rgba(0, 0, 0, 0.8), 0 0 0 1px #E05A1B',
                'glow-orange': '0 0 30px rgba(224, 90, 27, 0.25)',
                'glow-amber': '0 0 30px rgba(229, 169, 60, 0.2)',
            },
            backgroundImage: {
                'blueprint-pattern': 'radial-gradient(circle, #242424 1px, transparent 1px)',
            },
        },
    },

    plugins: [forms],
};
