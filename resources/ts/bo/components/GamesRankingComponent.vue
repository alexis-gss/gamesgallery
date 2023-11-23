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
              {{ item.name }}
            </p>
          </div>
          <div
            class="d-flex justify-content-end align-items-center"
          >
            <div class="input-group">
              <a
                :href="getShowGameRoute(item.slug)"
                class="btn btn-sm btn-warning"
                target="_blank"
                :title="__('Voir le jeu')"
                data-bs="tooltip"
              >
                <FontAwesomeIcon icon="fa-solid fa-eye" />
              </a>
              <a
                :href="getEditGameRoute(item.game_id)"
                class="btn btn-sm btn-primary"
                :title="__('Modifier le jeu')"
                data-bs="tooltip"
              >
                <FontAwesomeIcon icon="fa-solid fa-pencil" />
              </a>
            </div>
            <button
              @click="deleteRank($event, item as never as RankObject)"
              class="btn btn-sm btn-danger confirmDelete ms-1"
              :title="__('Supprimer le jeu')"
              data-bs="tooltip"
              ref="confirmDelete"
            >
              <FontAwesomeIcon icon="fa-solid fa-xmark" />
            </button>
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
          {{ __("form.image_input_viewer_loading") }}
        </span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { Tooltip } from "bootstrap";
import { defineComponent } from "vue";
import { VueNestable, VueNestableHandle } from "vue3-nestable";
import route from "./../../modules/route";
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
  mixins: [route, trans, sweetalert, error],
  data(): {
    intCsrf: string | null | undefined;
    intId: String;
    intRanks: RankObject[];
    intGames: LaravelModel[];
    intMessage: object | object[] | null;
    intLoading: boolean;
    intTooltipList: HTMLButtonElement[];
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
      intTooltipList: [],
    };
  },
  mounted() {
    const json = String(this.$attrs.json ?? "{}");
    const data = JSON.parse(json);
    this.intId = data.id;
    this.intRanks = data.rankModels;
    this.$nextTick(() => {
      this.updateBootstrapTooltip();
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
        this.updateBootstrapTooltip();
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
                    this.updateBootstrapTooltip();
                  });
                }, 6000);
              }
              this.intLoading = false;
              this.$nextTick(() => {
                this.updateBootstrapTooltip();
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
    },
    /** Update Bootstrap tooltips. */
    updateBootstrapTooltip() {
      let newTooltipList = [].slice.call(
        document.querySelectorAll(
          ".ranks-" + this.intId + " [data-bs=\"tooltip\"]"
        )
      ) as HTMLButtonElement[];
      let tmp = newTooltipList.filter((x) => !this.intTooltipList.includes(x));
      tmp.map((tooltip) => {
        return new Tooltip(tooltip);
      });
      this.closeBootstrapTooltip();
      this.intTooltipList = newTooltipList;
    },
    /** Close all Bootstrap tooltips. */
    closeBootstrapTooltip() {
      this.intTooltipList.forEach((tooltip) => {
        tooltip.blur();
        Tooltip.getInstance(tooltip)?.hide();
      });
    },
  },
});
</script>
