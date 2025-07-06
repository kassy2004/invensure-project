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
            fontSize: {
                'xxs': '0.625rem', // 10px
              },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'brand-gold': '#FFD700',
                'brand-orange': '#FF6B35',
                'brand-crimson': '#DC143C',
            },
        },
    },

    plugins: [forms, require('daisyui')],
    
    daisyui: {
        themes: [
            {
                invensure: {
                    "primary": "#FF6B35",
                    "secondary": "#FFD700",
                    "accent": "#DC143C",
                    "neutral": "#191D24",
                    "base-100": "#ffffff",
                    "info": "#3ABFF8",
                    "success": "#36D399",
                    "warning": "#FBBD23",
                    "error": "#F87272",
                },
            },
        ],
    },
};
