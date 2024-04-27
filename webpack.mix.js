const mix = require('laravel-mix');

mix.babel('resources/js/app.js', 'public/js/app.js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/admin.scss', 'public/css')
