<template>
  <div class="nav-games nav-games-hidden">
    <form
      class="d-flex justify-content-center align-items-center bg-fifth rounded-3 px-3 py-2 pe-0 mb-3"
      novalidate
    >
      <input
        name="search"
        v-model="search"
        class="form-control bg-transparent border-0 shadow-none text-first p-0"
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
    </form>
    <div class="nav-games-list">
      <ul
        class="list-group rounded-0"
        id="collapseGroup"
      >
        <div v-if="filterGames().length > 0">
          <li
            v-for="(game, key) in filterGames()"
            :key="key"
            class="list-group-item border-0 bg-second bg-transparent p-0"
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
        pictures: Array<string>;
      }
    ];
    gamesCount: number;
    search: string;
    searchInput: HTMLInputElement | null;
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
    };
  },
  mounted() {
    const json = String(this.$attrs.json ?? "{}");
    const data = JSON.parse(json);
    this.games = data.games;
    this.gamesCount = data.gamesCount;
    this.searchInput = document.querySelector(".nav-games .form-control");
  },
  methods: {
    /**
     * Clear input search.
     */
    clearInputSearch() {
      if (this.searchInput) this.searchInput.value = "";
      this.search = "";
    },

    /**
     * Return a list which corresponds to the search.
     */
    filterGames() {
      return this.games.filter((game) => {
        return game.name.toLowerCase().includes(this.search.toLowerCase());
      });
    },

    /**
     * Return the route with the parameter slug given.
     *
     * @param slug string
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
     * @param gamePictures array
     * @return string
     */
    getGamePicturesCount(gamePictures: Array<string>): string {
      if (gamePictures != null) {
        return `${gamePictures.length}`;
      } else {
        return "0";
      }
    },
  },
});
</script>
