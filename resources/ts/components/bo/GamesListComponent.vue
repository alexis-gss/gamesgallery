<template>
  <div class="nav-games nav-games-hidden">
    <form class="input-group p-1">
      <input
        name="search"
        v-model="search"
        class="form-control bg-transparent text-first border-0"
        :placeholder="__('nav.search', { games: `${gamesCount}` })"
        :title="__('nav.search_title')"
        type="text"
        maxlength="60"
        autocomplete="off"
      >
      <input
        type="submit"
        value="submit"
        class="d-none"
        disabled
      >
      <button
        class="btn btn-outline-secondary d-flex align-items-center border-0"
        type="button"
        id="a"
      >
        <svg
          width="16"
          height="16"
          fill="currentColor"
          class="bi bi-x-lg"
          viewBox="0 0 16 16"
        >
          <path
            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"
          />
        </svg>
      </button>
    </form>
    <div class="nav-games-list">
      <ul
        class="list-group rounded-0"
        id="collapseGroup"
      >
        <div
          v-for="(games, folder, id) in folders"
          :key="folder"
        >
          <li
            v-if="Object.keys(games).length > 1"
            class="list-group-item bg-transparent border-0 p-0"
            role="button"
            data-bs-toggle="collapse"
            :data-bs-target="`#collapse${id}`"
            :aria-controls="`collapse${id}`"
          >
            <button
              class="btn d-flex justify-content-between align-items-center bg-second bg-transparent text-first border-0 rounded-0 p-2 w-100"
              type="button"
            >
              <div>
                <svg
                  width="18"
                  height="16"
                  fill="currentColor"
                  class="bi bi-folder"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"
                  />
                </svg>
                <span class="ms-1">{{ folder }}</span>
              </div>
              <span class="badge rounded-4">
                {{ Object.keys(games).length }}
              </span>
            </button>
            <ul
              class="list-group position-relative overflow-hidden rounded-0 collapse border-0 py-0 pe-0"
              :id="`collapse${id}`"
              data-bs-parent="#collapseGroup"
            >
              <li
                v-for="(game, key2) in games"
                :key="key2"
                class="list-group-item list-group-folder border-0 bg-second bg-transparent p-0"
              >
                <a
                  :href="getGameRoute(game.slug)"
                  class="btn border-0 d-flex flex-row justify-content-start align-items-center text-first text-decoration-none p-2 ps-3"
                  data-bs="tooltip"
                  data-bs-placement="right"
                  :title="
                    __('nav.list_game', {
                      number: `${game.pictures.length}`,
                      game: `${game.name}`,
                    })
                  "
                >
                  <svg
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="me-1"
                    viewBox="0 0 16 16"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z"
                    />
                  </svg>
                  <span>{{ game.name }}</span>
                </a>
              </li>
            </ul>
          </li>
          <li
            v-else
            v-for="(game, key3) in games"
            :key="key3"
            class="list-group-item border-0 bg-second bg-transparent p-0"
          >
            <a
              :href="getGameRoute(game.slug)"
              class="btn border-0 d-flex flex-row justify-content-start align-items-center text-first text-decoration-none p-2"
              data-bs="tooltip"
              data-bs-placement="right"
              :title="
                __('nav.list_game', {
                  number: `${game.pictures.length}`,
                  game: `${game.name}`,
                })
              "
            >
              <span>{{ game.name }} </span>
            </a>
          </li>
        </div>
      </ul>
      <p class="no-result d-none">
        {{ __("nav.no_result") }}
      </p>
    </div>
    <div class="nav-options nav-options-hidden">
      YO LES GENS
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import route from "../../modules/route";
import trans from "../../modules/trans";
import { Tooltip } from "bootstrap";

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
    folders: [
      {
        folder: {
          name: string;
          slug: string;
          pictures: Array<String>;
        };
      }
    ];
    gamesCount: number;
    search: string;
  } {
    return {
      folders: [{ folder: { name: "", slug: "", pictures: [""] } }],
      gamesCount: 0,
      search: "cyb",
    };
  },
  mounted() {
    const json = String(this.$attrs.json ?? "{}");
    const data = JSON.parse(json);
    this.folders = data.games;
    this.gamesCount = data.gamesCount;
    this.initBootstrapTooltips();
    this.filterGames();
  },
  methods: {
    /**
     * Search a word among the games list.
     */
    filterGames() {},
    /**
     * Init tooltips of Bootstrap.
     */
    initBootstrapTooltips() {
      this.$nextTick(() => {
        let tooltipTriggerList = [].slice.call(
          document.querySelectorAll(".nav-games [data-bs=\"tooltip\"]")
        );
        tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new Tooltip(tooltipTriggerEl, {
            delay: { show: 1000, hide: 300 },
          });
        });
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
  },
});
</script>
