<template>
  <div :class="`ranks-${intId} position-relative`">
    <Transition name="fade">
      <p
        v-if="intMessage"
        class="d-flex align-items-center text-danger mb-2"
      >
        <span>{{ Object.values(intMessage)[0] }}&nbsp;</span>
      </p>
    </Transition>
    <vue-nestable
      :value="intRanks"
      @change="updateRank"
      @input="intRanks = $event"
      :hooks="{ beforeMove: beforeMove }"
    >
      <template
        #default="{
          item,
        }: { item: RankObject }"
      >
        <vue-nestable-handle
          class="d-flex justify-content-between align-items-center border rounded p-1"
        >
          <div class="d-flex justify-content-start align-items-center">
            <button class="btn btn-sm border-0 disabled opacity-100">
              <FontAwesomeIcon icon="fa-solid fa-grip-vertical" />
            </button>
            <p class="m-0">
              <span class="badge bg-secondary">
                {{ item.rank }}
              </span>
            </p>
            &nbsp;
            <p class="m-0">
              {{ item.game_name }}
            </p>
          </div>
          <div
            class="d-flex justify-content-end align-items-center"
          >
            <div class="input-group">
              <a
                :href="getShowGameRoute(item.game_slug)"
                class="btn btn-sm btn-warning"
                target="_blank"
                :title="__('bo_tooltip_ranking_see_game')"
                data-bs-tooltip="tooltip"
              >
                <FontAwesomeIcon icon="fa-solid fa-eye" />
              </a>
              <a
                :href="getEditGameRoute(item.game_id)"
                class="btn btn-sm btn-primary"
                :title="__('bo_tooltip_ranking_update_game')"
                data-bs-tooltip="tooltip"
              >
                <FontAwesomeIcon icon="fa-solid fa-pencil" />
              </a>
              <button
                @click="deleteRank($event, item as never as RankObject)"
                class="btn btn-sm btn-danger confirmDelete"
                :title="__('bo_tooltip_ranking_delete_game')"
                data-bs-tooltip="tooltip"
                ref="confirmDelete"
              >
                <FontAwesomeIcon icon="fa-solid fa-xmark" />
              </button>
            </div>
          </div>
        </vue-nestable-handle>
      </template>
    </vue-nestable>
    <div
      v-if="intLoading"
      class="loading position-absolute top-0 start-0 d-flex justify-content-center align-items-center rounded-1 w-100 h-100"
    >
      <div
        class="spinner-border text-secondary"
        role="status"
      >
        <span class="visually-hidden">
          {{ __("bo_tooltip_viewer_loading") }}
        </span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { defineComponent } from "vue";
import { VueNestable, VueNestableHandle } from "vue3-nestable";
import route from "./../../modules/route";
import tooltip from "./../../modules/tooltip";
import error from "././../../modules/error";
import sweetalert from "././../../modules/sweetalert";
import trans from "././../../modules/trans";

export default defineComponent({
  name: "GamesRankingComponent",
  components: {
    VueNestable,
    VueNestableHandle,
    FontAwesomeIcon,
  },
  mixins: [error, route, sweetalert, tooltip, trans],
  data(): {
    intCsrf: string | null | undefined;
    intId: String;
    intRanks: RankObject[];
    intGames: LaravelModel[];
    intMessage: object | object[] | null;
    intLoading: boolean;
  } {
    return {
      intCsrf: document
        .querySelector("meta[name=\"csrf-token\"]")
        ?.getAttribute("content"),
      intId: "",
      intRanks: [],
      intGames: [],
      intMessage: null,
      intLoading: false,
    };
  },
  mounted() {
    const json = String(this.$attrs.json ?? "{}");
    const data = JSON.parse(json);
    this.intId = data.id;
    this.intRanks = data.rankModels;
    this.$nextTick(() => {
      this.setBootstrapTooltip();
    });
  },
  methods: {
    /** Check the deep of current item before the move. */
    beforeMove({
      pathTo,
    }: {
      pathTo: number[];
    }) {
      if (pathTo.length == 2) {
        return false;
      }
      return true;
    },
    /** Update data's ranks. */
    updateRank() {
      let newOrder = this.assignRank(this.intRanks);
      const route = this.route("bo.ranks.saveOrder");
      if (!route) {
        throw new Error("Undefined route bo.ranks.saveOrder");
      }
      window.axios.post(route, { ranks: newOrder }).catch(this.ajaxErrorHandler);
      this.$nextTick(() => {
        this.setBootstrapTooltip();
      });
    },
    /** Assign the new order and parent id to each rank. */
    assignRank(ranks: RankObject[]) {
      ranks.forEach((element, index) => {
        element.rank = index + 1;
      });
      return ranks;
    },
    /** Return show route for a game. */
    getShowGameRoute(slug: string): string {
      const route = this.route("fo.games.show", {
        SLUG: slug,
      });
      if (!route) {
        throw new Error("Undefined route fo.games.show");
      }
      return route;
    },
    /** Return edit route for a game. */
    getEditGameRoute(id: number): string {
      const route = this.route("bo.games.edit", {
        ID: id,
      });
      if (!route) {
        throw new Error("Undefined route bo.games.edit");
      }
      return route;
    },
    /** Delete specific game from the ranking. */
    deleteRank(e: Event, model: RankObject) {
      const btnConfirmDelete = this.$refs.confirmDelete as HTMLButtonElement;
      let promise:Promise<boolean>|null = null;
      (async () => {
        if (promise !== null && await promise === false) {
          return;
        }
        promise = new Promise((resolve: (value: boolean) => void) => {
          sweetalert.methods.confirm(
            "Confirmez",
            "Êtes vous sure ?",
            btnConfirmDelete,
            function (response) {
              resolve(response.isConfirmed);
            },
            { icon: "warning" }
          );
          return false;
        });
        if (await promise) {
          this.intLoading = true;
          const route = this.route("bo.ranks.destroy", {
            ID: model.id as number,
          });
          if (!route) {
            throw new Error("Undefined route bo.ranks.destroy");
          }
          window.axios
            .post(route, { id: model.id, _method: "DELETE" })
            .then((reponse) => {
              if (reponse.data[0] !== undefined) {
                this.intRanks = reponse.data;
                this.updateRank();
              } else {
                this.intMessage = reponse.data;
                setTimeout(() => {
                  this.intMessage = null;
                  this.$nextTick(() => {
                    this.setBootstrapTooltip();
                  });
                }, 6000);
              }
              this.intLoading = false;
              this.$nextTick(() => {
                this.setBootstrapTooltip();
              });
            })
            .catch(this.ajaxErrorHandler);
        }
      })();
    },
    ajaxErrorHandler(e: any) {
      this.intLoading = false;
      let message = this.__("Une erreur est survenue");
      if (e.response.status === 422) {
        message =
          this.parseValidationErrors(
            e.response?.data?.errors ?? {}
          ) || message;
        if (window.vueDebug) {
          console.warn(e.response.data.errors);
        }
      } else if (e.response.status === 419) {
        // * CSRF TOKEN MISMATCH (On ne pourrais plus faire d'appels AJAX sans recharger la page)
        console.log(this.__("Votre session a expiré, la page va être rechargée"));
        setTimeout(() => window.location.reload(), 2000);
      } else if (e.response.status === 403) {
        // * Access denied
        console.log(this.__("Vous n'êtes pas autorisé a effectuer cette action"));
        setTimeout(() => window.location.reload(), 2000);
      } else {
        if (window.vueDebug) {
          console.error(e);
        }
      }
      console.log(message);
    }
  },
});
</script>

<style lang="scss">
.ranks-games {
  .loading {
    z-index: 5;
    background-color: rgb(0 0 0 / 15%);
  }
  .badge {
    color: var(--bs-body-bg);
  }
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.5s ease;
  }
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  .nestable-list {
    padding: 0;
    list-style: none;
  }
  .nestable {
    position: relative;
    [draggable="true"] {
      cursor: move;
    }
    .nestable-rtl {
      direction: rtl;
    }
    .nestable .nestable-list {
      padding: 0 0 0 23px;
      margin: 0;
      list-style-type: none;
    }
    .nestable-rtl .nestable-list {
      padding: 0 40px 0 0;
    }
    .nestable > .nestable-list {
      padding: 0;
    }
    .nestable-item .nestable-list,
    .nestable-item-copy .nestable-list {
      margin: 10px 0 0 20px;
    }
    .nestable-drag-layer > .nestable-list {
      position: absolute;
      top: 0;
      left: 0;
      padding: 0;
      background-color: rgb(106 127 233 / 27.4%);
    }
    .nestable-item,
    .nestable-item-copy {
      margin: 10px 0 0;
    }
    .nestable-item {
      position: relative;
      .nestable-content {
        border-radius: var(--bs-border-radius) !important;
      }
    }
    .nestable-item:first-child,
    .nestable-item-copy:first-child {
      margin-top: 0;
    }
    .nestable-item.is-dragging .nestable-list {
      pointer-events: none;
    }
    .nestable-item.is-dragging * {
      opacity: 0;
    }
    .nestable-item.is-dragging::before {
      position: absolute;
      border: 1px dashed rgb(73 100 241);
      border-radius: 5px;
      background-color: rgb(106 127 233 / 27.4%);
      content: " ";
      inset: 0;
    }
    .nestable-drag-layer {
      position: fixed;
      z-index: 100;
      top: 0;
      left: 0;
      pointer-events: none;
    }
    .nestable-rtl .nestable-drag-layer {
      right: 0;
      left: auto;
    }
    .nestable-rtl .nestable-drag-layer > .nestable-list {
      padding: 0;
    }
    .nestable-handle {
      display: inline-block;
      width: 100%;
    }
  }
}
</style>
