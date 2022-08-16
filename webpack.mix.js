const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.sass('resources/scss/main.scss', 'public/css/main.css');
// mix.sass('resources/scss/app.scss', 'public/css/app.css');
mix.js("resources/js/main.js","public/js")
    .extract()
    .version();
// mix.js(['resources/js/main.js'], 'public/js/main.js');
// mix.js(['resources/js/app.js'], 'public/js/app.js');

// mix.css(['public/css/main.css'],'public/css/main-mix.css');
