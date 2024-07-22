window.onload = function() {
    let loadingScreen: HTMLDivElement|null;
    let menuModal: HTMLDivElement|null;
    let menuFilter: HTMLDivElement|null;
    let btnGames: NodeListOf<HTMLSpanElement>;
    let btnScroll: HTMLButtonElement|null;
    let breadcrumb: HTMLDivElement|null;
    let homeTextContent: HTMLDivElement|null;

    selectors();
    events();
    setLatestGamesWidth();
    hideLoadingScreen();

    /**
     * Hide loading screen.
     */
    function hideLoadingScreen() {
        // Wait for components to be mounted.
        setTimeout(() => {
            loadingScreen?.classList.add("opacity-0");
            // Wait for the transition end.
            setTimeout(() => {
                loadingScreen?.classList.add("invisible");
            }, 300);
        }, 300);
    }

    /**
     * Set all selectors on the page.
     */
    function selectors() {
        loadingScreen = document.querySelector("#loading-screen");
        menuModal = document.querySelector(".nav-modal");
        menuFilter = document.querySelector(".nav-filter");
        btnGames = document.querySelectorAll(".btn-games");
        btnScroll = document.querySelector(".btn-scroll");
        breadcrumb = document.querySelector(".breadcrumb");
        homeTextContent = document.querySelector(".main-home-latest");
    }

    /**
     * Set all events on the page.
     */
    function events() {
        document.addEventListener("scroll", checkDistanceTop);
        btnGames?.forEach((element) => {
            element.addEventListener("click", displayMenuGames);
        });
        btnScroll?.addEventListener("click", scrollToTheTop);
        menuFilter?.addEventListener("click", displayMenuGames);
        window.addEventListener("resize", setLatestGamesWidth);
    }

    /**
     * Set the width of the latest games content.
     */
    function setLatestGamesWidth() {
        setTimeout(() => {
            if (homeTextContent && homeTextContent.nextElementSibling)
                if (window.matchMedia("(min-width: 992px)").matches)
                    homeTextContent.setAttribute("style", "width:calc(100% - " +
                        (homeTextContent.nextElementSibling as HTMLDivElement).offsetWidth + "px)");
                else
                    homeTextContent.setAttribute("style", "width:100%");
        }, 100);
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
        if (document.documentElement.scrollTop < 200) {
            btnScroll?.classList.add("btn-scroll-hidden");
            breadcrumb?.classList.remove("breadcrumb-resize-wrapper");
        } else {
            btnScroll?.classList.remove("btn-scroll-hidden");
            breadcrumb?.classList.add("breadcrumb-resize-wrapper");
        }
    }
};
