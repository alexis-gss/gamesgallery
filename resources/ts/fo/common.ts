const M = {
    init: function () {},
};

const C = {
    init: function () {
        M.init();
        V.init();
    },
};

const V = {
    menuModal: HTMLDivElement.prototype,
    menuGames: HTMLDivElement.prototype,
    btnGames: NodeList.prototype,
    btnScroll: HTMLButtonElement.prototype,
    btnScrollContent: HTMLDivElement.prototype,

    init: function () {
        V.selectors();
        V.events();
    },
    selectors: function () {
        V.menuModal = document.querySelector(".nav-modal") as HTMLDivElement;
        V.menuGames = document.querySelector(".nav-games") as HTMLDivElement;
        V.btnGames = document.querySelectorAll(
            ".btn-games"
        ) as NodeListOf<HTMLSpanElement>;
        V.btnScroll = document.querySelector(
            ".btn-scroll"
        ) as HTMLButtonElement;
        V.btnScrollContent = document.querySelector(
            ".btn-scroll .btn"
        ) as HTMLDivElement;
    },
    events: function () {
        document.addEventListener("scroll", V.checkDistanceTop);
        V.btnGames?.forEach((element) => {
            element.addEventListener("click", V.displayMenuGames);
        });
        V.btnScrollContent?.addEventListener("click", V.scrollToTheTop);
    },
    displayMenuGames: function () {
        V.menuModal.classList.toggle("nav-modal-hidden");
        V.menuGames.classList.toggle("nav-games-hidden");
    },
    scrollToTheTop: function () {
        window.scrollTo(0, 0);
    },
    checkDistanceTop: function () {
        document.documentElement.scrollTop < 200
            ? V.btnScroll?.classList.add("btn-scroll-hidden")
            : V.btnScroll?.classList.remove("btn-scroll-hidden");
        console.log("test");
    },
};

document.addEventListener("DOMContentLoaded", function () {
    C.init();
});
