/** @type {import('tailwindcss').Config} */
module.exports = {
  purge: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  content: [],
  theme: {
    extend: {
      colors: {
        'custom-yellow': '#FFC600',
        'custom-grey': '#6E6E6E',
        'custom-dark-grey': '#1b1b1b',
      },
      height: {
        640: '640px'
      },
      gridTemplateColumns: {
        '14': 'repeat(14, minmax(0, 1fr))',
        '15': 'repeat(15, minmax(0, 1fr))',
      }
    }
  },
  plugins: []
}