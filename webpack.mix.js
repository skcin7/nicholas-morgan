const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

// JavaScript:
mix.js([
    "resources/js/app.js"
], "public/js/app.js")
    .sourceMaps()
    .version();

// CSS:
mix.sass("resources/sass/app.scss", "public/css/app.css")
    .sourceMaps()
    .version();



// JavaScript (Contra):
mix.js([
    "resources/js/contra.js"
], "public/js/contra.js")
    .sourceMaps()
    .version();

// CSS (Contra):
mix.sass("resources/sass/contra.scss", "public/css/contra.css")
    .sourceMaps()
    .version();
