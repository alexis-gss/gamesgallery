window.bootstrap = require("bootstrap/dist/js/bootstrap.bundle.js");

document.addEventListener("DOMContentLoaded", function () {
    var tooltipTriggerList = [].slice.call(
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
