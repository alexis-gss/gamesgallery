<template>
  <div :class="`image-input image-input-${intId} p-0`">
    <div class="row">
      <div :class="`col-12 col-md-6 form-group`">
        <label
          :for="intId"
          class="col-form-label fw-bold"
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
            class="btn btn-secondary"
            type="button"
            :title="__('bo_tooltip_image_input_modify_source')"
            data-bs-tooltip="tooltip"
          >
            <i class="fa-solid fa-folder-open" />
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
            v-if="typeof intValue === 'string'"
            class="d-none"
            :name="intName"
            type="text"
            :value="intValue"
          >
          <input
            @click.prevent="chooseAFile"
            type="text"
            :value="intValueFileName"
            class="form-control right-aligned"
            :title="__('bo_tooltip_image_input_modify_source')"
            data-bs-tooltip="tooltip"
            :aria-describedby="`Help${intId}`"
            readonly
          >
          <button
            v-if="!intRequired"
            @click.prevent="removeFile"
            class="btn btn-outline-danger"
            type="button"
          >
            <i class="fas fa-eraser" />
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
            <i class="fa-solid fa-crop" />
          </button>
          <span
            v-if="intHasModdedImage"
            class="input-group-text text-success"
            :title="__('bo_tooltip_image_input_image_resized')"
            data-bs-tooltip="tooltip"
          >
            <i class="fa-solid fa-wand-magic" />
          </span>
        </div>
        <small
          :id="`Help${intId}`"
          class="form-text text-body-secondary"
        >
          {{ intHelper }}
        </small>
      </div>
      <div :class="`col-12 col-md-6 form-group`">
        <label
          v-if="intValue"
          class="col-form-label w-100 fw-bold w-100"
        >
          {{ __("bo_label_preview_image") }}
          <span
            :title="__('bo_tooltip_image_input_preview_image')"
            data-bs-tooltip="tooltip"
          >
            <i class="fa-solid fa-circle-info" />
          </span>
        </label>
        <img
          v-if="intValue"
          class="img-fluid"
          :src="intValue"
          :alt="__('bo_other_preview_image_placeholder')"
          :aria-describedby="`PreviewHelp${intId}`"
        >
        <small
          v-if="intValue"
          :id="`PreviewHelp${intId}`"
          class="form-text text-body-secondary d-block m-0"
        >
          <span v-if="intOriginalFile">
            {{ humanFileSize(intOriginalFile.size) }}
            {{ `largeur ${intOriginalFileDimensions.width}px` }}
            {{ `hauteur ${intOriginalFileDimensions.height}px` }}.
          </span>
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
    >
      <div
        class="modal-dialog modal-xl d-flex align-items-center h-100 my-0"
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
                      <i class="fa fa-sync-alt" />
                    </button>
                  </div>
                  <div class="btn-group me-4 mt-2">
                    <button
                      class="btn btn-primary"
                      :title="__('bo_tooltip_image_input_zoom_in')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="zoom(0.1)"
                    >
                      <i class="fa fa-search-plus" />
                    </button>
                    <a
                      class="btn btn-primary"
                      :title="__('bo_tooltip_image_input_zoom_out')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="zoom(-0.1)"
                    >
                      <i class="fa fa-search-minus" />
                    </a>
                  </div>
                  <div class="btn-group me-4 mt-2">
                    <a
                      class="btn btn-primary"
                      :title="__('bo_tooltip_image_input_move_left')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="move(-10, 0)"
                    >
                      <i class="fa fa-arrow-left" />
                    </a>
                    <a
                      class="btn btn-primary"
                      :title="__('bo_tooltip_image_input_move_right')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="move(10, 0)"
                    >
                      <i class="fa fa-arrow-right" />
                    </a>
                    <a
                      class="btn btn-primary"
                      :title="__('bo_tooltip_image_input_move_up')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="move(0, -10)"
                    >
                      <i class="fa fa-arrow-up" />
                    </a>
                    <a
                      class="btn btn-primary"
                      :title="__('bo_tooltip_image_input_move_down')"
                      data-bs-tooltip="tooltip"
                      @click.prevent="move(0, 10)"
                    >
                      <i class="fa fa-arrow-down" />
                    </a>
                  </div>
                  <div class="btn-group me-4 mt-2">
                    <a
                      class="btn btn-primary"
                      :title="
                        __('bo_tooltip_image_input_mirror_horizontal')
                      "
                      data-bs-tooltip="tooltip"
                      @click.prevent="scale(true)"
                    >
                      <i class="fa fa-arrows-alt-h" />
                    </a>
                    <a
                      class="btn btn-primary"
                      :title="
                        __('bo_tooltip_image_input_mirror_vertical')
                      "
                      data-bs-tooltip="tooltip"
                      @click.prevent="scale(false)"
                    >
                      <i class="fa fa-arrows-alt-v" />
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
                          :title="
                            __('bo_tooltip_image_input_counterclockwise')
                          "
                          data-bs-tooltip="tooltip"
                          @click.prevent="rotate(-45)"
                        >
                          <i class="fa fa-undo-alt" />
                        </a>
                        <a
                          class="btn btn-primary"
                          :title="__('bo_tooltip_image_input_clockwise')"
                          data-bs-tooltip="tooltip"
                          @click.prevent="rotate(45)"
                        >
                          <i class="fa fa-redo-alt" />
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
                        @input.stop="rotationChange($event as Event)"
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
                  class="col-12 col-md-6 p-0 bg-body-tertiary preview-image"
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
              :title="
                __('bo_tooltip_image_input_modal_close_without_saving')
              "
              data-bs-tooltip="tooltip"
            >
              {{ __("bo_other_close") }}
            </button>
            <button
              @click.prevent="exportToBlob"
              type="button"
              class="btn btn-primary"
              :title="
                __('bo_tooltip_image_input_modal_close_with_saving')
              "
              data-bs-tooltip="tooltip"
              data-bs-dismiss="modal"
            >
              {{ __("crud.actions.save") }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Cropper from "cropperjs";
import { defineComponent } from "vue";
import tooltip from "./../../modules/tooltip";
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
  mixins: [tooltip, trans],
  emits: ["browseFile"],
  props: {
    value: {
      type: String,
      default: "",
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
  } {
    return {
      intId: "",
      intValue: "",
      intValueFileName: this.__("Sélectionnez une image"),
      intHelper: "",
      intName: "",
      intRequired: true,
      intWidth: 0,
      intHeight: 0,

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
    };
  },
  mounted() {
    const json = String(this.$attrs.json ?? "");
    const data = JSON.parse(json);
    this.intId = data.id;
    this.intName = data.name;
    this.intHelper = data.helper ?? "";
    this.intWidth = data.width;
    this.intHeight = data.height;
    this.intValue = String(data.value);
    if (this.intValue.length) {
      this.intValueFileName = this.intValue;
      this.intValue = this.intValue.replace(/^\/|^/, "/");
    }
    if (data.required !== undefined) {
      this.intRequired = data.required ? true : false;
    }
    if (data.browseEvent !== undefined) {
      this.intBrowseEvent = data.browseEvent ? true : false;
    }
    this.intHasImage = false;
    this.$nextTick(() => {
      this.setBootstrapTooltip();
    });
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
  },
  watch: {
    intRotationValue(value) {
      if (!(this.intCropper instanceof Cropper)) {
        throw new Error("cropped not initialized");
      }
      this.intCropper.rotateTo(value);
    },
    intValue() {
      if (this.intBrowseEvent) {
        this.intHasImage = true;
      }
    },
    value() {
      this.intValue = this.value.replace(/^\/|^/, "/");
      this.intValueFileName = this.value;
    },
  },
  methods: {
    /**
     * Cropper preview style.
     */
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
    /**
     * Cropper reset.
     */
    reset() {
      if (!(this.intCropper instanceof Cropper)) {
        return;
      }
      this.intCropper.reset();
    },
    /**
     * Cropper zoom.
     */
    zoom(v: number) {
      if (!(this.intCropper instanceof Cropper)) {
        return;
      }
      this.intCropper.zoom(v);
    },
    /**
     * Cropper move.
     */
    move(x: number, y: number) {
      if (!(this.intCropper instanceof Cropper)) {
        return;
      }
      this.intCropper.move(x, y);
    },
    /**
     * Cropper scale.
     */
    scale(horizontal: boolean) {
      if (!(this.intCropper instanceof Cropper)) {
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
    /**
     * Cropper rotate.
     */
    rotate(value: number) {
      const rotationSlider = this.$refs.rotationSlider as HTMLInputElement;
      let res = this.intRotationValue + value;
      res = res < 0 ? 0 : res;
      res = res > 360 ? 360 : res;
      this.intRotationValue = res;
      this.intRotationText = this.intRotationValue;
      rotationSlider.value = String(this.intRotationValue);
    },
    /**
     * Cropper rotate to.
     */
    rotateTo(value: number) {
      value = value < 0 ? 0 : value;
      value = value > 360 ? 360 : value;
      this.intRotationValue = value;
      this.intRotationText = this.intRotationValue;
    },
    /**
     * Cropper rotation input.
     */
    rotationChange(e: Event) {
      const el = e.target;
      if (!el || !(el instanceof HTMLInputElement)) {
        throw new Error("target element is not an input");
      }
      this.rotateTo(Number.parseFloat(el.value));
    },
    /**
     * Link button change image to the input file image.
     */
    chooseAFile() {
      const actualImage = this.$refs.actualImage as HTMLInputElement;
      if (this.intBrowseEvent) {
        this.$emit("browseFile", this.intId);
        return;
      }
      actualImage.click();
    },
    /**
     * Remove one specific image.
     */
    removeFile() {
      const actualImage = this.$refs.actualImage as HTMLInputElement;
      actualImage.value = "";
      this.intValueFileName = this.__("Sélectionnez une image");
      this.intValue = "";
    },
    /**
     * Change one specific image.
     */
    changedImage(e: Event) {
      const self = this,
            reader = new FileReader();
      const el = e.target;
      if (!el || !(el instanceof HTMLInputElement)) {
        throw new Error(
          "confirmDoneJS can only be executed on an exising form"
        );
      }
      if (!el.files) {
        throw new Error();
      }
      self.intHasImage = true;
      reader.addEventListener(
        "load",
        () => {
          // On convertit l'image en une chaîne de caractères base64.
          self.intValue = String(reader.result);
        },
        false
      );
      if (el.files[0]) {
        self.intOriginalFile = el.files[0];
        reader.readAsDataURL(el.files[0]);
        reader.onloadend = () => {
          this.intHasModdedImage = false;
          this.fetchDataUrlImageSizes(String(reader.result));
        };
        this.intValueFileName = el.files[0].name;
      }
    },
    /**
     * Set cropper to edit a specific image.
     */
    prepareImageEditor(e: Event) {
      const self = this,
            actualImage = this.$refs.actualImage as HTMLInputElement,
            imgEditor = this.$refs.imgEditor as HTMLImageElement,
            createCropper = () => {
              if (self.intCropper) {
                self.intCropper.destroy();
              }
              self.intCropper = new Cropper(imgEditor, self.cropperOption);
            };

      if (!self.browseEvent) {
        if (!actualImage || !actualImage.files) {
          throw new Error("actualImage is not defined");
        }
        self.intOriginalFile = actualImage.files[0];
        self.intOriginalFileName = actualImage.files[0].name;
        imgEditor.src = URL.createObjectURL(actualImage.files[0]);

        self.previewStyleCompute();
        this.$nextTick(() => createCropper());
        return;
      }

      e.preventDefault();
      this.$nextTick(() => {
        fetch(self.value.replace(/^\/|^/, "/"))
          .then((response) => {
            self.intOriginalFileName = response.url.substring(
              response.url.lastIndexOf("/") + 1
            );
            return response.blob();
          })
          .then((blob: Blob) => {
            imgEditor.src = URL.createObjectURL(blob);

            self.previewStyleCompute();
            self.$nextTick(() => createCropper());
          });
      });
    },
    /**
     * Create a Blob from a specific url.
     */
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
    /**
     * Update image sizes.
     */
    fetchDataUrlImageSizes(dataUrl: string) {
      const img = new Image(),
            self = this;
      try {
        img.onload = () => {
          self.intOriginalFileDimensions.width = img.width;
          self.intOriginalFileDimensions.height = img.height;
        };
        img.src = dataUrl;
      } catch (e) {
        self.intOriginalFileDimensions.width = img.width;
        self.intOriginalFileDimensions.height = img.height;
      }
    },
    /**
     * Set image after the edit in cropper.
     */
    exportToBlob() {
      const actualImage = this.$refs.actualImage as HTMLInputElement,
            container = new DataTransfer();
      if (!(this.intCropper instanceof Cropper)) {
        return;
      }
      if (!actualImage.files) {
        throw new Error();
      }
      this.intHasModdedImage = true;
      this.$nextTick(() => {
        this.setBootstrapTooltip();
      });
      this.intValue = this.intCropper
        .getCroppedCanvas({
          fillColor: "rgba(0, 0, 0, 0)",
          width: this.intWidth,
          height: this.intHeight,
          imageSmoothingEnabled: true,
          imageSmoothingQuality: "high",
        })
        .toDataURL("image/png");
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
      container.items.add(file);
      actualImage.files = container.files;
    },
    /**
     * Get size of a file.
     */
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

<style lang="scss">
@import "cropperjs/dist/cropper.css";
.image-input {
  .image-modification {
    display: block;
    max-width: 100%;
  }
  .rotate-button {
    display: flex;
    flex-direction: column;
  }
  .rotate-drag {
    display: flex;
    width: 100%;
    flex-direction: column-reverse;
    input {
      width: 100%;
    }
  }
  .preview-image {
    position: relative;
    div {
      position: relative;
      top: 50%;
      left: 50%;
      overflow: hidden;
      border: 1px solid #000;
      transform: translateX(-50%) translateY(-50%);
    }
  }
  .right-aligned {
    overflow: hidden !important;
    direction: ltr !important;
  }
  .right-aligned:not(:focus) {
    text-align: left !important;
    text-overflow: ellipsis !important;
  }
}
</style>
