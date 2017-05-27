var gulp = require("gulp"),
    shell = require("gulp-shell"),
    elixir = require("laravel-elixir");

elixir.config.sourcemaps = false;

elixir.extend("message", function(message) {

    new elixir.Task("message", function() {
        gulp.src("").pipe(shell("node " + message));
    });

});

elixir(function(mix) {
    mix.message("-v");
});