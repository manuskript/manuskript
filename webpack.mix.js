const mix = require("laravel-mix");

mix.setPublicPath("dist");

mix.js("src/client/manuskript.jsx", "dist").react();

mix.postCss("src/client/manuskript.css", "dist", [require("tailwindcss")]);

if (mix.inProduction()) {
    mix.version();
}
