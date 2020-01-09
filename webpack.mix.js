const mix = require('laravel-mix');
const webpack = require('webpack');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix
    .copy('node_modules/jquery-toast-plugin/dist/jquery.toast.min.js', 'public/js/jquery.toast.min.js') // JS jquery.toast
    .copy('node_modules/lightgallery/dist/js/lightgallery.min.js', 'public/js/lightgallery.min.js')  // JS > lightgalerry
    .copy('node_modules/summernote/dist/summernote.js', 'public/js/summernote.js') // JS > summernote
    .copy('node_modules/sweetalert/dist/sweetalert.min.js', 'public/js/sweetalert.min.js') // JS > sweetalert
    .copy('node_modules/datatables.net/js/jquery.dataTables.min.js', 'public/js/jquery.dataTables.min.js') // JS > datatables.net
    .copy('node_modules/datatables.net-bs/js/dataTables.bootstrap.min.js', 'public/js/dataTables.bootstrap.min.js') // JS > datatables.net-bs
    .copy('node_modules/datatables.net-bs/css/dataTables.bootstrap.min.css', 'public/css/dataTables.bootstrap.min.css') // CSS > datatables.net-bs
    .copy('node_modules/font-awesome/css/font-awesome.min.css', 'public/css/font-awesome.min.css'); // CSS > font-awesome
