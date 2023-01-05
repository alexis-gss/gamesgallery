<template>
  <div class="d-flex flex-row justify-content-around align-items-center w-100">
    <span>
      {{ __("form.word_counter_words") }}
      &nbsp;:&nbsp;
      <b>{{ intWords }}</b>
    </span>
    <span>
      {{ __("form.word_counter_characters") }}
      &nbsp;:&nbsp;
      <b>{{ intChars }}</b>
    </span>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import trans from "../../modules/trans";

export default defineComponent({
  mixins: [trans],
  mounted() {
    const json = String(this.$attrs.json ?? "{}");
    const data = JSON.parse(json);
    this.intId = String(this.id);
    if (data.id) {
      this.intId = data.id;
    }
  },
  props: {
    id: {
      type: String,
      default: null,
    },
  },
  data(): {
    intId: string;
    intWords: number;
    intChars: number;
    intInput: HTMLInputElement | HTMLTextAreaElement | null;
  } {
    return {
      intId: "",
      intWords: 0,
      intChars: 0,
      intInput: null,
    };
  },
  watch: {
    id() {
      this.intId = this.id;
    },
    intId() {
      if (!this.intId) {
        return;
      }
      this.$nextTick(() => {
        const input = document.getElementById(this.intId);
        if (
          !input ||
          !(
            input instanceof HTMLInputElement ||
            input instanceof HTMLTextAreaElement
          )
        ) {
          throw new Error(`${this.intId} is not a input or textarea`);
        }
        this.intInput = input;
      });
    },
    intInput() {
      if (
        !this.intInput ||
        !(
          this.intInput instanceof HTMLInputElement ||
          this.intInput instanceof HTMLTextAreaElement
        )
      ) {
        throw new Error(`${this.intId} is not a input or textarea`);
      }
      this.intInput.addEventListener("input", (e) => {
        const el = e.target;
        if (
          !el ||
          !(el instanceof HTMLInputElement || el instanceof HTMLTextAreaElement)
        ) {
          throw new Error(`${this.intId} is not a input or textarea`);
        }
        this.updateValues(el.value);
      });
      this.updateValues(this.intInput.value);
    },
  },
  methods: {
    updateValues(string: string) {
      let chars, words;
      [words, chars] = this.calculateValues(string);
      this.intWords = words;
      this.intChars = chars;
    },
    calculateValues(string: string) {
      const arr = string.split(" ");
      return [arr.filter((word) => word !== "").length, string.length];
    },
  },
});
</script>
