<template>
  <div
    :class="`color-picker-component color-picker-component-${intId} ${
      intRgbaMode ? '' : 'no-transparent'
    } input-group`"
    ref="colorpicker"
  >
    <div
      :id="`colorPickerFakeInput${intId}`"
      :class="`d-inline-block ${intSimple ? 'mx-auto' : ''}`"
      ref="colorPickerFakeInput"
    >
      <div class="d-inline-block">
        <b v-if="!intSimple">
          <label
            v-if="intLabel.length"
            :for="intId ? intId : ''"
            class="col-form-label"
          >
            {{ intLabel }}
            <span
              data-bs-tooltip="tooltip"
              data-bs-placement="top"
              :title="intTitle"
            >
              <i class="fa-solid fa-circle-info" />
            </span>
          </label>
        </b>
        <input
          :id="intId"
          type="color"
          class="form-control form-control-color"
          :value="intInternalHex"
          :title="
            intSimple ? __('form.tooltip_color_picker') + intInternalHex : ''
          "
          data-bs-tooltip="tooltip"
          :aria-describedby="intAriaDescribedby"
          @click.prevent="togglePicker()"
          :disabled="intDisabled ? true : false"
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
          <chrome-picker
            ref="picker"
            v-model="intInternalValue"
          />
        </div>
        <small
          v-if="!intSimple"
          class="form-text text-muted"
        >
          {{ intHelper }}
        </small>
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
          :title="__('Make the color transparent ?')"
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
import { defineComponent, PropType } from "vue";
// @ts-ignore
import { Chrome } from "@ckpack/vue-color";
import trans from "./../../modules/trans";
import Tooltip from "bootstrap/js/dist/tooltip";

export default defineComponent({
  inheritAttrs: false,
  mixins: [trans],
  components: {
    "chrome-picker": Chrome,
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
    title: {
      type: String as PropType<string | undefined>,
      default: undefined,
    },
    label: {
      type: String as PropType<string | undefined>,
      default: undefined,
    },
    helper: {
      type: String as PropType<string | undefined>,
      default: undefined,
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
    simple: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  data(): {
    intId: string;
    intName: string;
    intValue: string | null;
    intTitle: string;
    intLabel: string;
    intHelper: string;
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
    intSimple: boolean;
    intDisabled: boolean;
    intTooltipList: HTMLButtonElement[];
  } {
    return {
      intId: "",
      intName: "",
      intValue: "",
      intTitle: "",
      intLabel: "",
      intHelper: "",
      intNullable: false,
      intRgbaMode: false,
      intAriaDescribedby: "",
      intInternalValue: "",
      intInternalHex: "",
      intDisplayPicker: false,
      intNullableInput: null,
      intColorPickerFakeInput: null,
      intPicker: null,
      intSimple: false,
      intDisabled: false,
      intTooltipList: [],
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
    this.intTitle = this.title ? this.title : data.title;
    this.intLabel = this.label ? this.label : data.label;
    this.intHelper = this.helper ? this.helper : data.helper;
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
    this.intSimple = this.simple ? this.simple : data.simple;
    this.intDisabled = this.disabled ? this.disabled : data.disabled;

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
      this.updateBootstrapTooltip();
    });
  },
  watch: {
    intInternalValue() {
      this.updateValue();
    },
  },
  methods: {
    /**
     * Update Bootstrap tooltips.
     */
    updateBootstrapTooltip() {
      let newTooltipList = [].slice.call(
        document.querySelectorAll(
          ".color-picker-component-" +
            this.intId +
            " [data-bs-tooltip=\"tooltip\"]"
        )
      ) as HTMLButtonElement[];
      let tmp = newTooltipList.filter((x) => !this.intTooltipList.includes(x));
      tmp.map((tooltip) => {
        return new Tooltip(tooltip);
      });
      this.intTooltipList = newTooltipList;
      this.closeBootstrapTooltip();
    },
    /**
     * Close all Bootstrap tooltips.
     */
    closeBootstrapTooltip() {
      this.intTooltipList.forEach((tooltip) => {
        tooltip.blur();
        Tooltip.getInstance(tooltip)?.hide();
      });
    },
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
