/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      height :{
        'teria': '30rem',
      },
      width :{
        'jomar': '60rem',
      }
    },
  },
  plugins: [],
}