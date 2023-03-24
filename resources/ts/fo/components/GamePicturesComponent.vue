<template>
  <div v-if="gamePictures.length > 0">
    <div
      v-for="n in incrementNumber"
      :key="n"
    >
      <div class="row w-100 mx-auto p-0">
        <div
          v-for="(a, i) in 4"
          :key="a"
          :class="`position-relative col-12 col-sm-6 col-lg-${
            gameItems / 4
          } p-0`"
        >
          <div
            v-if="gamePictures[n + i]"
            class="ratio ratio-16x9"
            data-aos="fade-up"
          >
            <img
              :src="gamePictures[n + i]"
              alt="Image of the game."
              class="d-none w-100 p-1"
              @load="gameImageLazyLoad"
            >
            <div class="position-absolute top-0 start-0 w-100 h-100 p-1">
              <div class="w-100 h-100 text-bg-secondary" />
            </div>
          </div>
        </div>
      </div>
      <div class="row w-100 mx-auto p-0">
        <div
          v-for="(b, i) in 3"
          :key="b"
          :class="`position-relative col-12 col-sm col-lg-${gameItems / 3} p-0`"
        >
          <div
            v-if="gamePictures[n + 4 + i]"
            class="ratio ratio-16x9"
            data-aos="fade-up"
          >
            <img
              :src="gamePictures[n + 4 + i]"
              alt="Image of the game."
              class="d-none w-100 p-1"
              @load="gameImageLazyLoad"
            >
            <div class="position-absolute top-0 start-0 w-100 h-100 p-1">
              <div class="w-100 h-100 text-bg-secondary" />
            </div>
          </div>
        </div>
      </div>
      <div class="row w-100 mx-auto p-0">
        <div
          v-for="(c, i) in 2"
          :key="c"
          :class="`position-relative col-12 col-sm-${gameItems / 2} p-0`"
        >
          <div
            v-if="gamePictures[n + 7 + i]"
            class="ratio ratio-16x9"
            data-aos="fade-up"
          >
            <img
              :src="gamePictures[n + 7 + i]"
              alt="Image of the game."
              class="d-none w-100 p-1"
              @load="gameImageLazyLoad"
            >
            <div class="position-absolute top-0 start-0 w-100 h-100 p-1">
              <div class="w-100 h-100 text-bg-secondary" />
            </div>
          </div>
        </div>
      </div>
      <div class="row w-100 mx-auto p-0">
        <div
          v-for="(d, i) in 3"
          :key="d"
          :class="`position-relative col-12 col-sm col-lg-${gameItems / 3} p-0`"
        >
          <div
            v-if="gamePictures[n + 9 + i]"
            class="ratio ratio-16x9"
            data-aos="fade-up"
          >
            <img
              :src="gamePictures[n + 9 + i]"
              alt="Image of the game."
              class="d-none w-100 p-1"
              @load="gameImageLazyLoad"
            >
            <div class="position-absolute top-0 start-0 w-100 h-100 p-1">
              <div class="w-100 h-100 text-bg-secondary" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="w-100 text-center mt-5">
      <div
        v-if="gameLoading"
        class="spinner-border text-secondary"
        role="status"
      >
        <span class="visually-hidden">{{ __("nav.text_loading") }}</span>
      </div>
      <div
        v-if="gameAllLoaded"
        class="fst-italic text-secondary"
      >
        {{ __("nav.images_loaded") }}
      </div>
    </div>
  </div>
  <div
    v-else
    class="text-center"
  >
    {{ __("nav.images_no_one") }}
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import trans from "../../modules/trans";

export default defineComponent({
  mixins: [trans],
  inheritAttrs: false,
  props: {
    jsonData: {
      type: String,
      default: "[]",
    },
  },
  data(): {
    gameName: string;
    gamePictures: Array<string>;
    gamePage: number;
    gameLastPage: number;
    gameItems: number;
    gameLoading: boolean;
    gameAllLoaded: boolean;
  } {
    return {
      gameName: "",
      gamePictures: [],
      gamePage: 1,
      gameLastPage: 1,
      gameItems: 1,
      gameLoading: true,
      gameAllLoaded: false,
    };
  },
  mounted() {
    const json = String(this.$attrs.json ?? "{}");
    const data = JSON.parse(json);
    this.gameName = data.game.name;
    this.gamePage = data.gamePictures.current_page;
    this.gameLastPage = data.gamePictures.last_page;
    this.gameItems =
      data.gamePictures.per_page < 12 ? 12 : data.gamePictures.per_page;
    this.checkScroll();
    this.getPictures();
  },
  computed: {
    /**
     * Useful to increment the loop of the template
     * by the gameItems number.
     */
    incrementNumber() {
      return this.gamePictures
        .map((_, i) => i)
        .filter((i) => i % this.gameItems === 0);
    },
  },
  methods: {
    /* EVENTS */

    /**
     * Increment the current page number when the
     * user scroll to the bottom.
     */
    checkScroll() {
      window.addEventListener("scroll", () => {
        if (
          window.innerHeight + window.scrollY >=
          document.body.offsetHeight - 300 &&
          !this.gameLoading
        ) {
          if (this.gamePage < this.gameLastPage) {
            this.gamePage++;
            this.gameLoading = true;
            this.getPictures();
          } else {
            this.gameAllLoaded = true;
          }
        }
      });
    },

    /* FUNCTIONS */

    /**
     * Load the current page.
     */
    getPictures() {
      const url = "?page=" + this.gamePage;
      window.axios
        .get(url)
        .then((response) => {
          this.updatePictures(Object.values(response.data.data.data));
        })
        .catch((error) => {
          if (error.response) {
            console.log(error.response);
          } else if (error.request) {
            console.log(error.request);
          } else {
            console.log("Error", error.message);
          }
          console.log(error.config);
        });
    },

    /**
     * Update game's pictures,
     * Set the loading to the false.
     *
     * @param {Array<string>} data
     */
    updatePictures(data: Array<string>) {
      this.gamePictures = this.gamePictures.concat(data);
      this.gameLoading = false;
    },

    /**
     * Show image when she loaded,
     * Hide the placeholder's image.
     *
     * @param {Event} e
     */
    gameImageLazyLoad(e: Event) {
      const nodeTarget = e.target as HTMLImageElement;
      nodeTarget.classList.remove("d-none");
      nodeTarget.classList.add("show-image");
    },
  },
});
</script>
