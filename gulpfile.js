var elixir = require('laravel-elixir');

var gulp = require('gulp'),
    mjml = require('gulp-mjml'),
    rename = require('gulp-rename');

var config = Elixir.config;
var Task = Elixir.Task;

Elixir.extend('mjml', function(src, output, mjmlEngine) {
    var paths = prepGulpPaths(src, output);

    new Task('mjml', function() {
        gulp.src(paths.src.path)
            .pipe(mjml(mjmlEngine))
            .pipe(rename(function (path) {
                path.extname = '.blade.php'
            }))
            .pipe(gulp.dest(paths.output.path));
    })
        .watch(paths.src.baseDir + '/**/*.mjml')
        .ignore(paths.output.path);
});


/**
 * Prep the Gulp src and output paths.
 *
 * @param  {string|Array} src
 * @param  {string|null}  output
 * @return {GulpPaths}
 */
var prepGulpPaths = function(src, output) {
    return new Elixir.GulpPaths()
        .src(src || '/**/*.mjml', config.get('assets.email.mjml.folder'))
        .output(output || config.viewPath);
};

elixir.config.email = {
   mjml: {
      folder: 'mjml'
   }
};

elixir.config.sourcemaps = false;

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
   // CSS
   mix.sass([
      './node_modules/sweetalert/dist/sweetalert.css',
      './node_modules/intl-tel-input/build/css/intlTelInput.css'
   ], 'public/css/back/vendor.css');
   mix.sass('back/main.scss', 'public/css/back/main.css');

   mix.sass([
      './node_modules/intl-tel-input/build/css/intlTelInput.css',
      './node_modules/sweetalert/dist/sweetalert.css',
      './node_modules/slick-carousel/slick/slick.css'
   ], 'public/css/front/vendor.css');
   mix.sass('front/main.scss', 'public/css/front/main.css');

   mix.sass('front/tinymce.scss', 'public/css/front/tinymce.css');

   // JS
   mix.scripts([
      './node_modules/jquery/dist/jquery.min.js',
      './node_modules/jquery-ui-bundle/jquery-ui.min.js',
      './node_modules/sweetalert/dist/sweetalert.min.js',
      './node_modules/intl-tel-input/build/js/intlTelInput.min.js',
      './resources/assets/js/back/vendor/*.js'
   ], 'public/js/back/vendor.js', './');

   mix.scripts('./node_modules/intl-tel-input/build/js/utils.js', 'public/js/back/utils-intltelinput.js');
   mix.scripts('./node_modules/intl-tel-input/build/js/utils.js', 'public/js/front/utils-intltelinput.js');

   mix.scripts(['back/functions.js', 'back/app.js'], 'public/js/back/app.js');
   mix.scripts('back/company.js', 'public/js/back/company.js');
   mix.scripts('back/user.js', 'public/js/back/user.js');
   mix.scripts('back/project.js', 'public/js/back/project.js');

   mix.scripts([
      './node_modules/jquery/dist/jquery.min.js',
      './node_modules/jquery-ui-bundle/jquery-ui.min.js',
      './node_modules/intl-tel-input/build/js/intlTelInput.min.js',
      './node_modules/selectric/public/jquery.selectric.min.js',
      './node_modules/sweetalert/dist/sweetalert.min.js',
      './node_modules/slick-carousel/slick/slick.min.js',
      './node_modules/autonumeric/dist/autoNumeric.min.js',
      './node_modules/gsap/TweenMax.js',
      './resources/assets/js/front/modernizr.js'
   ], 'public/js/front/vendor.js', './');

   mix.scripts(['front/functions.js', 'front/app.js'], 'public/js/front/app.js');
   mix.scripts('front/home.js', 'public/js/front/home.js');
   mix.scripts('front/register.js', 'public/js/front/register.js');
   mix.scripts('front/help.js', 'public/js/front/help.js');
   mix.scripts('front/project.js', 'public/js/front/project.js');
   mix.scripts('front/steering.js', 'public/js/front/steering.js');
   mix.scripts('front/parameters.js', 'public/js/front/parameters.js');
   mix.scripts('front/match.js', 'public/js/front/match.js');
   mix.scripts('front/teaser.js', 'public/js/front/teaser.js');
   mix.scripts('front/signatory.js', 'public/js/front/signatory.js');
   mix.scripts('front/discussion.js', 'public/js/front/discussion.js');
   mix.scripts('front/nda.js', 'public/js/front/nda.js');
   mix.scripts('front/guests.js', 'public/js/front/guests.js');


   // TINYMCE
   mix.copy([
      './node_modules/tinymce'
   ], 'public/js/tinymce');

   // FILES
   mix.copy('./node_modules/intl-tel-input/build/img', 'public/img');

   mix.mjml();
});
