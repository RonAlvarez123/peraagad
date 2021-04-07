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

mix.js('resources/js/app.js', 'public/js')
    // .sass('resources/css/app.css', 'public/css', [
    //     //
    // ]);
    .sass('resources/sass/auth/index.scss', 'public/css/auth', [])
    .sass('resources/sass/auth/show.scss', 'public/css/auth', [])
    .sass('resources/sass/profile/index.scss', 'public/css/profile', []);
