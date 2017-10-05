const { mix } = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .less('resources/assets/less/dashboard/app.less', 'public/css/dashboard.css')
   .less('resources/assets/less/app.less', 'public/css/utilities.css')
   .sass('resources/assets/sass/site/app.scss', 'public/css/site.css');
