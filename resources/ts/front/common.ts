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
    menuOptions: HTMLDivElement.prototype,
    btnGames: HTMLButtonElement.prototype,
    btnOptions: HTMLButtonElement.prototype,
    btnScroll: HTMLButtonElement.prototype,

    init: function () {
        V.selectors();
        V.events();
    },
    selectors: function () {
        V.menuModal = document.querySelector(".nav-modal") as HTMLDivElement;
        V.menuGames = document.querySelector(".nav-games") as HTMLDivElement;
        V.menuOptions = document.querySelector(
            ".nav-options"
        ) as HTMLDivElement;
        V.btnGames = document.querySelector(".btn-games") as HTMLButtonElement;
        V.btnOptions = document.querySelector(
            ".btn-options"
        ) as HTMLButtonElement;
        V.btnScroll = document.querySelector(
            ".btn-scroll"
        ) as HTMLButtonElement;
    },
    events: function () {
        V.btnGames.addEventListener("click", V.displayMenuGames);
        V.btnOptions.addEventListener("click", V.displayMenuOptions);
        V.btnScroll.addEventListener("click", V.scrollToTheTop);
    },
    displayMenuGames: function () {
        V.menuModal.classList.toggle("nav-modal-hidden");
        V.menuGames.classList.toggle("nav-games-hidden");
    },
    displayMenuOptions: function () {
        V.menuModal.classList.toggle("nav-modal-hidden");
        V.menuOptions.classList.toggle("nav-options-hidden");
    },
    scrollToTheTop: function () {
        window.scrollTo(0, 0);
    },
};

document.addEventListener("DOMContentLoaded", function () {
    C.init();
});
