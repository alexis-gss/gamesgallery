<template>
  <div :class="`belongs-to-many-dropdown belongs-to-many-dropdown-${intId} user-select-none`">
    <Transition name="fade">
      <div v-if="errorMessages.length">
        <span
          class="d-block text-danger"
          v-for="errorMessage of errorMessages"
          :key="errorMessage"
        >
          {{ errorMessage }}
        </span>
      </div>
    </Transition>
    <div class="d-inline-block w-100">
      <VueTagsInputCls
        v-model="intTag"
        :tags="intTags"
        :autocomplete-items="filteredItems"
        :autocomplete-min-length="0"
        @before-adding-tag="beforeTagSave"
        @tags-changed="changedTags"
        @click.prevent="getPublishedGamesInNotRanking"
        :max-tags="6"
        :placeholder="intPlaceholder ?? __('bo_other_taggable_add')"
      />
    </div>
    <template
      v-for="(sTag, index) in intTags"
      :key="index"
    >
      <p class="text-danger m-0">
        {{ parseValidationInput(`${intName}[${String(index)}][name]`, allErrors) }}
      </p>
      <input
        :name="`${intName}[${String(index)}][id]`"
        type="hidden"
        :value="sTag.id"
      >
      <input
        :name="`${intName}[${String(index)}][name]`"
        type="hidden"
        :value="sTag.text"
      >
    </template>
  </div>
</template>

<script lang="ts">
import type VueTagsInput from "@sipec/vue3-tags-input";
import { VueTagsInput as VueTagsInputCls } from "@sipec/vue3-tags-input";
import slugify from "slugify";
import { defineComponent } from "vue";
import error from "./../../modules/error";
import route from "./../../modules/route";
import trans from "./../../modules/trans";

export default defineComponent({
  name: "BelongsToManyDropdownComponent",
  mixins: [error, route, trans],
  components: {
    VueTagsInputCls,
  },
  props: {
    id: {
      type: String,
      default: null,
    },
    name: {
      type: String,
      default: null,
    },
    placeholder: {
      type: String,
      default: null,
    },
    value: {
      type: Array<CustomTag>,
      default: null,
    },
    items: {
      type: Array<CustomTag>,
      default: null,
    },
    ranking: {
      type: Boolean,
      default: false,
    },
  },
  data(): {
    intId: string;
    intName: string;
    intPlaceholder: string;
    intTag: string;
    intTags: CustomTag[];
    intRanking: boolean;
    intInput: HTMLInputElement | null;
    allItems: CustomTag[];
    allErrors: Record<string, string[]>;
    errorMessages: string[];
  } {
    return {
      intId: "",
      intName: "",
      intPlaceholder: "",
      intTag: "",
      intTags: [],
      intRanking: false,
      intInput: null,
      allItems: [],
      allErrors: {},
      errorMessages: [],
    };
  },
  mounted() {
    const json = String(this.$attrs.json ?? "{}"),
          data = JSON.parse(json);
    this.intId = this.id ?? data.id;
    this.intName = this.name ?? data.name;
    this.intPlaceholder = this.placeholder ?? data.placeholder;
    this.intTags = this.parseTags(this.value ?? data.value ?? []);
    this.allItems = this.parseTags(this.items ?? data.items ?? []);
    this.allErrors = data.errors;
    this.intRanking = this.ranking ?? data.ranking;
    if (this.intRanking) {
      this.$nextTick(() => {
        const component = document.querySelector(".taggable-" + this.intId);
        this.intInput = (component?.querySelector(".ti-new-tag-input") !== undefined) ? component?.querySelector(".ti-new-tag-input"): null;
      });
      this.getPublishedGamesInNotRanking();
    }
  },
  methods: {
    /** Toggle disable input. */
    toggleDisableInput() {
      if (this.intInput?.hasAttribute("disabled")) {
        this.intInput?.removeAttribute("disabled");
      } else {
        this.intInput?.setAttribute("disabled", "true");
      }
    },
    /** Get published games that aren't in ranking. */
    getPublishedGamesInNotRanking() {
      if (this.intRanking) {
        this.$nextTick(() => {
          this.toggleDisableInput();
        });
        const route = this.route("bo.ranks.games");
        if (!route) {
          throw new Error("Undefined route bo.ranks.games");
        }
        window.axios
          .get(route)
          .then((reponse) => {
            this.allItems = this.parseTags(reponse.data);
            this.toggleDisableInput();
          });
      }
    },
    parseTags(tags: CustomTag[]): CustomTag[] {
      return tags.map((tag: CustomTag) => {
        tag.text = String(tag.name);
        tag.slug = String(tag.slug);
        return tag;
      });
    },
    beforeTagSave(obj: VueTagsInput.IAddArgs): void {
      this.showErrorMessages([]);
      // * Tag exists in selected tags
      if (this.tagExists(this.intTags, obj.tag)) {
        this.showErrorMessages(["This tag already exist."]);
        return;
      }
      // * Tag exists in local list
      let customTag = this.tagExists(this.allItems, obj.tag);
      if (customTag) {
        obj.tag = customTag;
        this.intTags.push(customTag);
        this.intTag = "";
        return;
      }
    },
    changedTags(newTags: CustomTag[]): void {
      this.intTags = newTags as CustomTag[];
    },
    tagExists(
      items: CustomTag[],
      tagToCheck: VueTagsInput.ITag
    ): CustomTag | null {
      let customTag: CustomTag | null = null;
      items.filter((tag: CustomTag) => {
        if (
          tag.id === (tagToCheck as CustomTag).id ||
          tag.slug === slugify(tagToCheck.text)
        ) {
          customTag = tag;
        }
      });
      return customTag;
    },
    showErrorMessages(messages: Array<string>): void {
      this.errorMessages = messages;
    },
  },
  computed: {
    filteredItems() {
      return this.allItems.filter((i) => {
        return i.text.toLowerCase().indexOf(this.intTag.toLowerCase()) !== -1;
      });
    },
  },
});
</script>
