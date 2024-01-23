import type * as bootstrap from "bootstrap";

let tooltips: Array<bootstrap.Tooltip> = [];

export default {
    methods: {
        /**
         * Initialize all Bootstrap tooltips.
         */
        setBootstrapTooltip() {
            this.disableBootstrapTooltip();
            tooltips = [].slice
                .call(document.querySelectorAll("[data-bs-tooltip=\"tooltip\"]"))
                .map(function (tooltipTriggerEl) {
                    return new window.bootstrap.Tooltip(tooltipTriggerEl, {
                        customClass: "large-tooltip",
                        delay: {
                            show: 1250,
                            hide: 0,
                        },
                    });
                });
        },
        /**
         * Disable all Bootstrap tooltips.
         */
        disableBootstrapTooltip() {
            tooltips.forEach((tooltip) => {
                tooltip.disable();
                tooltip.hide();
            });
        },
        /**
         * Close all Bootstrap tooltips.
         */
        closeBootstrapTooltip() {
            [].slice
                .call(document.querySelectorAll("[data-bs-tooltip=\"tooltip\"]"))
                .forEach((tooltip: HTMLElement) => {
                    tooltip.blur();
                    window.bootstrap.Tooltip.getInstance(tooltip)?.hide();
                });
        },
    },
};
