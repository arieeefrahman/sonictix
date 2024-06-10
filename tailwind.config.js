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
      },
      fontFamily: {
        lato: ['Lato', 'sans-serif'],
      },
    },
  },
  plugins: [],
}

