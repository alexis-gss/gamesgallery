<template>
  <div class="nav-games nav-games-hidden">
    <!-- Filters -->
    <div
      class="row w-100 justify-content-center align-items-center bg-fifth rounded-3 px-0 py-2 mx-auto my-3"
      novalidate
    >
      <div class="col-12">
        <!-- Filter by text -->
        <div class="d-flex border-bottom border-1 border-secondary w-100 pb-1">
          <input
            name="search"
            v-model="search"
            class="form-control bg-transparent border-0 shadow-none text-first p-0 ps-2"
            :placeholder="__('nav.search', { games: `${gamesCount}` })"
            type="text"
            maxlength="60"
            autocomplete="off"
            autofocus
          >
          <button
            @click="clearInputSearch()"
            class="btn d-flex align-items-center text-first border-0"
            type="button"
          >
            <i class="fa-solid fa-xmark" />
          </button>
        </div>
      </div>
      <div class="col-12 row">
        <!-- Filter by folders -->
        <select
          class="col-6 form-select bg-fifth border-0 border-end border-1 border-secondary shadow-none text-first rounded-0 w-50 px-2 py-1"
          name="folder"
          role="button"
          @change="setSelectedValue($event)"
        >
          <option
            value="0"
            selected
          >
            {{ __("nav.search_folder") }}
          </option>
          <option
            v-for="(folder, folderIndex) in allFolders"
            :key="folderIndex"
            :value="folder.id"
          >
            {{ folder.name }}
          </option>
        </select>
        <!-- Filter by tags -->
        <select
          class="col-6 form-select bg-fifth border-0 shadow-none text-first rounded-0 w-50 px-2 py-1"
          name="tag"
          role="button"
          @change="setSelectedValue($event)"
        >
          <option
            value="0"
            selected
          >
            {{ __("nav.search_tag") }}
          </option>
          <option
            v-for="(tag, tagIndex) in allTags"
            :key="tagIndex"
            :value="tag.id"
          >
            {{ tag.name }}
          </option>
        </select>
      </div>
    </div>
    <!-- List of games -->
    <div class="nav-games-list">
      <div
        v-if="gameLoading"
        class="text-center w-100"
      >
        <div
          class="spinner-border text-secondary"
          role="status"
        >
          <span class="visually-hidden">{{ __("nav.text_loading") }}</span>
        </div>
      </div>
      <ul
        v-else
        class="list-group rounded-0"
        id="collapseGroup"
      >
        <div v-if="filterGames().length > 0">
          <li
            v-for="(game, key) in filterGames()"
            :key="key"
            class="list-group-item border-0 rounded-2 bg-second bg-transparent p-0"
          >
            <a
              :href="getGameRoute(game.slug)"
              class="d-flex flex-row justify-content-between align-items-center btn border-0 text-decoration-none w-100 p-2"
            >
              {{ game.name }}
              <span>{{ getGamePicturesCount(game.pictures) }}</span>
            </a>
          </li>
        </div>
        <li
          v-else
          class="list-group-item border-0 bg-transparent p-0"
        >
          <p class="text-decoration-none m-0 p-2">
            {{ __("nav.no_result") }}
          </p>
        </li>
      </ul>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import route from "../../modules/route";
import trans from "../../modules/trans";

export default defineComponent({
  mixins: [route, trans],
  inheritAttrs: false,
  props: {
    jsonData: {
      type: String,
      default: "[]",
    },
  },
  data(): {
    games: [
      {
        id: number;
        slug: string;
        name: string;
        pictures: string[];
      }
    ];
    gamesCount: number;
    search: string;
    searchInput: HTMLInputElement | null;
    allTags: LaravelModel[];
    allFolders: LaravelModel[];
    selectedTag: string;
    selectedFolder: string;
    gameLoading: boolean;
  } {
    return {
      games: [
        {
          id: 0,
          slug: "",
          name: "",
          pictures: [],
        },
      ],
      gamesCount: 0,
      search: "",
      searchInput: null,
      allTags: [],
      allFolders: [],
      selectedTag: "",
      selectedFolder: "",
      gameLoading: false,
    };
  },
  mounted() {
    const json = String(this.$attrs.json ?? "{}");
    const data = JSON.parse(json);
    this.games = data.games;
    this.gamesCount = data.gamesCount;
    this.allTags = data.allTags;
    this.allFolders = data.allFolders;
    this.searchInput = document.querySelector(".nav-games .form-control");
  },
  methods: {
    /**
     * Clear input search and selects.
     */
    clearInputSearch() {
      if (this.searchInput) this.searchInput.value = "";
      this.search = "";
      this.ajaxGamesFiltered([]);
      document
        .querySelectorAll("select")
        .forEach((element: HTMLSelectElement) => {
          element.value = "0";
        });
    },
    /**
     * Return a list of games which corresponds to the search from input text.
     */
    filterGames() {
      return this.games.filter((game) => {
        return game.name.toLowerCase().includes(this.search.toLowerCase());
      });
    },
    /**
     * Set selected tag/folder variables.
     *
     * @param e Event on select.
     */
    setSelectedValue(e: Event) {
      const select = e.target as HTMLSelectElement;
      if (select.name == "tag") this.selectedTag = select.value;
      if (select.name == "folder") this.selectedFolder = select.value;
      this.ajaxGamesFiltered([this.selectedTag, this.selectedFolder]);
    },
    /**
     * Return a list of games which corresponds to the search from selects.
     */
    ajaxGamesFiltered(filters: string[]): void {
      this.gameLoading = true;
      const storeTagRoute = route.methods.route("games.filtered");
      if (!storeTagRoute) {
        throw new Error("Undefined route games.filtered");
      }
      window.axios
        .post(storeTagRoute, {
          FILTERSID: filters,
        })
        .then((reponse) => {
          this.games = reponse.data;
          this.gameLoading = false;
        });
    },
    /**
     * Return the route with the parameter slug given.
     *
     * @param slug Slug of the game.
     * @return string
     */
    getGameRoute(slug: string): string {
      const route = this.route("games.specific", {
        SLUG: slug,
      });
      if (!route) {
        throw new Error("Undefined route games.specific");
      }
      return route;
    },

    /**
     * Return the count of the pictures of the game.
     *
     * @param gamePictures Array of pictures of the game.
     * @return string
     */
    getGamePicturesCount(gamePictures: Array<string>): string {
      return gamePictures != null ? String(gamePictures.length) : "0";
    },
  },
});
</script>
