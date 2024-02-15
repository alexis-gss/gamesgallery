<template>
  <div
    :class="`input-group color-picker-component ${
      intRgbaMode ? '' : 'no-transparent'
    }`"
    ref="colorpicker"
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
          :class="`chrome-picker position-absolute left-0 ${
            intDisplayPicker ? 'd-inline-block' : 'd-none'
          }`"
        >
          <Chrome-picker
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
          data-bs-toggle="tooltip"
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
import { defineComponent, type PropType } from "vue";
// @ts-ignore
import { Chrome } from "@ckpack/vue-color";
import Tooltip from "bootstrap/js/dist/tooltip";
import trans from "../../modules/trans";

export default defineComponent({
  name: "ColorPickerComponent",
  inheritAttrs: false,
  mixins: [trans],
  components: {
    "Chrome-picker": Chrome,
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
    intPicker: typeof Chrome | null;
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
    };
  },
  mounted() {
    this.intNullableInput = this.$refs.nullableInput as HTMLInputElement;
    this.intColorPickerFakeInput = this.$refs
      .colorPickerFakeInput as HTMLElement;
    this.intPicker = this.$refs.picker as typeof Chrome;

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
      this.initTooltips();
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
    initTooltips() {
      // * INIT Bootstrap tooltips
      let tooltipTriggerList = [].slice.call(
        document.querySelectorAll(
          ".color-picker-component [data-bs-toggle=\"tooltip\"]"
        )
      );
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new Tooltip(tooltipTriggerEl, {
          delay: { show: 1000, hide: 300 },
        });
      });
    },
  },
});
</script>

<style lang="scss">
.color-picker-component {
  position: relative;
  .chrome-picker {
    z-index: 9;
  }
  .vc-chrome-alpha-wrap {
    display: none;
  }
  .vc-chrome-body {
    background-color: var(--bs-body-bg);
  }
  .vc-chrome-fields .vc-input__input {
    color: var(--bs-body-color);
  }
}
</style>
