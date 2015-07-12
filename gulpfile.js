var elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');

    mix.styles([
        'vendor/laravel.css',
        'app.css'
    ], null, 'public/css');

    //mix.coffee([
    //    'lib/license.coffee',
    //    'lib/*.coffee',
    //
    //    'app/app.coffee',
    //    'app/config.coffee',
    //    'app/*.coffee',
    //
    //    'collections/collection.coffee',
    //    'collections/*.coffee',
    //
    //    'models/model.coffee',
    //    'models/*.coffee',
    //
    //    'views/view.coffee',
    //    'views/*.coffee',
    //
    //    'templates/*.coffee',
    //
    //    'application.coffee'
    //]);
    //
    //mix.scripts(null, 'public/js/vendor.js', 'resources/assets/coffee/vendor');

    mix.scripts([
        'pubsub.js',
        'ajax-helper.js',
        'subscribe.js'
    ], null, 'public/js');


});
