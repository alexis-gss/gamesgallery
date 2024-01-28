<template>
  <div v-if="gameLoading || gamePictures.length > 0">
    <div
      v-for="n in incrementNumber"
      :key="n"
    >
      <div class="row w-100 mx-auto p-0">
        <div
          v-for="(a, i) in 4"
          :key="a"
          :class="`glightbox-wrapper position-relative col-12 col-sm-6 col-lg-${
            gameItems / 4
          } p-1`"
          data-aos="fade-up"
        >
          <template v-if="gamePictures[n + i]">
            <a
              :href="getPicturePath(n + i)"
              class="glightbox"
              data-gallery="games-pictures"
            >
              <div
                class="ratio ratio-16x9 overflow-hidden"
              >
                <img
                  :src="getPicturePath(n + i)"
                  :alt="'Picture n°' + (n + 1 + i) + ' from the game ' + gameName"
                  :title="'Picture n°' + (n + 1 + i) + ' from the game ' + gameName"
                  class="d-none w-100 z-1"
                  @load="gameImageLazyLoad"
                >
                <div class="picture-loader position-absolute top-0 start-0 w-100 h-100 z-3">
                  <div
                    class="d-flex justify-content-center align-items-center w-100 h-100 bg-primary"
                  >
                    <div
                      class="spinner-border text-light"
                      role="status"
                    >
                      <span class="visually-hidden">
                        {{ __("fo_text_loading") }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div
                v-if="picturesRatings.includes(gamePictures[n + i].id)"
                class="picture-likes position-absolute top-0 end-0 d-flex justify-content-center align-items-center bg-white p-2 m-1 z-2"
              >
                <span
                  :id="`ratings-${gamePictures[n + i].id}`"
                  class="me-1"
                >
                  {{ gamePictures[n + i].ratings_count }}
                </span>
                <FontAwesomeIcon icon="fa-solid fa-thumbs-up" />
              </div>
            </a>
            <button
              v-if="!picturesRatings.includes(gamePictures[n + i].id)"
              class="picture-likes btn btn-white position-absolute top-0 end-0 rounded-0 m-1 z-2"
              @click="ajaxPictureUpvote(gamePictures[n + i].id)"
            >
              <span class="me-1">{{ gamePictures[n + i].ratings_count }}</span>
              <FontAwesomeIcon icon="fa-regular fa-thumbs-up" />
            </button>
          </template>
        </div>
      </div>
      <div class="row w-100 mx-auto p-0">
        <div
          v-for="(b, i) in 3"
          :key="b"
          :class="`glightbox-wrapper position-relative col-12 col-sm col-lg-${gameItems / 3} p-1`"
          data-aos="fade-up"
        >
          <template v-if="gamePictures[n + 4 + i]">
            <a
              :href="getPicturePath(n + 4 + i)"
              class="glightbox"
              data-gallery="games-pictures"
            >
              <div
                class="ratio ratio-16x9 overflow-hidden"
              >
                <img
                  :src="getPicturePath(n + 4 + i)"
                  :alt="'Picture n°' + (n + 5 + i) + ' from the game ' + gameName"
                  :title="'Picture n°' + (n + 5 + i) + ' from the game ' + gameName"
                  class="d-none w-100 z-1"
                  @load="gameImageLazyLoad"
                >
                <div class="picture-loader position-absolute top-0 start-0 w-100 h-100">
                  <div
                    class="d-flex justify-content-center align-items-center w-100 h-100 bg-primary"
                  >
                    <div
                      class="spinner-border text-light"
                      role="status"
                    >
                      <span class="visually-hidden">
                        {{ __("fo_text_loading") }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div
                v-if="picturesRatings.includes(gamePictures[n + 4 + i].id)"
                class="picture-likes position-absolute top-0 end-0 d-flex justify-content-center align-items-center bg-white p-2 m-1 z-2"
              >
                <span
                  :id="`ratings-${gamePictures[n + 4 + i].id}`"
                  class="me-1"
                >
                  {{ gamePictures[n + 4 + i].ratings_count }}
                </span>
                <FontAwesomeIcon icon="fa-solid fa-thumbs-up" />
              </div>
            </a>
            <button
              v-if="!picturesRatings.includes(gamePictures[n + 4 + i].id)"
              class="picture-likes btn btn-white position-absolute top-0 end-0 rounded-0 m-1 z-2"
              @click="ajaxPictureUpvote(gamePictures[n + 4 + i].id)"
            >
              <span class="me-1">{{ gamePictures[n + 4 + i].ratings_count }}</span>
              <FontAwesomeIcon icon="fa-regular fa-thumbs-up" />
            </button>
          </template>
        </div>
      </div>
      <div class="row w-100 mx-auto p-0">
        <div
          v-for="(c, i) in 2"
          :key="c"
          :class="`glightbox-wrapper position-relative col-12 col-sm-${gameItems / 2} p-1`"
          data-aos="fade-up"
        >
          <template v-if="gamePictures[n + 7 + i]">
            <a
              :href="getPicturePath(n + 7 + i)"
              class="glightbox"
              data-gallery="games-pictures"
            >
              <div
                class="ratio ratio-16x9 overflow-hidden"
              >
                <img
                  :src="getPicturePath(n + 7 + i)"
                  :alt="'Picture n°' + (n + 8 + i) + ' from the game ' + gameName"
                  :title="'Picture n°' + (n + 8 + i) + ' from the game ' + gameName"
                  class="d-none w-100 z-1"
                  @load="gameImageLazyLoad"
                >
                <div class="picture-loader position-absolute top-0 start-0 w-100 h-100">
                  <div
                    class="d-flex justify-content-center align-items-center w-100 h-100 bg-primary"
                  >
                    <div
                      class="spinner-border text-light"
                      role="status"
                    >
                      <span class="visually-hidden">
                        {{ __("fo_text_loading") }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div
                v-if="picturesRatings.includes(gamePictures[n + 7 + i].id)"
                class="picture-likes position-absolute top-0 end-0 d-flex justify-content-center align-items-center bg-white p-2 m-1 z-2"
              >
                <span
                  :id="`ratings-${gamePictures[n + 7 + i].id}`"
                  class="me-1"
                >
                  {{ gamePictures[n + 7 + i].ratings_count }}
                </span>
                <FontAwesomeIcon icon="fa-solid fa-thumbs-up" />
              </div>
            </a>
            <button
              v-if="!picturesRatings.includes(gamePictures[n + 7 + i].id)"
              class="picture-likes btn btn-white position-absolute top-0 end-0 rounded-0 m-1 z-2"
              @click="ajaxPictureUpvote(gamePictures[n + 7 + i].id)"
            >
              <span class="me-1">{{ gamePictures[n + 7 + i].ratings_count }}</span>
              <FontAwesomeIcon icon="fa-regular fa-thumbs-up" />
            </button>
          </template>
        </div>
      </div>
      <div class="row w-100 mx-auto p-0">
        <div
          v-for="(d, i) in 3"
          :key="d"
          :class="`glightbox-wrapper position-relative col-12 col-sm col-lg-${gameItems / 3} p-1`"
          data-aos="fade-up"
        >
          <template v-if="gamePictures[n + 9 + i]">
            <a
              :href="getPicturePath(n + 9 + i)"
              class="glightbox"
              data-gallery="games-pictures"
            >
              <div
                class="ratio ratio-16x9 overflow-hidden"
              >
                <img
                  :src="getPicturePath(n + 9 + i)"
                  :alt="'Picture n°' + (n + 10 + i) + ' from the game ' + gameName"
                  :title="'Picture n°' + (n + 10 + i) + ' from the game ' + gameName"
                  class="d-none w-100 z-1"
                  @load="gameImageLazyLoad"
                >
                <div class="picture-loader position-absolute top-0 start-0 w-100 h-100">
                  <div
                    class="d-flex justify-content-center align-items-center w-100 h-100 bg-primary"
                  >
                    <div
                      class="spinner-border text-light"
                      role="status"
                    >
                      <span class="visually-hidden">
                        {{ __("fo_text_loading") }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div
                v-if="picturesRatings.includes(gamePictures[n + 9 + i].id)"
                class="picture-likes position-absolute top-0 end-0 d-flex justify-content-center align-items-center bg-white p-2 m-1 z-2"
              >
                <span
                  :id="`ratings-${gamePictures[n + 9 + i].id}`"
                  class="me-1"
                >
                  {{ gamePictures[n + 9 + i].ratings_count }}
                </span>
                <FontAwesomeIcon icon="fa-solid fa-thumbs-up" />
              </div>
            </a>
            <button
              v-if="!picturesRatings.includes(gamePictures[n + 9 + i].id)"
              class="picture-likes btn btn-white position-absolute top-0 end-0 rounded-0 m-1 z-2"
              @click="ajaxPictureUpvote(gamePictures[n + 9 + i].id)"
            >
              <span class="me-1">{{ gamePictures[n + 9 + i].ratings_count }}</span>
              <FontAwesomeIcon icon="fa-regular fa-thumbs-up" />
            </button>
          </template>
        </div>
      </div>
    </div>
    <div class="w-100 text-center mt-5">
      <div
        v-if="gameLoading"
        class="spinner-border text-primary"
        role="status"
      >
        <span class="visually-hidden">{{ __("fo_text_loading") }}</span>
      </div>
      <div
        v-if="gameAllLoaded"
        class="fst-italic text-secondary"
      >
        {{ __("fo_images_loaded") }}
      </div>
    </div>
  </div>
  <div
    v-else
    class="text-center"
  >
    {{ __("fo_images_no_one") }}
  </div>
</template>

<script lang="ts">
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import GLightbox from "glightbox";
import { defineComponent } from "vue";
import route from "./../../modules/route";
import trans from "./../../modules/trans";

export default defineComponent({
  name: "GamePicturesComponent",
  mixins: [route, trans],
  components: {
    FontAwesomeIcon,
  },
  data(): {
    gameName: string;
    gameSlug: string;
    gamePictures: Array<{
      id: number,
      uuid: string,
      ratings_count: number,
    }>;
    gamePage: number;
    gameLastPage: number;
    gameItems: number;
    gameLoading: boolean;
    gameAllLoaded: boolean;
    gameViewer: GLightbox | null;
    picturesRatings: Array<number>;
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
      picturesRatings: [],
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
    this.picturesRatings = data.ratingModels;
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
          if (response.data.data.data !== undefined) {
            this.gamePictures = this.gamePictures.concat(
              Object.values(response.data.data.data)
            );
          }
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
      const nodeTargetParent = nodeTarget.closest(".glightbox-wrapper");
      nodeTargetParent?.querySelector(".picture-loader")?.classList.add("z-0");
      nodeTargetParent?.querySelector(".picture-loader")?.classList.remove("z-3");
      nodeTargetParent?.querySelector(".btn.picture-likes")?.classList.remove("d-none");
    },
    /**
     * Return the path of the picture.
     *
     * @param number n
     */
    getPicturePath(n: number) {
      return (
        location.origin +
        "/storage/pictures/" +
        this.gameSlug +
        "/" +
        this.gamePictures[n].uuid +
        ".webp"
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
    /**
     * Return a list of games which corresponds to the search from selects.
     */
    ajaxPictureUpvote(id: number): void {
      const updateRatingRoute = route.methods.route("fo.ratings.update");
      if (!updateRatingRoute) {
        throw new Error("Undefined route fo.ratings.update");
      }
      window.axios
        .post(updateRatingRoute, {
          picture_id: id,
        })
        .then((reponse) => {
          this.picturesRatings.push(reponse.data);
          this.$nextTick(() => {
            const ratingsCount = document.getElementById("ratings-" + String(reponse.data)) as HTMLSpanElement|null;
            if (ratingsCount) {
              ratingsCount.textContent = String(Number(ratingsCount.textContent) + 1);
            }
          });
        });
    }
  },
});
</script>
