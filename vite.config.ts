import vue from "@vitejs/plugin-vue";
import autoprefixer from "autoprefixer";
import laravel from "laravel-vite-plugin";
import path from "path";
import postcssDiscard from "postcss-discard-comments";
import copy from "rollup-plugin-copy";
import { defineConfig } from "vite";
import babel from "vite-plugin-babel";
import checker from "vite-plugin-checker";
import eslint from "vite-plugin-eslint";
import stylelint from "vite-plugin-stylelint";

export default defineConfig({
    build: {
        rollupOptions: {
            output: {
                entryFileNames: `assets/${
                    process.env.NODE_ENV === "local" ? "[name]-" : ""
                }[hash].js`,
                chunkFileNames: `assets/${
                    process.env.NODE_ENV === "local" ? "[name]-" : ""
                }[hash].js`,
                assetFileNames: (chunk) => {
                    if (
                        String(chunk.name).endsWith("mail-theme.scss") ||
                        chunk.name === "mail-theme.css"
                    ) {
                        return "vendor/mail/html/themes/default.[ext]";
                    }
                    return `assets/${process.env.NODE_ENV === "local" ? "[name]-" : ""
                    }[hash].[ext]`;
                },
            },
        },
        chunkSizeWarningLimit: 700,
        emptyOutDir: true,
        sourcemap: process.env.NODE_ENV === "local" ? "inline" : false,
    },
    css: {
        devSourcemap: process.env.NODE_ENV === "local" ? true : false,
        postcss: {
            map: {
                inline: true,
            },
            plugins: [
                postcssDiscard({
                    removeAll: true,
                }),
                autoprefixer(),
            ],
        },
    },
    plugins: [
        checker({
            enableBuild: true,
            vueTsc: {
                root: ".",
                tsconfigPath: "tsconfig.json",
            },
            typescript: {
                root: ".",
                tsconfigPath: "tsconfig.json",
            },
            eslint: {
                lintCommand:
                    "eslint --fix --quiet -c .eslintrc.json \"./resources\"",
            },
            stylelint: {
                lintCommand:
                    "stylelint -q --config \"./.stylelintrc.json\" --fix \"**/resources/**/*.scss\"",
            },
        }),
        laravel({
            input: [
                "resources/sass/bo/back.scss",
                "resources/ts/bo/back.ts",
                "resources/sass/fo/front.scss",
                "resources/ts/fo/front.ts",
            ],
        }),
        stylelint({
            dev: false,
            build: true,
            cache: false,
            chokidar: true,
            quiet: false,
            include: ["**/resources/**/*.scss", "**/resources/**/*.css"],
            exclude: ["node_modules", "vendor"],
            lintOnStart: true,
            emitError: true,
            emitWarning: true,
            emitErrorAsWarning: false,
            emitWarningAsError: true,
        }),
        eslint({
            cache: false,
            extensions: ["js", "ts"],
            exclude: ["node_modules", "vendor"],
            include: "**/*.ts",
            lintOnStart: true,
            emitWarning: true,
            emitError: true,
            failOnWarning: false,
            failOnError: false,
        }),
        babel(),
        vue({
            isProduction: process.env.NODE_ENV !== "local" ? true : false,
            exclude: ["node_modules", "vendor"],
        }),
        copy({
            targets: [
                {
                    src: [
                        // * Engine copy (Default favicon)
                        path.normalize("resources/favicon/android-chrome-192x192.png"),
                        path.normalize("resources/favicon/android-chrome-512x512.png"),
                        path.normalize("resources/favicon/apple-touch-icon.png"),
                        path.normalize("resources/favicon/browserconfig.xml"),
                        path.normalize("resources/favicon/browserconfig.xml"),
                        path.normalize("resources/favicon/favicon-16x16.png"),
                        path.normalize("resources/favicon/favicon-32x32.png"),
                        path.normalize("resources/favicon/favicon.ico"),
                        path.normalize("resources/favicon/mstile-150x150.png"),
                        path.normalize("resources/favicon/safari-pinned-tab.svg"),
                        path.normalize("resources/favicon/site.webmanifest"),
                    ],
                    dest: path.normalize("public")
                },
            ],
            copyOnce: true,
            verbose: true
        }),
    ],
    resolve: {
        extensions: ["*", ".js", ".ts", ".vue"],
        alias: [
            {
                find: "vue",
                replacement: "vue/dist/vue.runtime.esm-bundler.js",
            },
            {
                find: "@",
                replacement: "/resources/assets",
            },
            {
                find: "~",
                replacement: path.resolve(__dirname, "./node_modules"),
            },
        ],
    },
});
