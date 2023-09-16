import { App, Component, createApp } from "vue";

document.addEventListener("DOMContentLoaded", () => {
    const setupApp = (app: App<Element>) => {
        app.config.globalProperties.window = window;
        app.config.globalProperties.document = document;
    };

    // Register components
    const vues = import.meta.glob("./../components/*.vue") as Record<
        string,
        () => Promise<{ default: Component }>
    >;
    for (const vueCptName in vues) {
        const vueCptPromise = vues[vueCptName];
        let htmlKey = vueCptName.split("/").pop();
        if (!htmlKey) {
            throw new Error(`Cannot load ${vueCptName}`);
        }
        htmlKey = htmlKey
            .split(".")[0]
            .replace(/\.?([A-Z])/g, function (x, y) {
                return "-" + y.toLowerCase();
            })
            .replace(/^-/, "")
            .replace("-component", "");

        const el = document.getElementById(htmlKey),
            elGroup = document.getElementsByClassName(htmlKey);
        // * Init using ID
        if (el) {
            vueCptPromise().then((vueParsedFile) => {
                const app = createApp(vueParsedFile.default, {
                    json: el.dataset.json ?? {},
                });
                setupApp(app);
                app.mount(el);
            });
        }
        // * Init Using class
        for (const grpEl of elGroup) {
            // * Hack to prevent loop weirdness
            vueCptPromise().then((vueParsedFile) => {
                setTimeout(() => {
                    const app = createApp(vueParsedFile.default, {
                        json: (grpEl as HTMLElement).dataset.json ?? {},
                    });
                    setupApp(app);
                    app.mount(grpEl);
                }, 500);
            });
        }
    }
});
