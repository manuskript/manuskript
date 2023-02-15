const mix = require("laravel-mix");
const path = require("path");

mix.setPublicPath("public");

mix.js("resources/js/manuskript.jsx", "public").react();

mix.postCss("resources/css/manuskript.css", "public", [require("tailwindcss")]);

mix.alias({
    '~': path.join(__dirname, 'resources/js')
});

if (mix.inProduction()) {
    mix.version();
}
