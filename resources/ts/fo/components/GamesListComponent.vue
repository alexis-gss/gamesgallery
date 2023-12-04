<template>
  <div class="nav-games">
    <!-- Filters -->
    <div
      class="row w-100 justify-content-center align-items-center bg-primary rounded-3 px-0 py-2 mx-auto mb-2"
      novalidate
    >
      <div class="col-12">
        <!-- Filter by text -->
        <div class="d-flex border-bottom border-1 border-secondary w-100 pb-1">
          <input
            name="search"
            v-model="search"
            class="form-control bg-transparent border-0 shadow-none text-white p-0 ps-2"
            :placeholder="__('texts.fo.search', { games: `${gamesCount}` })"
            type="text"
            maxlength="60"
            autocomplete="off"
            autofocus
          >
          <button
            @click="clearInputSearch()"
            class="btn d-flex align-items-center text-white border-0"
            type="button"
          >
            <i class="fa-solid fa-xmark" />
          </button>
        </div>
      </div>
      <div class="col-12 row">
        <!-- Filter by folders -->
        <select
          class="col-6 form-select bg-primary border-0 border-end border-1 border-secondary shadow-none text-white rounded-0 w-50 px-2 pt-2 py-1"
          name="folder"
          role="button"
          @change="setSelectedValue($event)"
        >
          <option
            value="0"
            selected
          >
            {{ __("texts.fo.search_folder") }}
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
          class="col-6 form-select bg-primary border-0 shadow-none text-white rounded-0 w-50 px-2 pt-2 py-1"
          name="tag"
          role="button"
          @change="setSelectedValue($event)"
        >
          <option
            value="0"
            selected
          >
            {{ __("texts.fo.search_tag") }}
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
    <simplebar
      class="nav-games-list"
      data-simplebar-auto-hide="false"
    >
      <div
        v-if="gameLoading"
        class="d-flex justify-content-center align-items-center h-100"
      >
        <div
          class="spinner-border text-white"
          role="status"
        >
          <span class="visually-hidden">{{ __("texts.fo.text_loading") }}</span>
        </div>
      </div>
      <ul
        v-else
        class="list-group rounded-0 pe-2"
        id="collapseGroup"
      >
        <template v-if="filterGames().length > 0">
          <li
            v-for="(game, key) in filterGames()"
            :key="key"
            class="list-group-item border-0 rounded-2 bg-transparent p-0 px-1"
          >
            <a
              :href="getGameRoute(game.slug)"
              class="position-relative d-flex flex-row justify-content-between align-items-center btn border-0 text-white text-decoration-none w-100 p-2"
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
                    class="list-group-item-span"
                    :style="`background-color:${folder.color}`"
                  />
                </template>
                <span>{{ game.name }}</span>
              </div>
              <span>{{ game.countpictures }}</span>
            </a>
          </li>
        </template>
        <li
          v-else
          class="list-group-item border-0 bg-transparent text-white p-0"
        >
          <p class="text-decoration-none m-0 p-2">
            {{ __("texts.fo.no_result") }}
          </p>
        </li>
      </ul>
    </simplebar>
  </div>
</template>

<script lang="ts">
import simplebar from "simplebar-vue";
import { defineComponent } from "vue";
import route from "../../modules/route";
import trans from "../../modules/trans";

export default defineComponent({
  name: "GamesListComponent",
  mixins: [route, trans],
  components: {
    simplebar,
  },
  data(): {
    games: [
      {
        id: number;
        folder_id: number;
        slug: string;
        name: string;
        countpictures: number;
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
          folder_id: 0,
          slug: "",
          name: "",
          countpictures: 0,
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
      return this.games?.filter((game) => {
        return (game.name as string)
          .toLowerCase()
          .includes(this.search.toLowerCase());
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
      const storeTagRoute = route.methods.route("fo.games.filtered");
      if (!storeTagRoute) {
        throw new Error("Undefined route fo.games.filtered");
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
      const route = this.route("fo.games.show", {
        SLUG: slug,
      });
      if (!route) {
        throw new Error("Undefined route fo.games.show");
      }
      return route;
    },
  },
});
</script>
