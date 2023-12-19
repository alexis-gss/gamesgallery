document.addEventListener("DOMContentLoaded", function () {
    let menuModal: HTMLDivElement|null;
    let menuFilter: HTMLDivElement|null;
    let btnGames: NodeListOf<HTMLSpanElement>;
    let btnScroll: HTMLButtonElement|null;
    let btnScrollContent: HTMLDivElement|null;

    selectors();
    events();

    /**
     * Set all selectors on the page.
     */
    function selectors() {
        menuModal = document.querySelector(".nav-modal");
        menuFilter = document.querySelector(".nav-filter");
        btnGames = document.querySelectorAll(
            ".btn-games"
        );
        btnScroll = document.querySelector(
            ".btn-scroll"
        );
        btnScrollContent = document.querySelector(
            ".btn-scroll .btn"
        );
    }

    /**
     * Set all events on the page.
     */
    function events() {
        document.addEventListener("scroll", checkDistanceTop);
        btnGames?.forEach((element) => {
            element.addEventListener("click", displayMenuGames);
        });
        btnScrollContent?.addEventListener("click", scrollToTheTop);
        menuFilter?.addEventListener("click", displayMenuGames);
    }

    /**
     * Show/hide games navigation.
     */
    function displayMenuGames() {
        menuModal?.classList.toggle("nav-modal-hidden");
        menuFilter?.classList.toggle("nav-filter-hidden");
    }

    /**
     * Scroll to the top of the page.
     */
    function scrollToTheTop() {
        window.scrollTo(0, 0);
    }

    /**
     * Check the distance between two scroll specific position.
     */
    function checkDistanceTop() {
        document.documentElement.scrollTop < 200
            ? btnScroll?.classList.add("btn-scroll-hidden")
            : btnScroll?.classList.remove("btn-scroll-hidden");
    }
});
