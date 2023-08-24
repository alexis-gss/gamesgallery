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
          <a
            v-if="gamePictures[n + i]"
            :href="getPicturePath(n + i)"
            class="glightbox"
            data-gallery="games-pictures"
          >
            <div
              class="ratio ratio-16x9"
              data-aos="fade-up"
            >
              <img
                :src="getPicturePath(n + i)"
                :alt="'Picture from the game ' + gameName"
                :title="'Picture from the game ' + gameName"
                class="d-none w-100 p-1"
                @load="gameImageLazyLoad"
              >
              <div class="position-absolute top-0 start-0 w-100 h-100 p-1">
                <div
                  class="d-flex justify-content-center align-items-center w-100 h-100 bg-primary"
                >
                  <div
                    class="spinner-border text-light"
                    role="status"
                  >
                    <span class="visually-hidden">
                      {{ __("texts.fo.text_loading") }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="row w-100 mx-auto p-0">
        <div
          v-for="(b, i) in 3"
          :key="b"
          :class="`position-relative col-12 col-sm col-lg-${gameItems / 3} p-0`"
        >
          <a
            v-if="gamePictures[n + 4 + i]"
            :href="getPicturePath(n + 4 + i)"
            class="glightbox"
            data-gallery="games-pictures"
          >
            <div
              class="ratio ratio-16x9"
              data-aos="fade-up"
            >
              <img
                :src="getPicturePath(n + 4 + i)"
                :alt="'Picture from the game ' + gameName"
                :title="'Picture from the game ' + gameName"
                class="d-none w-100 p-1"
                @load="gameImageLazyLoad"
              >
              <div class="position-absolute top-0 start-0 w-100 h-100 p-1">
                <div
                  class="d-flex justify-content-center align-items-center w-100 h-100 bg-primary"
                >
                  <div
                    class="spinner-border text-light"
                    role="status"
                  >
                    <span class="visually-hidden">
                      {{ __("texts.fo.text_loading") }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="row w-100 mx-auto p-0">
        <div
          v-for="(c, i) in 2"
          :key="c"
          :class="`position-relative col-12 col-sm-${gameItems / 2} p-0`"
        >
          <a
            v-if="gamePictures[n + 7 + i]"
            :href="getPicturePath(n + 7 + i)"
            class="glightbox"
            data-gallery="games-pictures"
          >
            <div
              class="ratio ratio-16x9"
              data-aos="fade-up"
            >
              <img
                :src="getPicturePath(n + 7 + i)"
                :alt="'Picture from the game ' + gameName"
                :title="'Picture from the game ' + gameName"
                class="d-none w-100 p-1"
                @load="gameImageLazyLoad"
              >
              <div class="position-absolute top-0 start-0 w-100 h-100 p-1">
                <div
                  class="d-flex justify-content-center align-items-center w-100 h-100 bg-primary"
                >
                  <div
                    class="spinner-border text-light"
                    role="status"
                  >
                    <span class="visually-hidden">
                      {{ __("texts.fo.text_loading") }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="row w-100 mx-auto p-0">
        <div
          v-for="(d, i) in 3"
          :key="d"
          :class="`position-relative col-12 col-sm col-lg-${gameItems / 3} p-0`"
        >
          <a
            v-if="gamePictures[n + 9 + i]"
            :href="getPicturePath(n + 9 + i)"
            class="glightbox"
            data-gallery="games-pictures"
          >
            <div
              class="ratio ratio-16x9"
              data-aos="fade-up"
            >
              <img
                :src="getPicturePath(n + 9 + i)"
                :alt="'Picture from the game ' + gameName"
                :title="'Picture from the game ' + gameName"
                class="d-none w-100 p-1"
                @load="gameImageLazyLoad"
              >
              <div class="position-absolute top-0 start-0 w-100 h-100 p-1">
                <div
                  class="d-flex justify-content-center align-items-center w-100 h-100 bg-primary"
                >
                  <div
                    class="spinner-border text-light"
                    role="status"
                  >
                    <span class="visually-hidden">
                      {{ __("texts.fo.text_loading") }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="w-100 text-center mt-5">
      <div
        v-if="gameLoading"
        class="spinner-border text-primary"
        role="status"
      >
        <span class="visually-hidden">{{ __("texts.fo.text_loading") }}</span>
      </div>
      <div
        v-if="gameAllLoaded"
        class="fst-italic text-secondary"
      >
        {{ __("texts.fo.images_loaded") }}
      </div>
    </div>
  </div>
  <div
    v-else
    class="text-center"
  >
    {{ __("texts.fo.images_no_one") }}
  </div>
</template>

<script lang="ts">
import GLightbox from "glightbox";
import { defineComponent } from "vue";
import trans from "./../../modules/trans";

export default defineComponent({
  mixins: [trans],
  data(): {
    gameName: string;
    gameSlug: string;
    gamePictures: Array<{
      uuid: string;
      type: string;
    }>;
    gamePage: number;
    gameLastPage: number;
    gameItems: number;
    gameLoading: boolean;
    gameAllLoaded: boolean;
    gameViewer: GLightbox | null;
  } {
    return {
      gameName: "",
      gameSlug: "",
      gamePictures: [],
      gamePage: 1,
      gameLastPage: 1,
      gameItems: 12,
      gameLoading: true,
      gameAllLoaded: false,
      gameViewer: null,
    };
  },
  mounted() {
    const json = String(this.$attrs.json ?? "{}");
    const data = JSON.parse(json);
    this.gameName = data.gameName;
    this.gameSlug = data.gameSlug;
    this.gamePage = data.gamePictures.current_page;
    this.gameLastPage = data.gamePictures.last_page;
    this.gameItems =
      data.gamePictures.per_page < 12 ? 12 : data.gamePictures.per_page;
    this.initComponent();
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
    /**
     * Get the location.
     */
    initComponent() {
      this.checkScroll();
      this.getPictures();
      this.updateGlightbox();
    },
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
    /**
     * Load the current page.
     */
    getPictures() {
      const url = "?page=" + this.gamePage;
      window.axios
        .get(url)
        .then((response) => {
          this.gamePictures = this.gamePictures.concat(
            Object.values(response.data.data.data)
          );
          this.gameLoading = false;
          this.updateGlightbox();
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
    /**
     * Return the path of the picture.
     *
     * @param number n
     */
    getPicturePath(n: number) {
      return (
        location.origin +
        "/storage/documents/" +
        this.gameSlug +
        "/" +
        this.gamePictures[n].uuid +
        "." +
        this.gamePictures[n].type
      );
    },
    /**
     * Update Glightbox elements.
     */
    updateGlightbox() {
      setTimeout(() => {
        this.gameViewer?.destroy();
        this.gameViewer = new GLightbox({
          selector: ".glightbox",
        });
      }, 800);
    },
  },
});
</script>
