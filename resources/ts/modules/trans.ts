export default {
    data() {
        return {
            locale: window.__SYSTEM._locale,
        };
    },
    methods: {
        /**
         * Translate the given key,
         * ex: __('name', { 'parameter': 'value' }).
         */
        __(key: string, replace: Record<PropertyKey, string> = {}): string {
            let translation: string,
                translationNotFound = true;

            try {
                translation = key
                    .split(".")
                    .reduce(
                        (t, i) => t[i as any] ?? null,
                        window.__SYSTEM._translations.php
                    ) as string;
                if (translation) {
                    translationNotFound = false;
                }
            } catch (e) {
                translation = key;
            }

            if (translationNotFound) {
                translation = (window.__SYSTEM._translations.json[key as any] ??
                    key) as string;
            }
            const vars = translation.match(/:[0-9A-Za-z_]+/g);
            if (vars) {
                for (const match of vars) {
                    try {
                        translation = translation.replace(
                            new RegExp(match, "g"),
                            replace[match.substring(1)]
                        );
                    } catch (e) {
                        console.error("String replace failed ", e);
                    }
                }
            }
            return translation;
        },
    },
};
