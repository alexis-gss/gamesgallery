<template>
  <div
    ref="colorPicker"
    :class="`input-group color-picker-component ${
      intRgbaMode ? '' : 'no-transparent'
    }`"
  >
    <div
      :id="`colorPickerFakeInput${intId}`"
      class="d-inline-block"
      ref="colorPickerFakeInput"
    >
      <div class="d-inline-block">
        <input
          :id="intId"
          type="color"
          class="form-control form-control-color"
          :value="intInternalHex"
          :aria-describedby="intAriaDescribedby"
          @click.prevent="togglePicker()"
        >
        <input
          :name="intName"
          type="text"
          class="d-none"
          :value="intValue"
        >
        <div
          :class="`color-picker position-absolute left-0 ${
            intDisplayPicker ? 'd-inline-block' : 'd-none'
          }`"
        >
          <Color-picker
            ref="picker"
            v-model="intInternalValue"
          />
        </div>
      </div>
      <div
        :class="`form-check form-switch m-0 ${
          intNullable ? 'd-inline-block' : 'd-none'
        }`"
      >
        <input
          ref="nullableInput"
          :id="`checkbox${intId}`"
          class="form-check-input me-1"
          type="checkbox"
          data-bs-tooltip="tooltip"
          :title="__('Rendre la couleur transparente ?')"
          :checked="intValue === null ? true : false"
          @change="updateValue"
          role="button"
        >
        <label
          class="form-check-label user-select-none"
          :for="`checkbox${intId}`"
          role="button"
        >
          {{ __("Transparent ?") }}
        </label>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Sketch } from "@ckpack/vue-color";
import { defineComponent, type PropType } from "vue";
import trans from "../../modules/trans";
import { Tooltips } from "./../../modules/tooltip";

export default defineComponent({
  name: "ColorPickerComponent",
  inheritAttrs: false,
  mixins: [trans],
  components: {
    "Color-picker": Sketch,
  },
  props: {
    id: {
      type: String as PropType<string | null>,
      default: null,
    },
    name: {
      type: String as PropType<string | undefined>,
      default: undefined,
    },
    value: {
      type: String as PropType<string | null>,
      default: null,
    },
    nullable: {
      type: Boolean as PropType<boolean | undefined>,
      default: undefined,
    },
    rgbaMode: {
      type: Boolean as PropType<boolean>,
      default: false,
    },
    ariaDescribedby: {
      type: String as PropType<string | undefined>,
      default: undefined,
    },
  },
  data(): {
    intId: string;
    intName: string;
    intValue: string | null;
    intNullable: boolean;
    intRgbaMode: boolean;
    intAriaDescribedby: string;
    intInternalValue:
      | string
      | { hex: string; rgba: { a: string; b: string; g: string; r: string } };
    intInternalHex: string;
    intDisplayPicker: boolean;
    intNullableInput: HTMLInputElement | null;
    intColorPickerFakeInput: HTMLElement | null;
    intPicker: typeof Sketch | null;
    tooltips: Tooltips | null;
  } {
    return {
      intId: "",
      intName: "",
      intValue: "",
      intNullable: false,
      intRgbaMode: false,
      intAriaDescribedby: "",
      intInternalValue: "",
      intInternalHex: "",
      intDisplayPicker: false,
      intNullableInput: null,
      intColorPickerFakeInput: null,
      intPicker: null,
      tooltips: null
    };
  },
  mounted() {
    this.intNullableInput = this.$refs.nullableInput as HTMLInputElement;
    this.intColorPickerFakeInput = this.$refs
      .colorPickerFakeInput as HTMLElement;
    this.intPicker = this.$refs.picker as typeof Sketch;

    const json = String(this.$attrs.json ?? "{}"),
          data = JSON.parse(json);
    this.intId = this.id ? this.id : data.id;
    this.intName = this.name ? this.name : data.name;
    this.intValue = this.value ? this.value : data.value;
    this.intAriaDescribedby = this.ariaDescribedby
      ? this.ariaDescribedby
      : data.ariaDescribedby;
    this.intNullable = this.nullable
      ? this.nullable
      : data.nullable
        ? true
        : false;
    this.intRgbaMode = this.rgbaMode
      ? this.rgbaMode
      : data.rgbaMode
        ? true
        : false;

    if (!this.intNullable) {
      this.intInternalValue = this.intValue
        ? this.intValue
        : this.intRgbaMode
          ? "rgba(0,0,0,0)"
          : "#000000";
    } else {
      this.intInternalValue = this.intValue ?? "";
    }
    this.$nextTick(() => {
      this.intInternalHex = this.intPicker?.$data.val.hex;
      this.tooltips = Tooltips.make({
        type: "dom",
        elements: (this.$refs.colorPicker as HTMLDivElement)
          .querySelectorAll("[data-bs-tooltip=\"tooltip\"]")
      });
    });
  },
  watch: {
    intInternalValue() {
      this.updateValue();
    },
  },
  methods: {
    updateValue() {
      if (this.intNullableInput?.checked) {
        this.hidePicker();
        this.intValue = "";
        this.intInternalHex = "";
        return;
      }
      this.$nextTick(() => {
        this.intInternalHex = this.intPicker?.$data.val.hex;
      });
      if (typeof this.intInternalValue === "string") {
        this.intValue = this.intInternalValue;
        return;
      }
      const isNull = this.intNullableInput?.checked ? true : false;
      if (this.intRgbaMode) {
        const rgba = this.intInternalValue?.rgba;
        this.intValue =
          !isNull && rgba
            ? `rgba(${rgba.r}, ${rgba.g}, ${rgba.b}, ${rgba.a})`
            : this.intNullable
              ? null
              : "";
        return;
      }
      this.intValue =
        !isNull && this.intInternalValue
          ? this.intInternalValue.hex
          : this.intNullable
            ? null
            : "";
    },
    showPicker() {
      document.addEventListener("click", this.documentClick);
      this.intDisplayPicker = true;
      const input = this.intNullableInput;
      if (!input) {
        throw new Error("input missing");
      }
      input.checked = false;
    },
    hidePicker() {
      document.removeEventListener("click", this.documentClick);
      this.intDisplayPicker = false;
    },
    togglePicker() {
      this.intDisplayPicker ? this.hidePicker() : this.showPicker();
    },
    documentClick(e: Event) {
      const colorpickerComponent = this.intColorPickerFakeInput,
            target = e.target;
      if (
        colorpickerComponent !== target &&
        colorpickerComponent &&
        (target as HTMLElement).closest(`#colorPickerFakeInput${this.intId}`)
          ?.id !== colorpickerComponent.id
      ) {
        this.hidePicker();
      }
    },
  },
});
</script>

<style lang="scss">
@import "bootstrap/scss/functions";
@import "bootstrap/scss/variables";
@import "bootstrap/scss/mixins";
.color-picker-component {
  position: relative;
  z-index: 2;
  .vc-sketch {
    background-color: var(--bs-tertiary-bg);
  }
  .vc-sketch-sliders, .vc-sketch-field {
    margin-top: 10px;
    padding: 0;
  }
  .vc-sketch-sliders {
    justify-content: center;
    align-items: center;
    display: flex;
    height: 16px;
  }
  .vc-sketch-hue-wrap {
    width: 100%;
  }
  .vc-sketch-alpha-wrap, .vc-sketch-presets-color:last-of-type, .vc-sketch-color-wrap, .vc-sketch-field--single {
    display: none;
  }
  .vc-sketch-color-wrap .vc-checkerboard {
    background-image: none !important;
  }
  .vc-sketch-active-color, .vc-sketch-saturation-wrap {
    border-radius: 3px;
  }
  .vc-sketch-hue-wrap, .vc-hue-pointer, .vc-hue-picker {
    height: 100%;
  }
  .vc-hue-picker {
    margin: 0;
  }
  .vc-saturation-circle {
    box-shadow: 0 0 0 1.2px #fff,inset 0 0 1px 1px rgba(0,0,0,.3),0 0 1px 2px rgba(0,0,0,.4)
  }
  .vc-editable-input {
    display: flex;
    flex-direction: row-reverse;
    align-items: center;
    justify-content: center;
  }
  .vc-input__label, .vc-input__input {
    font-size: 1rem !important;
  }
  .vc-input__label {
    color: var(--bs-body-color) !important;
  }
  .vc-input__input {
    padding: .375rem .75rem !important;
    margin-left: 0.5rem;
    color: var(--bs-body-color);
    background-color: var(--bs-body-bg);
    border: var(--bs-border-width) solid var(--bs-border-color) !important;
    border-radius: var(--bs-border-radius);
    box-shadow: none !important;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out !important;
  }
  .vc-input__input:focus {
    color: var(--bs-body-color);
    background-color: var(--bs-body-bg);
    border-color: #94a8be;
    outline: 0;
    box-shadow: 0 0 0 .25rem #29507c40 !important;
  }
  .vc-sketch-presets {
    border: none !important;
  }
}
</style>
