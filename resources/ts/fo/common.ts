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
            ".btn-scroll .btn"
        ) as HTMLButtonElement;
    },
    events: function () {
        V.btnGames?.forEach((element) => {
            element.addEventListener("click", V.displayMenuGames);
        });
        V.btnScroll?.addEventListener("click", V.scrollToTheTop);
    },
    displayMenuGames: function () {
        V.menuModal.classList.toggle("nav-modal-hidden");
        V.menuGames.classList.toggle("nav-games-hidden");
    },
    scrollToTheTop: function () {
        window.scrollTo(0, 0);
    },
};

document.addEventListener("DOMContentLoaded", function () {
    C.init();
});
