const typography = require("./src/TipTap/tailwind");

module.exports = {
    theme: {
        extend: {typography},
    },
    content: ["./src/**/*.{js,jsx}"],
    plugins: [require("@tailwindcss/typography")],
};
