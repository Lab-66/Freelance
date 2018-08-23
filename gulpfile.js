var gulp = require("gulp");
var bower = require("gulp-bower");
var elixir = require("laravel-elixir");

gulp.task('bower', function () {
    return bower();
});
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 */
var vendors = '../../assets/vendors/';

var paths = {
    'jquery': vendors + 'jquery/dist',
    'jqueryUi': vendors + 'jquery-ui',
     'moment': vendors + 'moment',
    'bootstrap': vendors + 'bootstrap/dist',
    'dataTables': vendors + 'datatables/media',
    'fontawesome': vendors + 'font-awesome',
    'animate': vendors + 'animate.css',
    'underscore': vendors + 'underscore',
    'tether': vendors + 'tether/dist',
    'jQueryStorageAPI': vendors + 'jQuery-Storage-API',
    'pace': vendors + 'PACE',
    'lazyload': vendors + 'lazyload',
    'screenfull': vendors + 'screenfull/dist',
    'select2': vendors + 'select2/dist',
    'eonasdanBootstrapDatetimepicker': vendors + 'eonasdan-bootstrap-datetimepicker/build',
    'fullcalendar': vendors + 'fullcalendar/dist',
    'summernote': vendors + 'summernote/dist',
    'morris': vendors + 'morris.js',
    'raphael': vendors + 'raphael',
    'pusher': vendors + 'pusher/dist/',
    'icheck': vendors + 'iCheck',
    'jasnyBootstrap': vendors + 'jasny-bootstrap/dist',
    'toastr': vendors + 'toastr/',
    'dropzone': vendors + 'dropzone/dist',
    'bootstrapValidator' : vendors + 'bootstrapvalidator/dist',
    'select2BootstrapTheme': vendors + 'select2-bootstrap-theme/dist',
    'c3': vendors + '/c3/'
};

elixir.config.sourcemaps = false;

elixir(function (mix) {

    // Run bower install
    mix.task('bower');

    //Custom Styles
    mix.styles(
        [
            'lcrm_bootstrap.css', 'metisMenu.min.css', 'lcrm.css', 'mail.css'
        ], 'public/css/secure.css');

    //Custom Javascript
    mix.browserify(['app.js'], 'public/js/secure.js');


    /**
     * Vendor files
     * run "gulp --production"
     */
    if (elixir.config.production) {
        // Copy js straight to public
        mix.copy('resources/assets/js/metisMenu.min.js', 'public/js');
        mix.copy('resources/assets/js/lcrm_app.js', 'public/js');
        mix.copy('resources/assets/js/todolist.js', 'public/js');

        // Copy fonts straight to public
        mix.copy('resources/assets/vendors/bootstrap/fonts', 'public/fonts');
        mix.copy('resources/assets/vendors/font-awesome/fonts', 'public/fonts');
        mix.copy('resources/assets/css/material-design-icons/iconfont', 'public/fonts');

        // Copy images straight to public
        mix.copy('resources/assets/vendors/bootstrap-fileinput/img', 'public/img');
        mix.copy('resources/assets/vendors/jquery-ui/themes/base/images', 'public/img');
        mix.copy('resources/assets/vendors/datatables/media/images', 'public/img');

        mix.copy('resources/assets/img', 'public/img');
        mix.copy('resources/assets/images', 'public/images');
        mix.copy('resources/assets/img/logo.png', 'public/uploads/site');
        mix.copy('resources/assets/img/fav.ico', 'public/uploads/site');
        mix.copy('resources/assets/img/user.png', 'public/uploads/avatar');

        // copy js files ( we don't need to combine all files into single js)
        mix.copy('resources/assets/vendors/screenfull/dist/screenfull.min.js', 'public/js');

        //c3&d3 chart css and js files
        mix.copy('resources/assets/vendors/c3/c3.min.css', 'public/css');
        mix.copy('resources/assets/vendors/c3/c3.min.js', 'public/js');
        mix.copy('resources/assets/vendors/d3/d3.min.js', 'public/js');
        mix.copy('resources/assets/js/d3.v3.min.js', 'public/js');

        //jvector map files
        mix.copy('resources/assets/vendors/bower-jvectormap/jquery-jvectormap-1.2.2.min.js', 'public/js');
        mix.copy('resources/assets/css/jquery-jvectormap.css', 'public/css');
        mix.copy('resources/assets/vendors/bower-jvectormap/jquery-jvectormap-world-mill-en.js', 'public/js');
        mix.copy('resources/assets/js/jquery-jvectormap-us-aea-en.js', 'public/js');

        // install
        mix.copy('resources/assets/css/custom_install.css','public/css');
        mix.copy('resources/assets/js/custom_install.js', 'public/js');

        //icheck
        mix.copy('resources/assets/css/icheck.css','public/css');
        mix.copy('resources/assets/vendors/iCheck/icheck.min.js','public/js');

        //countUp
        mix.copy('resources/assets/vendors/countUp.js/dist/countUp.min.js', 'public/js');


        //CSS Libraries
        mix.styles([paths.fontawesome + "/css/font-awesome.min.css",
            paths.animate + "/animate.min.css",
            "resources/assets/css/material-design-icons/material-design-icons.css",
            paths.select2 + "/css/select2.min.css",
            paths.eonasdanBootstrapDatetimepicker + '/css/bootstrap-datetimepicker.css',
            'dataTables.bootstrap.css',
            paths.fullcalendar + '/fullcalendar.css',
            paths.summernote + '/summernote.css',
            paths.summernote + '/summernote-bs3.css',
            paths.morris + '/morris.css',
            paths.bootstrapValidator + '/css/bootstrapValidator.min.css',
            paths.dropzone + '/dropzone.css',
            paths.jasnyBootstrap + "/css/jasny-bootstrap.min.css",
            paths.toastr + '/toastr.css',
            paths.select2BootstrapTheme + "/select2-bootstrap.min.css"
        ], 'public/css/libs.css');


        //JS Libraries
        mix.scripts([paths.jquery + "/jquery.js",
            paths.jqueryUi + "/jquery-ui.min.js",
            paths.tether + "/js/tether.min.js",
            paths.bootstrap + "/js/bootstrap.min.js",
            paths.dataTables + "/js/jquery.dataTables.min.js",
            paths.dataTables + "/js/dataTables.bootstrap.js",
            paths.pace + '/pace.min.js',
            paths.underscore + "/underscore-min.js",
            paths.select2 + "/js/select2.min.js",
            paths.moment + '/moment.js',
            paths.eonasdanBootstrapDatetimepicker + '/js/bootstrap-datetimepicker.min.js',
            paths.fullcalendar + '/fullcalendar.js',
            paths.summernote + '/summernote.js',
            paths.morris + '/morris.js',
            paths.raphael + '/raphael.js',
            paths.pusher + '/pusher.js',
            paths.toastr + 'toastr.min.js',
            paths.bootstrapValidator + '/js/bootstrapValidator.min.js',
            paths.jasnyBootstrap +  "/js/jasny-bootstrap.min.js",
            "palette.js"
        ], 'public/js/libs.js');
    }
});
