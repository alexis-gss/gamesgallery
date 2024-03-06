<template>
  <button
    ref="passwordVisibility"
    @click.prevent="toggleVisibility()"
    @keydown="keydown"
    :class="`btn btn-primary rounded-0 password-visibility-${inputId} h-100`"
    :aria-pressed="visible"
  >
    <span
      :class="{
        'text-bg-primary reveal d-flex justify-content-center align-items-center h-100': true,
        'd-none': visible
      }"
      type="button"
      :title="__('bo_tooltip_password_show')"
      data-bs-toggle="tooltip"
    >
      <FontAwesomeIcon
        icon="fas fa-eye-slash"
        :aria-hidden="true"
      />
    </span>
    <span
      ref="passwordVisibilitySpan"
      :class="{
        'text-bg-primary reveal d-flex justify-content-center align-items-center h-100': true,
        'd-none': !visible
      }"
      type="button"
      :title="__('bo_tooltip_password_hide')"
      data-bs-toggle="tooltip"
    >
      <FontAwesomeIcon
        icon="fas fa-eye"
        :aria-hidden="true"
      />
    </span>
  </button>
</template>

<script lang="ts">
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { defineComponent } from "vue";
import { Tooltips } from "./../../modules/tooltip";
import trans from "./../../modules/trans";

export default defineComponent({
  name: "PasswordVisibility",
  mixins: [trans],
  components: { FontAwesomeIcon },
  data(): {
    inputId: string;
    input: HTMLInputElement;
    visible: boolean;
    tooltips: Tooltips|null;
  } {
    return {
      inputId: "",
      input: document.createElement("input"),
      visible: false,
      tooltips: null,
    };
  },
  computed: {},
  mounted() {
    const json = String(this.$attrs.json ?? "{}"),
          data = JSON.parse(json);
    this.inputId = data.inputId;
    this.input = document.getElementById(this.inputId) as HTMLInputElement;
    if (!this.input) {
      throw new Error(`Cannot find input id '${this.inputId}'`);
    }
    if (this.input.tagName !== "INPUT") {
      throw new Error(`id '${this.inputId}' is not an input`);
    }
    if ((this.input as HTMLInputElement).type !== "password") {
      throw new Error(`id '${this.inputId}' is not an input password`);
    }
    this.input = this.input as HTMLInputElement;
    this.$nextTick(() => {
      this.tooltips = Tooltips.make({
        type: "dom",
        elements: (this.$refs.passwordVisibility as HTMLDivElement).querySelectorAll("[data-bs-toggle=\"tooltip\"]")
      });
    });
  },
  methods: {
    keydown(e:KeyboardEvent):void {
      if (
        e.key === " " ||
        e.code === "Space" ||
        e.keyCode === 32 ||
        e.key === "Enter" ||
        e.code === "Enter" ||
        e.keyCode === 13
      ) {
        this.toggleVisibility();
        e.preventDefault();
      }
    },
    /**
     * Update password status (visible, hidden).
     */
    toggleVisibility(): void {
      if (this.input.type === "password") {
        this.input.type = "text";
        this.visible = true;
      } else {
        this.input.type = "password";
        this.visible = false;
      }
    },
  },
});
</script>

<style lang="scss">
.password-visibility {
  .btn-primary {
    border-bottom-right-radius: var(--bs-border-radius) !important;
  }
  .reveal {
    width: 52px;
  }
}
</style>
