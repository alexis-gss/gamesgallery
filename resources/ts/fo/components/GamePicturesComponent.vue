<template>
  <div class="position-relative">
    <template v-if="gameLoading || gamePictures.length > 0">
      <template
        v-for="paginateIndex in incrementNumber"
        :key="paginateIndex"
      >
        <template
          v-for="(templateValue, templateIndex) in picturesTemplate"
          :key="templateIndex"
        >
          <div class="row w-100 mx-auto p-0">
            <div
              v-for="(pictureValue, pictureIndex) in templateValue"
              :key="pictureValue"
              :class="`glightbox-wrapper position-relative col-12 col-sm-6 col-lg-${gameItems / templateValue} p-1`"
              data-aos="fade-up"
            >
              <template v-if="gamePictures[getPictureNumber(paginateIndex, templateIndex) + pictureIndex]">
                <a
                  :href="getPicturePath(getPictureNumber(paginateIndex, templateIndex) + pictureIndex)"
                  class="glightbox"
                  data-gallery="games-pictures"
                >
                  <div
                    class="ratio ratio-16x9 overflow-hidden"
                  >
                    <img
                      :src="getPicturePath(getPictureNumber(paginateIndex, templateIndex) + pictureIndex)"
                      :alt="'Picture n°' + (getPictureNumber(paginateIndex, templateIndex) + pictureIndex + 1) + ' from the game ' + gameName"
                      :title="'Picture n°' + (getPictureNumber(paginateIndex, templateIndex) + pictureIndex + 1) + ' from the game ' + gameName"
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
                </a>
                <button
                  class="picture-likes btn btn-white position-absolute bottom-0 end-0 rounded-0 m-1 z-2"
                  :class="(ratingLoading) ? 'disabled': ''"
                  :disabled="ratingLoading"
                  @click="ajaxPictureUpvote(gamePictures[getPictureNumber(paginateIndex, templateIndex) + pictureIndex].id)"
                >
                  <span
                    :id="`ratings-${gamePictures[getPictureNumber(paginateIndex, templateIndex) + pictureIndex].id}`"
                    :data-picture-id="getPictureNumber(paginateIndex, templateIndex) + pictureIndex"
                    class="me-1"
                  >
                    {{ gamePictures[getPictureNumber(paginateIndex, templateIndex) + pictureIndex].ratings_count }}
                  </span>
                  <FontAwesomeIcon
                    icon="fa-regular fa-thumbs-up"
                    :class="(picturesRatings.includes(gamePictures[getPictureNumber(paginateIndex, templateIndex) + pictureIndex].id)) ? 'd-none' : ''"
                  />
                  <FontAwesomeIcon
                    icon="fa-solid fa-thumbs-up"
                    :class="(!picturesRatings.includes(gamePictures[getPictureNumber(paginateIndex, templateIndex) + pictureIndex].id)) ? 'd-none' : ''"
                  />
                </button>
              </template>
            </div>
          </div>
        </template>
      </template>
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
    </template>
    <div
      v-else
      class="text-center"
    >
      {{ __("fo_images_no_one") }}
    </div>
  </div>
</template>

<script lang="ts">
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { Toast } from "bootstrap";
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
    picturesTemplate: Array<number>;
    picturesRatings: Array<number>;
    ratingLoading: boolean;
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
      picturesTemplate: [4,3,2,3],
      picturesRatings: [],
      ratingLoading: false,
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
      this.ratingLoading = true;
      const updateRatingRoute = route.methods.route("fo.ratings.update");
      if (!updateRatingRoute) {
        throw new Error("Undefined route fo.ratings.update");
      }
      window.axios
        .post(updateRatingRoute, {
          picture_id: id,
        })
        .then((reponse) => {
          // Add or remove the vote.
          let numberToAdd = "0";
          if (reponse.data.rating_exist) {
            this.picturesRatings.splice(this.picturesRatings.indexOf(reponse.data.picture_id), 1);
            numberToAdd = "-1";
          } else {
            this.picturesRatings.push(reponse.data.picture_id);
            numberToAdd = "+1";
          }
          this.$nextTick(() => {
            const ratingsCount = document.getElementById("ratings-" + String(reponse.data.picture_id)) as HTMLSpanElement|null;
            if (ratingsCount) {
              ratingsCount.textContent = String(Number(ratingsCount.textContent) + Number(numberToAdd));
            }
            this.ratingLoading = false;
            this.showToastLike(numberToAdd, ratingsCount?.getAttribute("data-picture-id"), reponse.data.rating_exist);
          });
        });
    },
    /**
     * Show a new bootstrap toast.
     */
    showToastLike(numberToAdd: string, pictureNumber: string|null|undefined, like: boolean) {
      let toastContainer = document.querySelector(".toast-container");
      let toastTemplate = document.querySelector(".toast-container .toast");
      if (toastTemplate) {
        let toastLike = toastTemplate.cloneNode(true) as HTMLElement;
        toastContainer?.appendChild(toastLike);
        const bootstrapToast = new Toast(toastLike);
        // Set badge data.
        let toastLikeBadge = toastLike.querySelector(".badge");
        if (toastLikeBadge) {
          toastLikeBadge.textContent = numberToAdd;
          toastLikeBadge.classList.add((like) ? "bg-danger" : "bg-success");
        }
        // Set picture number.
        let toastPictureId = toastLike.querySelector(".toast-picture-id");
        if (toastPictureId && pictureNumber)
          toastPictureId.textContent = String(Number(pictureNumber) + 1);
        // Set game name.
        let toastGameName = toastLike.querySelector(".toast-game-name");
        if (toastGameName)
          toastGameName.textContent = this.gameName;
        // Set action text.
        let toastAction = toastLike.querySelector(".toast-action");
        let toastActionDetail = toastLike.querySelector(".toast-action-detail");
        if (toastAction)
          toastAction.textContent = (like) ? trans.methods.__("fo_toast_unlike") : trans.methods.__("fo_toast_like");
        if (toastActionDetail)
          toastActionDetail.textContent = (like) ? "de retirer" : "d'ajouter";
        bootstrapToast?.show();
        toastLike.addEventListener("hidden.bs.toast", () => {
          toastLike.remove();
        });
      }
    },
    /**
     * Return the number of the picture.
     *
     * @param paginateIndex
     * @param templateIndex
     */
    getPictureNumber(paginateIndex: number, templateIndex: number) {
      let result = 0;
      if (this.picturesTemplate[templateIndex - 1] !== undefined) {
        for (let index = 0; index <= templateIndex - 1; index++) {
          result += this.picturesTemplate[index];
        }
      } else {
        result = 0;
      }
      return paginateIndex + result;
    }
  },
});
</script>

<style lang="scss" scoped>
@import "./../../../sass/fo/utilities/variables";
.gscrollbar-fixer {
  margin: auto !important;
}
.nav-games .form-control::placeholder {
  color: #{$color-light};
}
.glightbox {
  z-index: 10;
  transition: .3s;
  img {
    transition: .3s;
  }
}
.glightbox-wrapper:hover img,
.glightbox-wrapper:focus img {
  transform: scale(1.05) !important;
}
.picture-likes {
  width: fit-content;
  min-width: 55px;
  height: 40px;
  transition: .3s !important;
}
</style>
