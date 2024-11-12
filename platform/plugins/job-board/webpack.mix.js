let mix = require('laravel-mix');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = 'platform/plugins/' + directory;
const dist = 'public/vendor/core/plugins/' + directory;

mix.js(source + '/resources/assets/js/components.js', dist + '/js').vue({ version: 2 });

mix
    .js(source + '/resources/assets/js/job.js', dist + '/js')
    .js(source + '/resources/assets/js/avatar.js', dist + '/js')
    .js(source + '/resources/assets/js/currencies.js', dist + '/js')
    .sass(source + '/resources/assets/sass/avatar.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/currencies.scss', dist + '/css');

mix
    .js(source + '/resources/assets/js/app.js', dist + '/js')
    .js(source + '/resources/assets/js/main.js', dist + '/js')
    .js(source + '/resources/assets/js/account-admin.js', dist + '/js')
    .js(source + '/resources/assets/js/employer-colleagues.js', dist + '/js')
    .js(source + '/resources/assets/js/global-custom-fields.js', dist + '/js')
    .js(source + '/resources/assets/js/custom-fields.js', dist + '/js')
    .js(source + '/resources/assets/js/bulk-import.js', dist + '/js')
    .js(source + '/resources/assets/js/export.js', dist + '/js')

    .sass(source + '/resources/assets/sass/account-admin.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/account.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/job-form.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/app.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/main.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/invoice.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/review.scss', dist + '/css')

    .copyDirectory(dist + '/js', source + '/public/js')
    .copyDirectory(dist + '/css', source + '/public/css');
