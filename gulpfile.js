var elixir = require('laravel-elixir');

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
    mix
    .sass( ["authentication.scss"], "public/package/ensphere/authentication/css")
    .scripts( ["authentication.js"], "public/package/ensphere/authentication/js/")
    .copy("resources/assets/images/", "public/package/ensphere/authentication/images/");

});
