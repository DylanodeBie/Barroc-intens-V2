import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js', // Inclusief JS-bestanden
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            maxWidth: {
                '4xl': '1024px', // Brede containers
                '6xl': '1280px', // Optioneel
            },
            height: {
                'chart': '400px', // Specifieke grafiekhoogte
            },
        },
    },

    plugins: [forms],
};
