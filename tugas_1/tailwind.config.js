/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  // Aktifkan mode gelap berbasis 'class'
  darkMode: 'class', 
  content: [
    "./*.{html,js}" // Cari kelas Tailwind di file HTML dan JS
  ],
  theme: {
    extend: {
      // Menambahkan font Inter untuk nuansa iOS
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
      },
      // Menambahkan warna kustom dari desain kita
      colors: {
        'ios-primary': '#007AFF',
        'ios-secondary': '#FF9500',
        'ios-bg-light': '#F2F2F7',
        'ios-bg-dark': '#1C1C1E',
        'ios-card-light': '#FFFFFF',
        'ios-card-dark': '#2C2C2E',
      }
    },
  },
  plugins: [
    // Opsional, untuk styling form yang lebih baik
    require('@tailwindcss/forms'), 
  ],
}