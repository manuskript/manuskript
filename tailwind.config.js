const typography = require("./src/client/TipTap/tailwind");

module.exports = {
    theme: {
        extend: {typography},
    },
    content: ["./src/client/**/*.{js,jsx}"],
    plugins: [require("@tailwindcss/forms"), require("@tailwindcss/typography")],
};
