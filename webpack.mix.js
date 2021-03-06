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
    .js('resources/js/getcode/copyToClipboard.js', 'public/js/getcode')
    .js('resources/js/receipt/fileUpload.js', 'public/js/receipt')
    // .sass('resources/css/app.css', 'public/css', [
    //     //
    // ]);
    .sass('resources/sass/auth/index.scss', 'public/css/auth', [])
    .sass('resources/sass/auth/create.scss', 'public/css/auth', [])
    .sass('resources/sass/profile/index.scss', 'public/css/profile', [])
    .sass('resources/sass/coderequests/index.scss', 'public/css/coderequests', [])
    .sass('resources/sass/coderequests/show.scss', 'public/css/coderequests', [])
    .sass('resources/sass/getcode/create.scss', 'public/css/getcode', [])
    .sass('resources/sass/getcode/index.scss', 'public/css/getcode', [])
    .sass('resources/sass/admincaptcha/create.scss', 'public/css/admincaptcha', [])
    .sass('resources/sass/usercaptcha/edit.scss', 'public/css/usercaptcha', [])
    .sass('resources/sass/receipt/edit.scss', 'public/css/receipt', [])
    .sass('resources/sass/colorgame/edit.scss', 'public/css/colorgame', [])
    .sass('resources/sass/about/index.scss', 'public/css/about', [])
    .sass('resources/sass/cashoutrequests/admin/index.scss', 'public/css/cashoutrequests/admin', [])
    .sass('resources/sass/cashoutrequests/admin/show.scss', 'public/css/cashoutrequests/admin', [])
    .sass('resources/sass/cashoutrequests/user/index.scss', 'public/css/cashoutrequests/user', []);
