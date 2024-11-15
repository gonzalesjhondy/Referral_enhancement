const mix = require('laravel-mix');

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

/*mix.js('resources/assets/js/app.js', 'public/js').vue()
    .sass('resources/assets/sass/app.scss', 'public/css');*/


mix.js('resources/assets/js/app.js', 'public/js').vue()
    .js('resources/assets/js/app_layout.js', 'public/js').vue()
    .js('resources/assets/js/app_reco.js', 'public/js').vue()
    .js('resources/assets/js/app_doctor.js', 'public/js').vue()
    .js('resources/assets/js/app_login.js', 'public/js').vue()
    .js('resources/assets/js/app_video.js', 'public/js').vue()
    .js('resources/assets/js/app_video_pregnant.js', 'public/js').vue()
    .js('resources/assets/js/app_qr_referred.js', 'public/js').vue()
    .js('resources/assets/js/app_qr_edit.js', 'public/js').vue()
    .js('resources/assets/js/app_appointment.js', 'public/js').vue()
    .sass('resources/assets/sass/refer_panel.scss', 'public/css',
        {
            implementation: require('sass')
        }
    )
    .sass('resources/assets/sass/telemedicine_panel.scss', 'public/css', 
        {
            implementation: require('sass')
        }
    );