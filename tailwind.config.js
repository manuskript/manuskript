module.exports = {
    theme: {
        extend: {
          fontWeight: {
            'inherit': 'inherit',
          }
        }
    },
    content: ["./resources/js/**/*.{js,jsx}"],
    plugins: [require("@tailwindcss/forms"), require("@tailwindcss/typography")],
};