export default {
    content: [
        "./resources/**/*.{js,ts,jsx,tsx,vue,blade.php}",
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/aspect-ratio'),
    ],
    darkMode: 'selector',
}