/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.css",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#0473E4',
        'secondary': '#333333',
        'grey': '#757F95',
      }
    },
  },
  plugins: [],
}
