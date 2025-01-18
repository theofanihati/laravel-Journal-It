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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            customPink1: '#ffe9ec',
            customPink2: '#f5b6be',
            customPink3: '#de8bb0',
            customPurple1: '#cea9c6',
            customGray1: '#d9d9d9',
            customGray2: '#a6a6a6',
            customGray3: '#737373',
            red: '#ff3131',
            white: '#ffffff',
            black: '#000000',
        }
    },

    plugins: [forms],
};
