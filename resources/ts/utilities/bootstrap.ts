import { Tooltip } from "bootstrap";

document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll("[data-bs=\"tooltip\"]")
    );
    tooltipTriggerList.map(function (element) {
        return new Tooltip(element, {
            delay: { show: 800, hide: 300 },
            trigger: "hover",
        });
    });
});
