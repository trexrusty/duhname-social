import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.svelte',
    ],
    theme: {
        extend: {
            colors: {
                'primary': '#000000',
                'secondary': '#121212',
                'tertiary': '#242424',
                'quaternary': '#363636',
                'verified': '#39f566',
                'bugfinder': '#fdba14',
              },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
