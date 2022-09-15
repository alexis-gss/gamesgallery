const path = require("path");
const mix = require("laravel-mix");

require("laravel-mix-polyfill");
require("laravel-mix-clean");
require("laravel-mix-eslint");
require("laravel-mix-stylelint");

const assetDir = "assets";
const polyfill = {
    enabled: true,
    bugfixes: true,
    useBuiltIns: "usage",
    targets: "last 3 version, not dead, >0.3%"
};

mix.webpackConfig({
    resolve: {
        extensions: ["*", ".js", ".vue", ".ts"],
        alias: {
            "@": path.resolve("resources/assets"),
        },
    },
    module: {
        rules: [
            {
                test: /\.ts$/,
                loader: "ts-loader",
                options: {
                    appendTsSuffixTo: [/\.vue$/],
                },
            },
            {
                test: /\.vue$/,
                loader: "vue-loader",
                options: {
                    esModule: true,
                },
            },
        ],
    }
});

mix.options({
    fileLoaderDirs: {
        images: `${assetDir}/images`,
    },
    postCss: [
        require("postcss-discard-comments")({
            removeAll: true,
        }),
    ],
});

mix.clean({
    cleanOnceBeforeBuildPatterns: [
        "css/*",
        "js/*",
        "images/*",
        "fonts/*",
        "assets/*",
        "webfonts/*"
    ]
});

// * BO
mix.js("resources/js/back/back.js", "public/js/bo.js")
    .eslint({
        fix: true,
        extensions: ["js", "ts"],
    })
    .sass("resources/sass/back/back.scss", "public/css/bo.css")
    .stylelint({
        configFile: ".stylelintrc.json",
        files: ["**/*.scss"],
    })
    .polyfill(polyfill)
    .version();

// * FO
mix.js("resources/js/front/front.js", "public/js/fo.js")
    .eslint({
        fix: true,
        extensions: ["js", "ts"],
    })
    .sass("resources/sass/front/front.scss", "public/css/fo.css")
    .stylelint({
        configFile: ".stylelintrc.json",
        files: ["**/*.scss"],
    })
    .polyfill(polyfill)
    .version();

// * Copy Blade Images Assets
mix.copyDirectory("resources/assets", "public/assets");
