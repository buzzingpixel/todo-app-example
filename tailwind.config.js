/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.phtml"],
  theme: {
    extend: {},
  },
  plugins: [
      require('@tailwindcss/forms'),
  ],
}

