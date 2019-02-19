const workboxPlugin = require('workbox-webpack-plugin')
const mix = require('laravel-mix')
 
if (mix.inProduction()) {
    mix.webpackConfig({
        plugins: [
            new workboxPlugin.InjectManifest({
                swSrc: 'public/sw-offline.js', // more control over the caching
                swDest: 'sw.js', // the service-worker file name
                importsDirectory: 'service-worker' // have a dedicated folder for sw files
            })
        ]
    })
}

mix.less('resources/assets/less/app.less', 'public/css/')
   .version('public/css/app.css');

mix.js('resources/assets/js/app.js', 'public/js/');

