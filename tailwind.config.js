/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./app/Http/Controllers/*.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {},
    plugins: [
        require('flowbite/plugin')
    ],
    darkMode: 'class',
}
