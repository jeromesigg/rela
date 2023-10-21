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

mix.styles([
    'resources/css/bootstrap.css',
    'resources/css/datatables.css',
    'resources/css/jquery-ui.css',
    'resources/css/jquery.mCustomScrollbar.css',
    'resources/css/style.default.premium.css',
    'resources/css/custom.css',
    'resources/css/welcome.css',
], 'public/css/libs.css')
    .postCss("resources/css/app.css", "public/css", [
        require("tailwindcss")]);
mix.scripts([
    'resources/js/jquery.js',
    'resources/js/jquery-ui.js',
    'resources/js/bootstrap.js',
    'resources/js/datatables.js',
    'resources/js/jquery.mCustomScrollbar.js',
    'resources/js/front.js',
    'resources/js/jqBootstrapValidation.js',
    'resources/js/sweetalert.min.js',
    'resources/js/custom.js',
], 'public/js/app.js');

