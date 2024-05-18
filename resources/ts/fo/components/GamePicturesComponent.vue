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
              class="glightbox-wrapper position-relative col-12 p-0"
              :class="((templateValue % 2 === 0) ? `col-sm-6` : `col-sm-12`) + ` col-lg-${gameItems / templateValue}`"
              data-aos="fade-up"
            >
              <div
                class="p-1"
                v-if="gamePictures[getPictureNumber(paginateIndex, templateIndex) + pictureIndex]"
              >
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
                            {{ trans.methods.__("fo_text_loading") }}
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
              </div>
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
          <span class="visually-hidden">{{ trans.methods.__("fo_text_loading") }}</span>
        </div>
        <div
          v-if="gameAllLoaded"
          class="fst-italic text-secondary"
        >
          {{ trans.methods.__("fo_images_loaded") }}
        </div>
      </div>
    </template>
    <div
      v-else
      class="text-center"
    >
      {{ trans.methods.__("fo_images_no_one") }}
    </div>
  </div>
</template>

<script lang="ts" setup>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { Toast } from "bootstrap";
import GLightbox from "glightbox";
import { computed, defineOptions, onMounted, ref, useAttrs, nextTick } from "vue";
import route from "./../../modules/route";
import trans from "./../../modules/trans";

defineOptions({
  name: "GamePicturesComponent"
});

// * ATTRIBUTES
const attrs = useAttrs();

// * DATA
const gameName = ref<string>("");
const gameSlug = ref<string>("");
const gamePictures = ref<Array<{
  id: number,
  uuid: string,
  ratings_count: number,
}>>([]);
const gamePage = ref<number>(0);
const gameLastPage = ref<number>(0);
const gameItems = ref<number>(0);
const gameLoading = ref<boolean>(false);
const gameAllLoaded = ref<boolean>(false);
const gameViewer = ref<GLightbox|null>(null);
const picturesTemplate = ref<Array<number>>([4,3,2,3]);
const picturesRatings = ref<Array<number>>([]);
const ratingLoading = ref<boolean>(false);

// * LIFECYCLE
onMounted((): void => {
  const json = String(attrs.json ?? "{}"),
        data = JSON.parse(json);
  gameName.value = data.gameName;
  gameSlug.value = data.gameSlug;
  gamePage.value = data.gamePictures.current_page;
  gameLastPage.value = data.gamePictures.last_page;
  gameItems.value =
    data.gamePictures.per_page < 12 ? 12 : data.gamePictures.per_page;
  picturesRatings.value = data.ratingModels;
  checkScroll();
  getPictures();
});

// * COMPUTED

/**
  * Increment the current page number when the
  * user scroll to the bottom.
  * @return Array<number>
  */
const incrementNumber = computed<Array<number>>(() => gamePictures.value.map((_, index) => index).filter((index) => index % gameItems.value === 0));

// * METHODS

/**
  * Increment the current page number when the
  * user scroll to the bottom.
  * @return void
  */
function checkScroll(): void {
  window.addEventListener("scroll", () => {
    if (
      window.innerHeight + window.scrollY >=
      document.body.offsetHeight - 300 &&
      !gameLoading.value
    ) {
      if (gamePage.value < gameLastPage.value) {
        gamePage.value++;
        gameLoading.value = true;
        getPictures();
      } else {
        gameAllLoaded.value = true;
      }
    }
  });
}

/**
  * Load the current page.
  @return void
  */
function getPictures(): void {
  const url = "?page=" + gamePage.value;
  window.axios
    .get(url)
    .then((response) => {
      if (response.data.data.data !== undefined) {
        gamePictures.value = gamePictures.value.concat(
          Object.values(response.data.data.data)
        );
      }
      gameLoading.value = false;
      updateGlightbox();
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
}

/**
  * Show image when she loaded,
  * Hide the placeholder's image.
  * @param {Event} e
  * @return void
  */
function gameImageLazyLoad(e: Event): void {
  const nodeTarget = e.target as HTMLImageElement;
  nodeTarget.classList.remove("d-none");
  const nodeTargetParent = nodeTarget.closest(".glightbox-wrapper");
  nodeTargetParent?.querySelector(".picture-loader")?.classList.add("z-0");
  nodeTargetParent?.querySelector(".picture-loader")?.classList.remove("z-3");
  nodeTargetParent?.querySelector(".btn.picture-likes")?.classList.remove("d-none");
}

/**
  * Return the path of the picture.
  * @param number n
  * @return void
  */
function getPicturePath(n: number) {
  return (
    location.origin +
    "/storage/pictures/" +
    gameSlug.value +
    "/" +
    gamePictures.value[n].uuid +
    ".webp"
  );
}

/**
  * Update Glightbox elements.
  * @return void
  */
function updateGlightbox() {
  setTimeout(() => {
    gameViewer.value?.destroy();
    gameViewer.value = new GLightbox({
      selector: ".glightbox",
    });
  }, 800);
}

/**
  * Return a list of games which corresponds to the search from selects.
  * @return void
  */
function ajaxPictureUpvote(id: number): void {
  ratingLoading.value = true;
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
        picturesRatings.value.splice(picturesRatings.value.indexOf(reponse.data.picture_id), 1);
        numberToAdd = "-1";
      } else {
        picturesRatings.value.push(reponse.data.picture_id);
        numberToAdd = "+1";
      }
      nextTick(() => {
        const ratingsCount = document.getElementById("ratings-" + String(reponse.data.picture_id)) as HTMLSpanElement|null;
        if (ratingsCount) {
          ratingsCount.textContent = String(Number(ratingsCount.textContent) + Number(numberToAdd));
        }
        ratingLoading.value = false;
        showToastLike(numberToAdd, ratingsCount?.getAttribute("data-picture-id"), reponse.data.rating_exist);
      });
    });
}

/**
  * Show a new bootstrap toast.
  * @return void
  */
function showToastLike(numberToAdd: string, pictureNumber: string|null|undefined, like: boolean): void {
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
      toastGameName.textContent = gameName.value;
    // Set action text.
    let toastAction = toastLike.querySelector(".toast-action");
    let toastActionDetail = toastLike.querySelector(".toast-action-detail");
    if (toastAction)
      toastAction.textContent = (like) ? trans.methods.__("fo_toast_unlike") : trans.methods.__("fo_toast_like");
    if (toastActionDetail)
      toastActionDetail.textContent = (like) ? trans.methods.__("fo_toast_message_unlike") : trans.methods.__("fo_toast_message_like");
    bootstrapToast?.show();
    toastLike.addEventListener("hidden.bs.toast", () => {
      toastLike.remove();
    });
  }
}

/**
  * Return the number of the picture.
  * @param paginateIndex
  * @param templateIndex
  * @return number
  */
function getPictureNumber(paginateIndex: number, templateIndex: number): number {
  let result = 0;
  if (picturesTemplate.value[templateIndex - 1] !== undefined) {
    for (let index = 0; index <= templateIndex - 1; index++) {
      result += picturesTemplate.value[index];
    }
  } else {
    result = 0;
  }
  return paginateIndex + result;
}
</script>

<style lang="scss" scopped>
@import "./../../../sass/fo/utilities/variables";

.gscrollbar-fixer {
  margin: auto !important;
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
