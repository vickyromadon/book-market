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
    .copy('node_modules/jquery-toast-plugin/dist/jquery.toast.min.js', 'public/js/jquery.toast.min.js')
    .copy('node_modules/lightgallery/dist/js/lightgallery.min.js', 'public/js/lightgallery.min.js')
    .copy('node_modules/summernote/dist/summernote.js', 'public/js/summernote.js')
    .copy('node_modules/sweetalert/dist/sweetalert.min.js', 'public/js/sweetalert.min.js');
