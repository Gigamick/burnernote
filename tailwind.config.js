/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Quicksand', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
