import typography from '@tailwindcss/typography'
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    safelist: ['prose'],
    theme: {
        extend: {},
    },
    plugins: [
        typography,
    ],
}
