/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
    './resources/css/**/*.css',
    './public/**/*.html',
    './app/**/*.php',
    './resources/**/*.js',
  ],
  theme: {
    screens: {
      sm: '480px',
      md: '768px',
      lg: '976px',
      xl: '1440px',
    },
    extend: {
      colors: {
        brightBlue: '#0364b5',
        brightWhite: '#f8f9fa',
        brightBlueHover: '#025b9f',
      },
      fontFamily: {
        lato: ['Lato', 'sans-serif'],
      },
      boxShadow: {
        eventDetail: '0 0 10px rgba(0, 0, 0, 0.1)',
      }
    },
  },
  plugins: [],
}

