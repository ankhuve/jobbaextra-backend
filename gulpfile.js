var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    //mix.scriptsIn('resources/assets/js');

    mix.sass('app.scss')
        .browserify(['pubsub.js', 'app.js'])
        .browserSync({
            proxy: 'jobbaextra-back.app',
            port: 4000
        });

});
