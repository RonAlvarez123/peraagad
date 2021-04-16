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
    .sass('resources/sass/profile/index.scss', 'public/css/profile', [])
    .sass('resources/sass/coderequests/index.scss', 'public/css/coderequests', [])
    .sass('resources/sass/getcode/create.scss', 'public/css/getcode', [])
    .sass('resources/sass/getcode/index.scss', 'public/css/getcode', [])
    .sass('resources/sass/admincaptcha/create.scss', 'public/css/admincaptcha', [])
    .sass('resources/sass/usercaptcha/create.scss', 'public/css/usercaptcha', [])
    .sass('resources/sass/receipt/edit.scss', 'public/css/receipt', [])
    .sass('resources/sass/colorgame/edit.scss', 'public/css/colorgame', []);
