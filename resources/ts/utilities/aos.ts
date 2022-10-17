import "aos";

document.addEventListener("DOMContentLoaded", function () {
    const Aos = require("aos/dist/aos.js");
    Aos.init({
        offset: 100,
        duration: 300,
        easing: "fade-up",
        delay: 100,
    });
});
