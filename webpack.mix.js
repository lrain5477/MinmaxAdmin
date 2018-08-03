let mix = require('laravel-mix');


mix.js('resources/assets/js/pages/index.js', 'public/static/scripts')
mix.sass('resources/assets/sass/style.sass', 'public/static/styles');

mix.browserSync({
    proxy: '127.0.0.1:8000',
    files: [
        'resources/assets/sass/**/*.sass',
        'resources/assets/sass/style.sass',
        'resources/assets/js/**/*.js',
        'resources/assets/js/*.js',
        'resources/views/web/**/*.blade.php'
    ]
});

mix.copyDirectory('resources/assets/fonts', 'public/static/fonts');
mix.copyDirectory('resources/assets/img/static', 'public/static/img');
mix.copyDirectory('resources/assets/img/files', 'public/files');
