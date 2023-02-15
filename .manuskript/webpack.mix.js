const mix = require("laravel-mix");

mix.setPublicPath("dist");

mix.js("src/manuskript.jsx", "dist").react();

mix.postCss("src/manuskript.css", "dist", [require("tailwindcss")]);
