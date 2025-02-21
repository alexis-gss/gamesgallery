<template>
  <p
    v-if="loading"
    class="button-details placeholder-glow m-0"
  >
    <span class="placeholder w-100 rounded-2" />
  </p>
  <a
    v-else
    :href="`${env.VITE_ADATA_URL}/${gameId}`"
    target="_blank"
    class="btn btn-primary text-decoration-none text-white border-0 rounded-2 px-2 py-0"
  >
    {{ trans.methods.__('fo_images_details') }}
    <FontAwesomeIcon
      icon="fa-solid fa-arrow-up-right-from-square"
      size="xs"
      class="ms-1"
    />
  </a>
</template>

<script lang="ts" setup>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { defineOptions, onMounted, ref, useAttrs } from "vue";
import type { AxiosResponse } from "~/axios";
import trans from "./../../modules/trans";
import errors from "./../../modules/errors";

defineOptions({
  name: "GameDetailsComponent"
});

// * ATTRIBUTES
const attrs = useAttrs();

// * DATA
const search = ref<string>("");
const gameId = ref<number>(0);
const loading = ref<boolean>(true);
const env = import.meta.env;

// * LIFECYCLE
onMounted((): void => {
  const json = String(attrs.json ?? "{}"),
        data = JSON.parse(json);
  search.value = data.search;
  useRawgSearch();
});

// * METHODS
async function useRawgSearch() {
  loading.value = true;
  window.axios
    .get(`${env.VITE_DETAILS_URL}`, {
      params: {
        key: env.VITE_DETAILS_KEY,
        search: `${search.value.toLowerCase()}`,
        ordering: "-popularity",
        page_size: 5
      }
    })
    .then((response: AxiosResponse<any, any>) => {
      gameId.value = response.data.results[0].id;
    })
    .finally(() => {
      loading.value = false;
    })
    .catch(errors.methods.ajaxErrorHandler);

}
</script>

<style lang="scss" scopped>
.button-details {
  width: 10rem;

  &, .placeholder {
    height: 24px;
  }
}
</style>
