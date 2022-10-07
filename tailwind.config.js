const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                page:'var(--page-bg-color)',
                card:'var(--card-bg-color)',
                button:'var(--button-bg-color)',
                nav:'var(--nav-bg-color)',
                'default-color':'var(--text-default)',
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
