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
            'vue$': 'vue/dist/vue.runtime.esm-bundler.js',
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
        fonts: `${assetDir}/fonts`,
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
        "assets/*",
        "css/*",
        "js/*"
    ]
});

// * BACK
mix.ts("resources/ts/back.ts", "public/js/back.js", { transpileOnly: true })
    .vue({
        runtimeOnly: true,
        extractStyles: true,
        globalStyles: false,
    })
    .eslint({
        fix: true,
        extensions: ["js", "ts"],
    })
    .sass("resources/sass/back.scss", "public/css/back.css")
    .stylelint({
        configFile: ".stylelintrc.json",
        files: ["**/*.scss"],
    })
    .polyfill(polyfill)
    .version()
    .sourceMaps(true, "inline-source-map");

// * FRONT
mix.js("resources/ts/front.ts", "public/js/front.js", { transpileOnly: true })
    .vue({
        runtimeOnly: true,
        extractStyles: true,
        globalStyles: false,
    })
    .eslint({
        fix: true,
        extensions: ["js", "ts"],
    })
    .sass("resources/sass/front.scss", "public/css/front.css")
    .stylelint({
        configFile: ".stylelintrc.json",
        files: ["**/*.scss"],
    })
    .polyfill(polyfill)
    .version()
    .sourceMaps(true, "inline-source-map");

// * Copy Blade Images Assets
mix.copyDirectory("resources/assets", "public/assets");
