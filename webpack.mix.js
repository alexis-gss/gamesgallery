const path = require('path');
const mix = require('laravel-mix');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
require('laravel-mix-polyfill');
mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve('resources/assets')
        }
    },
    plugins: [
        new CleanWebpackPlugin({
            cleanOnceBeforeBuildPatterns: [
                'js/*',
                'images/*',
                'fonts/*',
                'assets/*'
            ]
        })
    ],
});
let assetDir = 'assets';
mix.options({
    fileLoaderDirs: {
        images: `${assetDir}/images/global`,
        fonts: `${assetDir}/fonts`
    },
    postCss: [
        require('postcss-discard-comments')({
            removeAll: true
        })
    ]
});
// mix Backend
mix.js("resources/js/back/back.js", "public/js")
    .vue()
    .sass('resources/sass/back/app.scss', 'public/css/back.css');
// mix Frontend
mix.js("resources/js/front/front.js", "public/js/front.js")
    .sass("resources/sass/front/app.scss", "public/css")
    .polyfill({
        enabled: true,
        useBuiltIns: "usage",
        targets: { "firefox": "50", "ie": 11 }
    });
// Copy Blade Images Assets
mix.copyDirectory('resources/assets', 'public/assets');
