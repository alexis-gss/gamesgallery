import axios from "axios";

const bootstrap = require("bootstrap/dist/js/bootstrap.bundle.min.js");

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
axios.defaults.headers.common = {
    Accept: "application/json, text/plain, */*",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": document
        .querySelector("meta[name=\"csrf-token\"]")!
        .getAttribute("content"),
};

window.axios = axios;
window.bootstrap = bootstrap;

document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll("[data-bs=\"tooltip\"]")
    );
    tooltipTriggerList.map(function (element) {
        // eslint-disable-next-line no-undef
        return new bootstrap.Tooltip(element, {
            delay: { show: 800 },
            trigger: "hover",
        });
    });
});
