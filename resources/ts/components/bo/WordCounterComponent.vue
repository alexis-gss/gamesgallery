<template>
  <div
    class="wordCounter d-flex flex-row justify-content-around align-items-center w-100"
  >
    <span class="words">
      {{ "Mots" }}
      &nbsp;:&nbsp;
      <b>{{ intWords }}</b>
    </span>
    <span class="chars">
      {{ "Caractères" }}
      &nbsp;:&nbsp;
      <b>{{ intChars }}</b>
    </span>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
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

<style lang="scss">
.wordCounter {
  border-top-left-radius: 0.375rem;
  border-top-right-radius: 0.375rem;
  color: initial;
  border: 1px solid rgb(196, 196, 196);
  border-bottom: 0;
  background-color: #fafafa;
}
</style>
