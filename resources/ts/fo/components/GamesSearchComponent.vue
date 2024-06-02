<template>
  <div
    ref="gamesSearch"
    class="nav-games"
  >
    <!-- Filters -->
    <div
      class="row w-100 justify-content-center align-items-center bg-primary rounded-3 px-0 py-2 mx-auto mb-2"
      novalidate
    >
      <div class="col-12">
        <!-- Filter by text -->
        <div class="d-flex border-bottom border-1 border-secondary pb-1 w-100">
          <input
            name="search"
            v-model="search"
            class="form-control border-0 rounded-3 text-bg-primary me-1 ps-2"
            :placeholder="trans.methods.__('fo_search', { games: `${gamesCount}` })"
            type="text"
            maxlength="60"
            autocomplete="off"
            autofocus
          >
          <button
            @click="clearInputSearch()"
            class="btn btn-primary btn-clear d-flex align-items-center border-0 rounded-3"
            type="button"
            :title="trans.methods.__('fo_clear_search')"
            data-bs-toggle="tooltip"
          >
            <FontAwesomeIcon icon="fa-solid fa-xmark" />
          </button>
        </div>
      </div>
      <div class="col-12 row">
        <!-- Filter by folders -->
        <div class="col-12 col-md-6 border-custom p-0 py-1 pe-md-1 pb-md-0">
          <select
            class="form-select border-0 rounded-3 bg-primary shadow-none text-bg-primary px-2 py-2"
            name="folder"
            role="button"
            @change="setSelectedValue($event)"
          >
            <option
              value="0"
              selected
            >
              {{ trans.methods.__("fo_search_folder") }}
            </option>
            <option
              v-for="(folder, folderIndex) in allFolders"
              :key="folderIndex"
              :value="folder.id"
            >
              {{ folder.nameLocale }}
            </option>
          </select>
        </div>
        <!-- Filter by tags -->
        <div class="col-12 col-md-6 p-0 pt-1 ps-md-1">
          <select
            class="form-select bg-primary rounded-3 border-0 shadow-none text-bg-primary px-2 py-2"
            name="tag"
            role="button"
            @change="setSelectedValue($event)"
          >
            <option
              value="0"
              selected
            >
              {{ trans.methods.__("fo_search_tag") }}
            </option>
            <option
              v-for="(tag, tagIndex) in allTags"
              :key="tagIndex"
              :value="tag.id"
            >
              {{ tag.nameLocale }}
            </option>
          </select>
        </div>
      </div>
    </div>
    <div class="position-relative">
      <!-- List of games -->
      <OverlayScrollbarsComponent
        class="nav-games-list rounded-3"
        defer
      >
        <div
          v-if="gameLoading"
          class="d-flex justify-content-center align-items-center h-100"
        >
          <div
            class="spinner-border text-white"
            role="status"
          >
            <span class="visually-hidden">{{ trans.methods.__("fo_text_loading") }}</span>
          </div>
        </div>
        <template v-else>
          <ul
            v-if="filterGames().length > 0"
            :class="['list-group rounded-0', {'pe-4': filterGames().length > 8}]"
            id="collapseGroup"
          >
            <li
              v-for="(game, key) in filterGames()"
              :key="key"
              class="list-group-item border-0 rounded-2 bg-transparent p-0"
            >
              <a
                :href="getGameRoute(game.slug)"
                class="btn btn-secondary position-relative d-flex flex-row justify-content-between align-items-center border-0 text-light text-decoration-none rounded-0 w-100 p-2"
              >
                <div
                  class="d-flex flex-row justify-content-start align-items-center"
                >
                  <template
                    v-for="(folder, folderIndex) in allFolders"
                    :key="folderIndex"
                  >
                    <span
                      v-if="folder.id === game.folder_id"
                      class="list-group-item-span z-1"
                      :style="`background-color:${folder.color}`"
                    />
                  </template>
                  <p class="text-start m-0 pe-2 z-2">{{ game.name }}</p>
                </div>
                <span>{{ game.pictures.length }}</span>
              </a>
            </li>
          </ul>
          <!-- NO RESULT -->
          <div
            v-else
            class="d-flex flex-column justify-content-center align-items-center border-0 bg-transparent text-light h-100 p-3 pt-0"
          >
            <span class="no-result-icon">
              <FontAwesomeIcon
                icon="fa-solid fa-triangle-exclamation"
                class="w-100 h-100"
              />
            </span>
            <p class="text-center m-0 pt-2">
              {{ trans.methods.__("fo_no_result") }}
            </p>
            <p class="text-center m-0 pb-2">
              {{ trans.methods.__("fo_try_search_again") }}
            </p>
            <button
              class="btn btn-primary"
              @click="clearInputSearch()"
              type="button"
            >
              {{ trans.methods.__("fo_clear_search") }}
            </button>
          </div>
        </template>
      </OverlayScrollbarsComponent>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { OverlayScrollbarsComponent } from "overlayscrollbars-vue";
import { defineOptions, onMounted, ref, useAttrs } from "vue";
import errors from "./../../modules/errors";
import route from "./../../modules/route";
import trans from "./../../modules/trans";
import { Tooltips } from "./../../modules/tooltips";

defineOptions({
  name: "GamesSearchComponent"
});

// * ATTRIBUTES
const attrs = useAttrs();

// * REFS
const gamesSearch = ref<HTMLDivElement|null>(null);

// * DATA
const games = ref<[
  {
    id: number;
    folder_id: number;
    slug: string;
    name: string;
    pictures: Array<Object>;
  }
]>([{
  id: 0,
  folder_id: 0,
  slug: "",
  name: "",
  pictures: [],
}]);
const gamesCount = ref<number>(0);
const search = ref<string>("");
const searchInput = ref<HTMLInputElement|null>(null);
const allTags = ref<LaravelModelList>([]);
const allFolders = ref<LaravelModelList>([]);
const selectedTag = ref<string>("");
const selectedFolder = ref<string>("");
const gameLoading = ref<boolean>(false);
const tooltips = ref<Tooltips|null>(null);

// * LIFECYCLE
onMounted((): void => {
  const json = String(attrs.json ?? "{}"),
        data = JSON.parse(json);
  games.value = data.games;
  gamesCount.value = data.gamesCount;
  allTags.value = data.allTags;
  allFolders.value = data.allFolders;
  searchInput.value = document.querySelector(".nav-games .form-control");
  searchInput.value?.focus();
  initTooltips();
});

// * METHODS

/**
  * Clear input search and selects.
  * @return void
  */
function clearInputSearch(): void {
  if (searchInput.value) searchInput.value.value = "";
  search.value = "";
  document
    .querySelectorAll("select")
    .forEach((element: HTMLSelectElement) => {
      element.value = "0";
    });
  ajaxGamesFiltered([]);
}

/**
  * Return a list of games which corresponds to the search from input text.
  * @return Array<{
  *   id: number;
  *   folder_id: number;
  *   slug: string;
  *   name: string;
  *   pictures: Array<Object>;
  * }>
*/
function filterGames(): Array<{
  id: number;
  folder_id: number;
  slug: string;
  name: string;
  pictures: Array<Object>;
}> {
  return games.value?.filter((game) => {
    return (game.name as string)
      .toLowerCase()
      .includes(search.value.toLowerCase());
  });
}

/**
  * Set selected tag/folder variables.
  * @param e Event on select.
  * @return void
  */
function setSelectedValue(e: Event): void {
  const select = e.target as HTMLSelectElement;
  if (select.name == "tag") selectedTag.value = select.value;
  if (select.name == "folder") selectedFolder.value = select.value;
  ajaxGamesFiltered([selectedTag.value, selectedFolder.value]);
}

/**
  * Return a list of games which corresponds to the search from selects.
  * @return void
  */
function ajaxGamesFiltered(filters: string[]): void {
  gameLoading.value = true;
  const storeTagRoute = route.methods.route("fo.games.filtered");
  if (!storeTagRoute) {
    throw new Error("Undefined route fo.games.filtered");
  }
  window.axios
    .post(storeTagRoute, {
      filters_id: filters,
    })
    .then((reponse) => {
      games.value = reponse.data;
      gameLoading.value = false;
    })
    .catch(errors.methods.ajaxErrorHandler);
}

/**
  * Return the route with the parameter slug given.
  * @param slug Slug of the game.
  * @return string
  */
function getGameRoute(slug: string): string {
  const routeGameShow = route.methods.route("fo.games.show", {
    SLUG: slug,
  });
  if (!routeGameShow) {
    throw new Error("Undefined route fo.games.show");
  }
  return routeGameShow;
}

/**
  * Initialise all tooltips in the component.
  * @return void
  */
function initTooltips(): void {
  setTimeout(() => {
    tooltips.value = Tooltips.make({
      type: "dom",
      elements: gamesSearch.value!.querySelectorAll("[data-bs-toggle=\"tooltip\"]")
    });
  }, 500);
}
</script>

<style lang="scss" scopped>
@import "bootstrap/scss/functions";
@import "bootstrap/scss/variables";
@import "bootstrap/scss/mixins";
@import "bootstrap/scss/placeholders";
@import "overlayscrollbars/overlayscrollbars.css";

.nav-games {
  .form-control {
    height: 40px;
  }
  .form-control::placeholder {
    color: var(--bs-light);
  }
  .border-custom {
    border-bottom: solid 1px var(--bs-secondary) !important;

    @include media-breakpoint-up(md) {
      border-right: solid 1px var(--bs-secondary) !important;
      border-bottom: 0 !important;
    }
  }
  .btn-clear {
    border-top-right-radius: var(--bs-border-radius-lg) !important;
  }
  .no-result-icon {
    width: 4rem;
    height: 4rem;
  }
  .placeholder-glow .placeholder {
    height: 24px;
  }
  .os-scrollbar {
    --os-size: 1rem;
    --os-track-bg: #14171a;
    --os-track-bg-hover: #14171a;
    --os-track-bg-active: #14171a;
    --os-handle-bg: var(--bs-primary);
    --os-handle-bg-hover: #4d6075;
    --os-handle-bg-active: #485a6e;
  }
}
</style>
