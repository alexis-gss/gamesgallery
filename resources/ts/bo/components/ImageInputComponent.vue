<template>
  <div
    ref="imageInput"
    class="container image-input-vue p-0"
  >
    <div class="row">
      <div :class="`col-12 ${intPreview ? 'col-md-6' : ''} form-group`">
        <label
          v-if="intPreview && showLabels"
          :for="intId"
          class="col-form-label"
        >
          {{ __("bo_label_choose_picture") }}
          <span
            :title="__('bo_tooltip_image_input_choose_file')"
            data-bs-tooltip="tooltip"
          >
            <i class="fa-solid fa-circle-info" />
          </span>
        </label>
        <div class="input-group">
          <button
            @click.prevent="chooseAFile"
            class="btn btn-outline-secondary"
            type="button"
            :title="__('bo_tooltip_image_input_modify_source')"
            data-bs-tooltip="tooltip"
          >
            <FontAwesomeIcon icon="fa-solid fa-folder-open" />
          </button>
          <input
            :id="intId"
            ref="actualImage"
            @change="changedImage"
            type="file"
            class="d-none"
            :name="intName"
            accept=".jpg,.jpeg,.gif,.png"
            :aria-describedby="`Help${intId}`"
          >
          <input
            v-if="intValue.indexOf('data:image/png;base64') !== 0"
            class="d-none"
            :name="intName"
            type="text"
            :value="submitIntValue"
          >
          <input
            @click.prevent="chooseAFile"
            type="text"
            :value="intValueFileName"
            class="form-control right-aligned"
            :title="__('bo_tooltip_image_input_modify_source')"
            data-bs-tooltip="tooltip"
            :aria-describedby="`Help${intId}`"
            role="button"
            readonly
          >
          <button
            v-if="!intRequired && intHasImage"
            @click.prevent="removeFile"
            class="btn btn-outline-danger"
            type="button"
            data-bs-tooltip="tooltip"
            :title="__('bo_tooltip_image_input_remove_picture')"
          >
            <FontAwesomeIcon icon="fa-solid fa-eraser" />
          </button>
          <button
            v-if="!intPreview && intValue"
            class="btn btn-warning"
            type="button"
            data-bs-toggle="modal"
            :data-bs-target="`#ModalPreview${intId}`"
          >
            <span
              data-bs-tooltip="tooltip"
              :title="__('vue.ImageInputComponent.view_source_picture')"
            >
              <FontAwesomeIcon icon="fa-solid fa-eye" />
            </span>
          </button>
          <button
            @click.prevent="prepareImageEditor($event)"
            :disabled="!intHasImage"
            :class="`btn ${!intHasModdedImage ? 'btn-primary' : 'btn-success'}`"
            type="button"
            :title="__('bo_tooltip_image_input_resize_image')"
            data-bs-tooltip="tooltip"
            data-bs-toggle="modal"
            :data-bs-target="`#Modal${intId}`"
          >
            <FontAwesomeIcon icon="fa-solid fa-crop" />
          </button>
          <span
            v-if="intHasModdedImage"
            class="input-group-text text-success"
            :title="__('bo_tooltip_image_input_image_resized')"
            data-bs-tooltip="tooltip"
          >
            <FontAwesomeIcon icon="fa-solid fa-wand-magic" />
          </span>
        </div>
        <small
          :id="`Help${intId}`"
          class="form-text text-body-secondary"
        >
          {{ intHelper }}
        </small>
      </div>
      <div
        v-if="intPreview"
        :class="`col-12 ${intPreview ? 'col-md-6' : ''} form-group d-flex flex-column`"
      >
        <label
          v-if="intValue && showLabels"
          :id="`PreviewHelp${intId}`"
          class="col-form-label fw-bold m-0"
        >
          {{ __("bo_label_preview_image") }}
          <span
            :title="__('bo_tooltip_image_input_preview_image')"
            data-bs-tooltip="tooltip"
          >
            <FontAwesomeIcon icon="fa-solid fa-circle-info" />
          </span>
        </label>
        <img
          v-if="intValue"
          class="img-fluid w-fit"
          :src="intValue"
          :alt="__('bo_other_preview_image_placeholder')"
          :aria-describedby="`PreviewHelp${intId}`"
        >
        <small
          v-if="intOriginalFile"
          class="form-text text-body-secondary"
        >
          {{ humanFileSize(intOriginalFile.size) }}
          {{ `hauteur ${intOriginalFileDimensions.height}px` }}
          {{ `largeur ${intOriginalFileDimensions.width}px` }}
        </small>
      </div>
    </div>
    <div
      :id="`Modal${intId}`"
      class="modal"
      tabindex="-1"
      role="dialog"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      @mousedown="preventMouseDown"
      @dragstart.prevent="() => false"
      @ondrop.prevent="() => false"
      @dragover.prevent="() => false"
    >
      <div
        class="modal-dialog modal-xl"
        role="document"
      >
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">
              {{ __("bo_title_edit_image_before_import") }}
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              :title="__('bo_tooltip_image_input_close_without_saving')"
              data-bs-tooltip="tooltip"
            />
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="row">
                <div class="col text-center">
                  <div class="btn-group me-4 mt-2">
                    <button
                      class="btn btn-warning"
                      :title="__('bo_tooltip_image_input_reset_image')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="reset()"
                    >
                      <FontAwesomeIcon icon="fa-solid fa-sync-alt" />
                    </button>
                  </div>
                  <div class="btn-group me-4 mt-2">
                    <button
                      class="btn btn-primary"
                      :title="__('bo_tooltip_image_input_zoom_in')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="zoom(0.1)"
                    >
                      <FontAwesomeIcon icon="fa-solid fa-search-plus" />
                    </button>
                    <a
                      class="btn btn-primary"
                      :title="__('bo_tooltip_image_input_zoom_out')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="zoom(-0.1)"
                    >
                      <FontAwesomeIcon icon="fa-solid fa-search-minus" />
                    </a>
                  </div>
                  <div class="btn-group me-4 mt-2">
                    <a
                      class="btn btn-primary"
                      :title="__('bo_tooltip_image_input_move_left')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="move(-10, 0)"
                    >
                      <FontAwesomeIcon icon="fa-solid fa-arrow-left" />
                    </a>
                    <a
                      class="btn btn-primary"
                      :title="__('bo_tooltip_image_input_move_right')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="move(10, 0)"
                    >
                      <FontAwesomeIcon icon="fa-solid fa-arrow-right" />
                    </a>
                    <a
                      class="btn btn-primary"
                      :title="__('bo_tooltip_image_input_move_up')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="move(0, -10)"
                    >
                      <FontAwesomeIcon icon="fa-solid fa-arrow-up" />
                    </a>
                    <a
                      class="btn btn-primary"
                      :title="__('bo_tooltip_image_input_move_down')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="move(0, 10)"
                    >
                      <FontAwesomeIcon icon="fa-solid fa-arrow-down" />
                    </a>
                  </div>
                  <div class="btn-group me-4 mt-2">
                    <a
                      class="btn btn-primary"
                      :title="__('bo_tooltip_image_input_mirror_horizontal')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="scale(true)"
                    >
                      <FontAwesomeIcon icon="fa-solid fa-arrows-alt-h" />
                    </a>
                    <a
                      class="btn btn-primary"
                      :title="__('bo_tooltip_image_mirror_vertical')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="scale(false)"
                    >
                      <FontAwesomeIcon icon="fa-solid fa-arrows-alt-v" />
                    </a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group d-flex flex-row">
                    <div class="rotate-button">
                      <div class="btn-group mt-1">
                        <a
                          class="btn btn-primary"
                          :title="__('bo_tooltip_image_input_counterclockwise')"
                          data-bs-tooltip="tooltip"
                          @click.prevent="rotate(-45)"
                        >
                          <FontAwesomeIcon icon="fa-solid fa-undo-alt" />
                        </a>
                        <a
                          class="btn btn-primary"
                          :title="__('bo_tooltip_image_input_clockwise')"
                          data-bs-tooltip="tooltip"
                          @click.prevent="rotate(45)"
                        >
                          <FontAwesomeIcon icon="fa-solid fa-redo-alt" />
                        </a>
                      </div>
                    </div>
                    <div class="mt-1 ms-4 rotate-drag">
                      <label
                        for="range"
                        class="form-label me-4"
                      >
                        {{
                          __("bo_other_preview_rotation_degrees", {
                            deg: String(intRotationText),
                          })
                        }}
                      </label>
                      <input
                        ref="rotationSlider"
                        @input.stop="rotationChange"
                        @change.stop="
                          rotateTo(
                            Number.parseInt(
                              ($event.target as HTMLInputElement).value
                            )
                          )
                        "
                        type="range"
                        class="form-range"
                        id="range"
                        min="0"
                        max="360"
                        value="0"
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-12 col-md-6 p-0 mb-3">
                  <img
                    class="image-modification"
                    ref="imgEditor"
                    src=""
                  >
                </div>
                <div
                  ref="previewBox"
                  class="col-12 col-md-6 p-0 preview-img"
                >
                  <div
                    :id="`Preview${intId}`"
                    :style="intPreviewStyle"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
              data-bs-tooltip="tooltip"
              :title="__('bo_tooltip_image_input_modal_close_without_saving')"
            >
              {{ __("bo_other_close") }}
            </button>
            <button
              @click.prevent="exportCropperFile"
              type="button"
              class="btn btn-primary"
              data-bs-dismiss="modal"
              :title="__('bo_tooltip_image_input_modal_close_with_saving')"
              data-bs-tooltip="tooltip"
            >
              {{ __("crud.actions.save")[0].toUpperCase() + __("crud.actions.save").slice(1) }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import Cropper from "cropperjs";
import { defineComponent } from "vue";
import { Tooltips } from "./../../modules/tooltip";
import trans from "./../../modules/trans";

const UNITS = [
  "byte",
  "kilobyte",
  "megabyte",
  "gigabyte",
  "terabyte",
  "petabyte",
];
const BYTES_PER_KB = 1024;

export default defineComponent({
  name: "ImageInputComponent",
  components: {
    FontAwesomeIcon,
  },
  mixins: [trans],
  emits: {
    browseFile: (intId: string) => {
      intId;
      return true;
    },
    imageFile: (file: File | null) => {
      file;
      return true;
    },
  },
  props: {
    id: {
      type: String,
      default: String(Math.pow(10, 16) / Math.random()),
    },
    required: {
      type: Boolean,
      default: false,
    },
    showLabels: {
      type: Boolean,
      default: true,
    },
    name: {
      type: String,
      default: "",
    },
    helper: {
      type: String,
      default: "",
    },
    width: {
      type: Number,
      default: 0,
    },
    height: {
      type: Number,
      default: 0,
    },
    value: {
      type: String,
      default: "",
    },
    preview: {
      type: Boolean,
      default: true,
    },
    browseEvent: {
      type: Boolean,
      default: false,
    },
  },
  data(): {
    intId: string;
    intValue: string;
    intValueFileName: string;
    intHelper: string;
    intName: string;
    intRequired: boolean;
    intWidth: number;
    intHeight: number;
    intPreview: boolean;

    intBrowseEvent: boolean;

    intRotationText: number;
    intRotationValue: number;
    intScaleX: number;
    intScaleY: number;
    intHasImage: boolean;
    intHasModdedImage: boolean;
    intCropper: Cropper | null;

    intOriginalFile: File | null;
    intOriginalFileDimensions: {
      height: number;
      width: number;
    };
    intOriginalFileName: string;
    intPreviewStyle: string;
    tooltips: Tooltips | null;
  } {
    return {
      intId: "",
      intValue: "",
      intValueFileName: this.__("bo_tooltip_image_input_placeholder"),
      intHelper: "",
      intName: "",
      intRequired: true,
      intWidth: 0,
      intHeight: 0,
      intPreview: true,

      intBrowseEvent: false,

      intRotationText: 0,
      intRotationValue: 0,
      intScaleX: 1,
      intScaleY: 1,
      intHasImage: false,
      intHasModdedImage: false,
      intCropper: null,

      intOriginalFile: null,
      intOriginalFileDimensions: {
        height: 0,
        width: 0,
      },
      intOriginalFileName: "",
      intPreviewStyle: "",
      tooltips: null
    };
  },
  mounted() {
    const json = String(this.$attrs.json ?? "");
    if (json.length) {
      // * Init uppon Laravel Blade
      const data = JSON.parse(json);
      this.intId = data.id;
      this.intName = data.name;
      this.intHelper = data.helper ?? "";
      this.intWidth = Number.parseInt(String(data.width));
      this.intHeight = Number.parseInt(String(data.height));
      this.intValue = String(data.value);
      if (this.intValue.length) {
        this.intValueFileName = this.intValue.replace(/^\/|^/, "");
        this.intValue = this.intValue.replace(/^\/|^/, "/");
      }
      if (data.preview !== undefined) {
        this.intPreview = data.preview ? true : false;
      }
      if (data.required !== undefined) {
        this.intRequired = data.required ? true : false;
      }
      if (data.browseEvent !== undefined) {
        this.intBrowseEvent = data.browseEvent ? true : false;
      }
      this.intHasImage = false;
      if (this.intValue.length) {
        this.fetchPictureFromPath(`${this.intValue}`);
      }
    } else {
      // * Init Uppon Vue component
      this.intId = this.id;
      this.intName = this.name;
      this.intHelper = this.helper;
      this.intWidth = this.width;
      this.intHeight = this.height;
      this.intValue = this.value;
      if (this.intValue.length) {
        this.intValueFileName = this.intValue.replace(/^\/|^/, "");
        this.intValue = this.intValue.replace(/^\/|^/, "/");
      }
      this.intPreview = this.preview;
      this.intRequired = this.required;
      this.intBrowseEvent = this.browseEvent;
    }
    setTimeout(() => {
      this.tooltips = Tooltips.make({
        type: "dom",
        elements: (this.$refs.imageInput as HTMLDivElement)
          .querySelectorAll("[data-bs-tooltip=\"tooltip\"]")
      });
    }, 500);
  },
  computed: {
    imageRatio() {
      return this.intWidth / this.intHeight;
    },
    cropperOption(): Cropper.Options {
      return {
        autoCrop: true,
        background: true,
        autoCropArea: 1,
        viewMode: 0,
        dragMode: "move",
        movable: true,
        rotatable: true,
        scalable: true,
        zoomable: true,
        zoomOnTouch: false,
        zoomOnWheel: false,
        cropBoxMovable: true,
        cropBoxResizable: false,
        toggleDragModeOnDblclick: false,
        aspectRatio: this.intWidth / this.intHeight,
        preview: `#Preview${this.intId}`,
      };
    },
    /** Removes prepended slash */
    submitIntValue(): string {
      return this.intValue.replace(/^\/|^/, "");
    },
  },
  watch: {
    intRotationValue(value: number) {
      if (!this.intCropper) {
        return;
      }
      this.intCropper.rotateTo(value);
    },
    intValue() {
      if (this.intBrowseEvent) {
        this.intHasImage = true;
      }
      setTimeout(() => {
        this.tooltips?.closeBootstrapTooltip();
        this.tooltips = Tooltips.make({
          type: "dom",
          elements: (this.$refs.imageInput as HTMLDivElement)
            .querySelectorAll("[data-bs-tooltip=\"tooltip\"]")
        });
      }, 500);
    },
    value: {
      deep: true,
      immediate: true,
      handler(value: string) {
        // * Ignore non prop usage.
        if (String(this.$attrs.json ?? "").length) {
          return;
        }
        if (!value.length) {
          this.removeFile();
          return;
        } else {
          this.intHasImage = true;
        }
        // * Using browse event, If user changed image recompile blob (File Upload storage strategy)
        if (this.browseEvent && this.intHasImage) {
          this.$nextTick(() => this.fetchPictureFromPath(value));
        } else {
          this.intValue = value;
          if (this.intValue.length) {
            this.intValueFileName = this.intValue.replace(/^\/|^/, "");
            this.intValue = this.intValue.replace(/^\/|^/, "/");
          }
        }
      },
    },
  },
  methods: {
    preventMouseDown(e: MouseEvent) {
      if ((e.target as HTMLElement)?.id !== "range") {
        e.preventDefault();
        return false;
      }
    },
    previewStyleCompute() {
      const previewBox = this.$refs.previewBox as HTMLElement,
            style = window.getComputedStyle(previewBox),
            targetWidth = Number.parseFloat(style.width) / 1.2,
            targetHeight =
              (this.intHeight * Number.parseFloat(style.width)) /
              this.intWidth /
              1.2;
      this.intPreviewStyle = `width: ${targetWidth.toFixed(
        3
      )}px;height:${targetHeight.toFixed(3)}px;`;
    },
    reset() {
      if (!this.intCropper) {
        return;
      }
      this.intCropper.reset();
    },
    zoom(v: number) {
      if (!this.intCropper) {
        return;
      }
      this.intCropper.zoom(v);
    },
    move(x: number, y: number) {
      if (!this.intCropper) {
        return;
      }
      this.intCropper.move(x, y);
    },
    scale(horizontal: boolean) {
      if (!this.intCropper) {
        return;
      }
      if (horizontal) {
        this.intScaleX = -1 / this.intScaleX;
        this.intCropper.scaleX(this.intScaleX);
      } else {
        this.intScaleY = -1 / this.intScaleY;
        this.intCropper.scaleY(this.intScaleY);
      }
    },
    rotate(value: number) {
      const rotationSlider = this.$refs.rotationSlider as HTMLInputElement;
      let res = this.intRotationValue + value;
      res = res < 0 ? 0 : res;
      res = res > 360 ? 360 : res;
      this.intRotationValue = res;
      this.intRotationText = this.intRotationValue;
      rotationSlider.value = String(this.intRotationValue);
    },
    rotateTo(value: number) {
      value = value < 0 ? 0 : value;
      value = value > 360 ? 360 : value;
      this.intRotationValue = value;
      this.intRotationText = this.intRotationValue;
    },
    rotationChange(e: Event) {
      const el = e.target;
      if (!el || !(el instanceof HTMLInputElement)) {
        throw new Error("target element is not an input");
      }
      this.rotateTo(Number.parseFloat(el.value));
    },
    chooseAFile() {
      const actualImage = this.$refs.actualImage as HTMLInputElement;
      if (this.intBrowseEvent) {
        this.$emit("browseFile", this.intId);
        return;
      }
      actualImage.click();
    },
    removeFile() {
      if (!this.$refs.actualImage) {
        return;
      }
      const actualImage = this.$refs.actualImage as HTMLInputElement;
      actualImage.value = "";
      this.intValueFileName = this.__("bo_tooltip_image_input_placeholder");
      this.intValue = "";
      this.intOriginalFileName = "";
      this.intOriginalFile = null;
      this.intHasModdedImage = false;
      this.intOriginalFileDimensions = {
        height: 0,
        width: 0,
      };
      // * To overload watcher for intValue
      this.$nextTick(() => (this.intHasImage = false));
      this.$emit("imageFile", null);
    },
    fetchPictureFromPath(value: string): void {
      const actualImage: HTMLInputElement = this.$refs.actualImage as HTMLInputElement,
            container: DataTransfer = new DataTransfer();

      this.$nextTick(() => {
        const stringValue: string = value.replace(/^\/|^/, "/"),
              stringFileName: string = stringValue.substring(stringValue.lastIndexOf("/")).replace(/^\/|^/, "");

        fetch(stringValue)
          .then((response) => {
            this.intOriginalFileName = decodeURI(response.url.substring(
              response.url.lastIndexOf("/") + 1
            ));
            return response.blob();
          })
          .then((blob: Blob) => {
            if (!actualImage.files) {
              throw new Error("3- missing files list");
            }
            this.fetchDataUrlImageSizes(stringValue);
            const file = new File([blob], stringFileName, {
              type: "image/png",
              lastModified: new Date().getTime(),
            });

            this.intValue = stringValue;
            this.intValueFileName = stringFileName;
            this.intHasImage = true;
            this.intOriginalFile = file;
            this.$emit("imageFile", file);
            container.items.add(file);
            actualImage.files = container.files;
            this.changedImage();
          });
      });
    },
    changedImage() {
      const reader = new FileReader(),
            actualImage = this.$refs.actualImage as HTMLInputElement;
      if (!actualImage.files) {
        throw new Error("missing files list");
      }
      this.intHasImage = true;
      reader.addEventListener(
        "load",
        () => {
          // On convertit l'image en une chaîne de caractères base64.
          this.intValue = String(reader.result);
        },
        false
      );

      if (actualImage.files[0]) {
        this.intOriginalFile = actualImage.files[0];
        this.intOriginalFileName = actualImage.files[0].name;
        reader.readAsDataURL(actualImage.files[0]);
        reader.onloadend = () => {
          this.fetchDataUrlImageSizes(String(reader.result));
          this.exportToBlob();
        };
        this.intValueFileName = actualImage.files[0].name;
      }
    },
    prepareImageEditor(e: Event) {
      const actualImage = this.$refs.actualImage as HTMLInputElement,
            imgEditor = this.$refs.imgEditor as HTMLImageElement,
            createCropper = () => {
              if (this.intCropper) {
                this.intCropper.destroy();
              }
              this.intCropper = new Cropper(imgEditor, this.cropperOption);
            };

      if (!this.browseEvent) {
        if (!actualImage || !actualImage.files) {
          throw new Error("actualImage is not defined");
        }
        this.intOriginalFile = actualImage.files[0];
        this.intOriginalFileName = actualImage.files[0].name;
        imgEditor.src = URL.createObjectURL(actualImage.files[0]);

        this.previewStyleCompute();
        this.$nextTick(() => createCropper());
        return;
      }

      e.preventDefault();
      this.$nextTick(() => {
        fetch(this.value.replace(/^\/|^/, "/"))
          .then((response) => {
            this.intOriginalFileName = response.url.substring(
              response.url.lastIndexOf("/") + 1
            );
            return response.blob();
          })
          .then((blob: Blob) => {
            imgEditor.src = URL.createObjectURL(blob);

            this.previewStyleCompute();
            this.$nextTick(createCropper);
          });
      });
    },
    dataURLtoBlob(dataUrl: string) {
      const arr = dataUrl.split(",");
      if (!arr[0] || !arr[1]) {
        throw new Error("invalid data url");
      }
      const mime = arr[0].match(/:(.*?);/);
      if (!mime || mime.length < 2) {
        throw new Error("invalid mime");
      }
      const bstr = window.atob(arr[1]);
      let n = bstr.length;
      const u8arr = new Uint8Array(n);
      while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
      }
      return new Blob([u8arr], { type: mime[1] });
    },
    fetchDataUrlImageSizes(dataUrl: string) {
      const img = new Image();
      try {
        img.onload = () => {
          this.intOriginalFileDimensions.width = img.width;
          this.intOriginalFileDimensions.height = img.height;
        };
        img.src = dataUrl;
      } catch (e) {
        this.intOriginalFileDimensions.width = img.width;
        this.intOriginalFileDimensions.height = img.height;
      }
    },
    exportCropperFile() {
      this.intHasModdedImage = true;
      if (!this.intCropper) {
        return;
      }
      this.intValue = this.intCropper
        .getCroppedCanvas({
          fillColor: "rgba(0, 0, 0, 0)",
          width: this.intWidth,
          height: this.intHeight,
          imageSmoothingEnabled: true,
          imageSmoothingQuality: "high",
        })
        .toDataURL("image/png");
      this.exportToBlob();
    },
    exportToBlob() {
      const actualImage = this.$refs.actualImage as HTMLInputElement,
            container = new DataTransfer();
      if (!actualImage.files) {
        throw new Error("2- missing files list");
      }
      this.fetchDataUrlImageSizes(this.intValue);
      const file = new File(
        [this.dataURLtoBlob(this.intValue)],
        this.intOriginalFileName,
        {
          type: "image/png",
          lastModified: new Date().getTime(),
        }
      );
      this.intOriginalFile = file;
      this.$emit("imageFile", file);
      container.items.add(file);
      actualImage.files = container.files;
    },
    humanFileSize(sizeBytes: number | bigint): string {
      let size = Math.abs(Number(sizeBytes));

      let u = 0;
      while (size >= BYTES_PER_KB && u < UNITS.length - 1) {
        size /= BYTES_PER_KB;
        ++u;
      }

      return new Intl.NumberFormat([], {
        style: "unit",
        unit: UNITS[u],
        unitDisplay: "short",
        maximumFractionDigits: 1,
      }).format(size);
    },
  },
});
</script>

<style lang="scss" scopped>
@import "cropperjs/dist/cropper.css";

.image-input-vue {
  /* Ensure the size of the image fit the container perfectly */
  .image-modification {
    display: block;

    /* This rule is very important, please don't ignore this */
    max-width: 100%;
  }
  .rotate-button {
    display: flex;
    flex-direction: column;
  }
  .rotate-drag {
    display: flex;
    flex-direction: column-reverse;
    width: 100%;
    & > input {
      width: 100%;
    }
  }
  .preview-img {
    position: relative;
    & > div {
      position: relative;
      overflow: hidden;
      border: 1px solid black;
      top: 50%;
      left: 50%;
      transform: translateX(-50%) translateY(-50%);
    }
  }
  input.right-aligned {
    direction: ltr !important;
    overflow: hidden !important;
  }
  input.right-aligned :not(:focus) {
    direction: rtl !important;
    text-align: left !important;
    text-overflow: ellipsis !important;
  }
}
</style>
