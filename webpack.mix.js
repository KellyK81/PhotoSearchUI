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

mix.copy('resources/js/main.js', 'public/js/main.js');
mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/main.css', 'public/css')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ])
    .postCss('resources/css/search.css', 'public/css', [
        //
    ])
    .postCss('resources/css/login.css', 'public/css', [
        //
    ]);
