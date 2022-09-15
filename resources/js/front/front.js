// Model.
var M = {
    // Detecting the position of an image.
    elementInViewport: function (el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.left >= 0 &&
      rect.bottom - rect.height <=
        (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    },
    // Verify if a theme was saved.
    checkTheme: function () {
        if (localStorage.getItem("theme")) {
            C.theme = M.getTheme();
        } else {
            M.setTheme("dark");
        }
        C.changeTheme(M.getTheme());
    },
    // Set anew theme.
    setTheme: function (name) {
        C.theme = name;
        localStorage.setItem("theme", name);
    },
    // Get the actual theme.
    getTheme: function () {
        return localStorage.getItem("theme");
    },
    // Scroll to the top of the page.
    setScrollTop: function () {
        window.scrollTo(0, 0);
    },
    // Check if the user is at the top of the page.
    checkScrollTop: function () {
        if (document.documentElement.scrollTop > 200) {
            return true;
        } else {
            return false;
        }
    },
};

// Controller.
var C = {
    theme: undefined,

    // Init the Controller.
    init: function () {
        V.init();
        V.bindEvent();
        C.lazyLoad();
        M.checkTheme();
    },
    // Clear search bar.
    searchClear: function () {
        V.searchInput.value = "";
        V.search();
    },
    // Pre-loading of images.
    lazyLoad: function () {
        var lazyImage = document.getElementsByClassName("image");
        for (let i = 0; i < lazyImage.length; i++) {
            if (M.elementInViewport(lazyImage[i])) {
                lazyImage[i].setAttribute("src", lazyImage[i].getAttribute("data-src"));
                lazyImage[i].parentNode.classList.add("content-in-view");
            } else {
                lazyImage[i].parentNode.classList.remove("content-in-view");
            }
        }
        C.updateArrow();
    },
    // Change the theme after an action.
    changeTheme: function (name) {
        if (V.body.className) {
            V.body.classList.remove(V.body.className);
        }
        V.body.classList.add(name + "-theme");
        M.setTheme(name);
        V.updateThemeBtn();
    },
    // Update the theme.
    updateTheme: function () {
        if (C.theme === "dark") {
            C.changeTheme("light");
        } else {
            C.changeTheme("dark");
        }
        V.updateThemeBtn();
    },
    // Scroll to the top of the page.
    scrollTop: function () {
        M.setScrollTop();
    },
    // Change arrow status.
    updateArrow: function () {
        if (M.checkScrollTop()) V.showArrow("v-hidden", "v-visible");
        else {
            V.showArrow("v-visible", "v-hidden");
        }
    },
};

// Vue.
var V = {
    body: undefined,
    games: undefined,
    nav: undefined,
    searchBar: undefined,
    searchInput: undefined,
    searchBtn: undefined,
    noResult: undefined,
    btnTheme: undefined,
    btnThemeDark: undefined,
    btnThemeLight: undefined,
    btnTop: undefined,
    contentImages: undefined,

    // Init the Vue.
    init: function () {
        V.body = document.querySelector("body");
        V.games = document.querySelectorAll(".game");
        V.nav = document.querySelector("nav");
        V.searchBar = document.querySelector(".search");
        V.searchInput = document.querySelector(".search input");
        V.searchBtn = document.querySelector(".search span");
        V.noResult = document.querySelector(".no-result");
        V.btnTheme = document.querySelector(".btn-theme");
        V.btnThemeDark = document.querySelector(".theme-dark");
        V.btnThemeLight = document.querySelector(".theme-light");
        V.btnTop = document.querySelector(".btn-top");
        V.contentImages = document.querySelectorAll(".content");
    },
    // Define bind events.
    bindEvent: function () {
        V.searchBar.addEventListener("keyup", V.search);
        V.searchBtn.addEventListener("click", C.searchClear);
        V.btnTheme.addEventListener("click", C.updateTheme);
        V.btnTop.addEventListener("click", C.scrollTop);
        window.addEventListener("scroll", C.lazyLoad);
    },
    // Show only games who contains the search value.
    search: function () {
        for (let i = 0; i < V.games.length; i++) {
            if (
                !V.games[i].innerText
                    .toLowerCase()
                    .includes(V.searchInput.value.toLowerCase())
            ) {
                V.games[i].classList.add("d-none");
            } else {
                V.games[i].classList.remove("d-none");
            }
        }
        V.checkResultSearch();
    },
    // Verify if there is a result from the search.
    checkResultSearch: function () {
        if (V.nav.querySelectorAll("a.d-none").length === V.games.length) {
            V.noResult.classList.remove("d-none");
        } else {
            V.noResult.classList.add("d-none");
        }
    },
    // Change the icon of the theme button.
    updateThemeBtn: function () {
        if (C.theme === "dark") {
            V.btnThemeDark.classList.remove("theme-activated");
            V.btnThemeLight.classList.add("theme-activated");
        } else {
            V.btnThemeDark.classList.add("theme-activated");
            V.btnThemeLight.classList.remove("theme-activated");
        }
    },
    // Show/hide arrow button.
    showArrow: function ($target1, $target2) {
        V.btnTop.classList.remove($target1);
        V.btnTop.classList.add($target2);
    },
};

// Initialize the MVC.
C.init();