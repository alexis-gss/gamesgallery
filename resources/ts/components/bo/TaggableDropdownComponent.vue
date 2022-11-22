<template>
  <div class="taggableDropdown user-select-none">
    <div v-if="errorMessages.length">
      <span
        class="d-block text-danger"
        v-for="errorMessage of errorMessages"
        :key="errorMessage"
      >
        {{ errorMessage }}
      </span>
    </div>
    <div class="d-inline-block w-100">
      <VueTagsInputCls
        v-model="tag"
        :tags="tags"
        :autocomplete-items="filteredItems"
        :autocomplete-min-length="0"
        @before-adding-tag="beforeTagSave"
        @tags-changed="changedTags"
        :max-tags="6"
        placeholder="Add a tag"
      />
      <div
        class="text-center py-2"
        v-if="waitingListObjects.length"
      >
        <button
          class="btn btn-sm btn-primary ms-2"
          @click.prevent="addTags"
        >
          Créer et ajouter à la liste
        </button>
        <button
          class="btn btn-sm btn-danger ms-2"
          @click.prevent="cancelTags"
        >
          Annuler
        </button>
      </div>
    </div>
    <template
      v-for="(sTag, index) in tags"
      :key="index"
    >
      <input
        :name="`${name}[${String(index)}][id]`"
        type="hidden"
        :value="sTag.id"
      >
      <input
        :name="`${name}[${String(index)}][name]`"
        type="hidden"
        :value="sTag.text"
      >
    </template>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import type VueTagsInput from "@sipec/vue3-tags-input";
import { VueTagsInput as VueTagsInputCls } from "@sipec/vue3-tags-input";
import slugify from "slugify";
import route from "../../modules/route";

export default defineComponent({
  mixins: [route],
  components: {
    VueTagsInputCls,
  },
  beforeMount() {
    if (!this.$attrs.json) {
      throw new Error("this component requires json");
    }
  },
  mounted() {
    const json = String(this.$attrs.json ?? "{}"),
          data = JSON.parse(json);
    this.name = data.name;
    this.tags = this.parseTags(data.value);
    this.autocompleteItems = this.parseTags(data.tags);
  },
  data(): {
    name: string;
    tag: string;
    tags: Array<CustomTag>;
    autocompleteItems: Array<CustomTag>;
    waitingListObjects: Array<VueTagsInput.IAddArgs>;
    errorMessages: Array<string>;
  } {
    return {
      name: "",
      tag: "",
      tags: [],
      autocompleteItems: [],
      waitingListObjects: [],
      errorMessages: [],
    };
  },
  methods: {
    parseTags(tags: Array<CustomTag>): Array<CustomTag> {
      return tags.map((tag: CustomTag) => {
        tag.text = String(tag.name);
        tag.slug = String(tag.slug);
        return tag;
      });
    },
    addTags(): void {
      for (const obj of this.waitingListObjects) {
        this.ajaxSaveTag(obj);
      }
    },
    cancelTags(): void {
      this.$nextTick(() => {
        this.waitingListObjects = [];
        this.tag = "";
        this.showErrorMessages([]);
      });
    },
    beforeTagSave(obj: VueTagsInput.IAddArgs): void {
      this.waitingListObjects = [];
      this.showErrorMessages([]);
      // * Tag exists in selected tags
      if (this.tagExists(this.tags, obj.tag)) {
        this.showErrorMessages(["Cette étiquette est déjà dans la liste."]);
        return;
      }
      // * Tag exists in local list
      let customTag = this.tagExists(this.autocompleteItems, obj.tag);
      if (customTag) {
        obj.tag = customTag;
        this.tags.push(customTag);
        this.tag = "";
        return;
      }
      // * Add tag in waiting list
      this.waitingListObjects.push(obj);
    },
    ajaxSaveTag(obj: VueTagsInput.IAddArgs): void {
      const self = this;
      const storeTagRoute = route.methods.route("bo.tags.jsonStore");
      if (!storeTagRoute) {
        throw new Error("Undefined route bo.tags.jsonStore");
      }
      window.axios
        .post(storeTagRoute, { name: self.tag })
        .then((reponse) => {
          const parsedTag = self.parseTags([reponse.data])[0] as CustomTag,
                tag = obj.tag as CustomTag;
          self.autocompleteItems.push(parsedTag);
          tag.id = parsedTag.id;
          tag.slug = parsedTag.slug;
          obj.tag = tag;
          this.tags.push(tag);
        })
        .catch((error) => {
          let message = "Une erreur est survenue merci de ressayer plus tard";
          if (error.response.status === 422) {
            message =
              error.response?.data?.errors?.name?.[0] ||
              error.response?.data?.errors?.slug?.[0] ||
              message;
            this.showErrorMessages([message]);
            return;
          }
          if (error.response) {
            console.error(error.response.data);
          } else if (error.request) {
            console.error(error.request);
          } else {
            // Something happened in setting up the request that triggered an Error
            console.error("Error", error.message);
          }
        })
        .then(() => {
          this.waitingListObjects = [];
          this.tag = "";
        });
    },
    beforeTagDelete(obj: VueTagsInput.IDeleteArgs): void {
      const self = this;
      if (obj.tag) {
        const destroyTagRoute = route.methods.route("bo.tags.destroy");
        if (!destroyTagRoute) {
          throw new Error("Undefined route bo.tags.destroy");
        }
        window.axios
          .post(
            destroyTagRoute.replace("ID", String((obj.tag as CustomTag).id))
          )
          .then(() => obj.deleteTag())
          .catch((e) => {
            console.error(e);
            self.tag = "";
          });
      }
    },
    changedTags(newTags: Array<CustomTag>): void {
      this.tags = newTags as Array<CustomTag>;
    },
    tagExists(
      items: Array<CustomTag>,
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
      return this.autocompleteItems.filter((i) => {
        return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
      });
    },
  },
});
</script>
