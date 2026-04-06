/** @type {import('tailwindcss').Config} */
export default {
    prefix: 'tw-',
    content: ["./resources/**/*.blade.php"],
    theme: {
        extend: {
            colors: {
                'dark-green': '#323329',
                'dark-green-hover': '#2a2a22',
                'light-gray': '#E6E2DF',
                'orange': '#C47C4C',
                'dark-orange': '#b36b3c'
            },
        },
    },
    plugins: [],
}