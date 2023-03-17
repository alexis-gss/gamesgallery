<template>
  <div :class="`container images-input images-input-${intId} p-0`">
    <!-- Main buttons -->
    <div class="row">
      <div class="col-12 d-flex form-group">
        <div class="input-group">
          <button
            @click.prevent="chooseFiles"
            class="btn btn-secondary"
            type="button"
            :title="__('form.tooltip_image_input_modify_sources')"
            data-bs-tooltip="tooltip"
            :disabled="intValues.length >= itemLimit[1]"
          >
            <i class="fa-solid fa-folder-open" />
          </button>
          <input
            :id="intId"
            ref="actualImages"
            @change="changedImages"
            type="file"
            class="d-none"
            name="multipleInputImages"
            accept=".jpg,.jpeg,.gif,.png"
            :aria-describedby="`Help${intId}`"
            multiple
          >
          <input
            @click.prevent="chooseFiles"
            type="text"
            :value="
              'Actuellement ' +
                intValues.length +
                '/' +
                itemLimit[1] +
                ' images sont présentent'
            "
            class="form-control right-aligned"
            :title="__('form.tooltip_image_input_modify_sources')"
            data-bs-tooltip="tooltip"
            :aria-describedby="`Help${intId}`"
            :disabled="intValues.length >= itemLimit[1]"
            readonly
          >
          <button
            class="btn btn-primary btn-collapse collapsed"
            type="button"
            :title="__('form.tooltip_image_input_show_hide_content')"
            data-bs-tooltip="tooltip"
            data-bs-toggle="collapse"
            data-bs-target="#multiple-images"
            aria-expanded="false"
            aria-controls="multiple-images"
            :disabled="!intHasImages"
          >
            <i class="fa fa-arrow-down" />
          </button>
          <button
            v-if="intValues.length > itemLimit[0]"
            @click.prevent="removeFiles"
            class="btn btn-danger"
            type="button"
            :title="__('form.tooltip_image_input_remove_images')"
            data-bs-tooltip="tooltip"
            :disabled="intValues.length <= 0"
          >
            <i class="fas fa-eraser" />
          </button>
        </div>
      </div>
    </div>
    <!-- End main buttons -->
    <!-- Content collapse -->
    <div
      class="collapse"
      id="multiple-images"
    >
      <div class="row w-100 mx-auto my-2">
        <div
          v-for="n = 0 in intValues.length"
          :key="n"
          class="col-12 form-group text-center px-1"
        >
          <div
            class="d-flex justify-content-between align-items-center pb-1"
            :class="n != 1 ? 'border-top' : ''"
          >
            <label
              v-if="intValues[n - 1]"
              class="col-form-label fw-bold"
            >
              {{ __("form.image_input_number_image") }}{{ n }}
            </label>
            <small
              v-if="intValues[n - 1]"
              :id="`PreviewHelp${intId}`"
              class="form-text text-muted d-block m-0"
            >
              <span v-if="intOriginalFile[n - 1]">
                {{ humanFileSize(intOriginalFile[n - 1].size) }}
                {{ `largeur ${intOriginalFileDimensions[n - 1].width}px` }}
                {{ `hauteur ${intOriginalFileDimensions[n - 1].height}px` }}.
              </span>
            </small>
            <div class="input-group justify-content-center mt-1 w-auto">
              <button
                @click.prevent="viewImageSource(n - 1)"
                class="btn btn-warning"
                type="button"
                data-bs-toggle="modal"
                :data-bs-target="`#modalViewer${intId}`"
                :title="__('form.tooltip_image_input_preview_image')"
                data-bs-tooltip="tooltip"
              >
                <i class="fa-solid fa-eye" />
              </button>
              <button
                @click.prevent="chooseAFile(n - 1)"
                class="btn btn-secondary"
                type="button"
                :title="__('form.tooltip_image_input_modify_source')"
                data-bs-tooltip="tooltip"
              >
                <i class="fa-solid fa-folder-open" />
              </button>
              <input
                :id="intId"
                ref="actualImage"
                @change="changedImage($event, n - 1)"
                type="file"
                class="d-none"
                :name="intName"
                accept=".jpg,.jpeg,.gif,.png"
                :aria-describedby="`Help${intId}`"
              >
              <button
                @click.prevent="prepareImageEditor(n - 1)"
                :disabled="!intHasImage[n - 1]"
                :class="`btn ${
                  !intHasModdedImage[n - 1] ? 'btn-primary' : 'btn-success'
                }`"
                type="button"
                data-bs-toggle="modal"
                :data-bs-target="`#Modal${intId}`"
                :title="__('form.tooltip_image_input_resize_image')"
                data-bs-tooltip="tooltip"
              >
                <i class="fa-solid fa-crop" />
              </button>
              <span
                v-if="intHasModdedImage[n - 1]"
                class="input-group-text text-success"
                :title="__('form.tooltip_image_input_image_resized')"
                data-bs-tooltip="tooltip"
              >
                <i class="fa-solid fa-wand-magic" />
              </span>
              <button
                v-if="intValues.length > itemLimit[0]"
                @click.prevent="removeFile(n - 1)"
                class="btn btn-danger"
                type="button"
                :title="__('form.tooltip_image_input_remove_image')"
                data-bs-tooltip="tooltip"
              >
                <i class="fas fa-trash" />
              </button>
            </div>
          </div>
          <p class="text-danger m-0">
            {{
              parseValidationInput(
                `${intName.replace(/[\[\]']+/g, "")}.${n - 1}`,
                allErrors
              )
            }}
          </p>
        </div>
        <!-- Viewer modal -->
        <div
          :id="`modalViewer${intId}`"
          class="modal"
          tabindex="-1"
          role="dialog"
          data-bs-backdrop="static"
          data-bs-keyboard="false"
        >
          <div
            class="modal-dialog modal-xl d-flex align-items-center h-100 my-0 py-4"
          >
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                  {{ __("form.images_result") }}
                </h5>
                <button
                  @click.prevent="removeImageSource"
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  :aria-label="__('Fermer la fenêtre')"
                  :title="__('form.tooltip_image_input_close')"
                  data-bs-tooltip="tooltip"
                />
              </div>
              <div class="modal-body">
                <div
                  v-if="intViewerLoadImage"
                  class="text-center w-100"
                >
                  <div
                    class="spinner-border text-secondary"
                    role="status"
                  >
                    <span class="visually-hidden">
                      {{ __("form.image_input_viewer_loading") }}
                    </span>
                  </div>
                </div>
                <img
                  class="w-100"
                  :class="intViewerLoadImage ? 'd-none' : ''"
                  ref="imgViewer"
                  src=""
                >
              </div>
            </div>
          </div>
        </div>
        <!-- Cropper modal -->
        <div
          :id="`Modal${intId}`"
          class="modal"
          tabindex="-1"
          role="dialog"
          data-bs-backdrop="static"
          data-bs-keyboard="false"
        >
          <div
            class="modal-dialog modal-xl"
            role="document"
          >
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                  {{ __("form.image_input_edit_image_before_import") }}
                </h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  :aria-label="__('Fermer la fenêtre')"
                  :title="
                    __('form.tooltip_image_input_modal_close_without_saving')
                  "
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
                          :title="__('form.tooltip_image_input_reset_image')"
                          data-bs-tooltip="tooltip"
                          @click.prevent="reset()"
                        >
                          <i class="fa fa-sync-alt" />
                        </button>
                      </div>
                      <div class="btn-group me-4 mt-2">
                        <button
                          class="btn btn-primary"
                          :title="__('form.tooltip_image_input_zoom_in')"
                          data-bs-tooltip="tooltip"
                          @click.prevent="zoom(0.1)"
                        >
                          <i class="fa fa-search-plus" />
                        </button>
                        <a
                          class="btn btn-primary"
                          :title="__('form.tooltip_image_input_zoom_out')"
                          data-bs-tooltip="tooltip"
                          @click.prevent="zoom(-0.1)"
                        >
                          <i class="fa fa-search-minus" />
                        </a>
                      </div>
                      <div class="btn-group me-4 mt-2">
                        <a
                          class="btn btn-primary"
                          :title="__('form.tooltip_image_input_move_left')"
                          data-bs-tooltip="tooltip"
                          @click.prevent="move(-10, 0)"
                        >
                          <i class="fa fa-arrow-left" />
                        </a>
                        <a
                          class="btn btn-primary"
                          :title="__('form.tooltip_image_input_move_right')"
                          data-bs-tooltip="tooltip"
                          @click.prevent="move(10, 0)"
                        >
                          <i class="fa fa-arrow-right" />
                        </a>
                        <a
                          class="btn btn-primary"
                          data-bs-tooltip="tooltip"
                          :title="__('form.tooltip_image_input_move_up')"
                          @click.prevent="move(0, -10)"
                        >
                          <i class="fa fa-arrow-up" />
                        </a>
                        <a
                          class="btn btn-primary"
                          :title="__('form.tooltip_image_input_move_down')"
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
                            __('form.tooltip_image_input_mirror_horizontal')
                          "
                          data-bs-tooltip="tooltip"
                          @click.prevent="scale(true)"
                        >
                          <i class="fa fa-arrows-alt-h" />
                        </a>
                        <a
                          class="btn btn-primary"
                          :title="
                            __('form.tooltip_image_input_mirror_vertical')
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
                                __(
                                  'form.tooltip_image_input_rotation_counterclockwise'
                                )
                              "
                              data-bs-tooltip="tooltip"
                              @click.prevent="rotate(-45)"
                            >
                              <i class="fa fa-undo-alt" />
                            </a>
                            <a
                              class="btn btn-primary"
                              :title="
                                __(
                                  'form.tooltip_image_input_rotation_clockwise'
                                )
                              "
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
                              __("form.image_input_preview_rotation_degrees", {
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
                      class="col-12 col-md-6 p-0 bg-light preview-image"
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
                    __('form.tooltip_image_input_modal_close_without_saving')
                  "
                  data-bs-tooltip="tooltip"
                >
                  {{ __("form.image_input_modal_close") }}
                </button>
                <button
                  @click.prevent="exportToBlob"
                  type="button"
                  class="btn btn-primary"
                  :title="
                    __('form.tooltip_image_input_modal_close_with_saving')
                  "
                  data-bs-tooltip="tooltip"
                  data-bs-dismiss="modal"
                >
                  {{ __("form.image_input_modal_save") }}
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- End cropper modal -->
      </div>
      <!-- End content collapse -->
      <small
        :id="`Help${intId}`"
        class="form-text text-muted"
      >
        {{ intHelper }}
      </small>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Cropper from "cropperjs";
import { Tooltip } from "bootstrap";
import error from "../../modules/error";
import trans from "../../modules/trans";

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
  mixins: [error, trans],
  props: {
    id: {
      type: String,
      default: "",
    },
    required: {
      type: Boolean,
      default: false,
    },
    name: {
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
  },
  data(): {
    intId: string;
    intName: string;
    intWidth: number;
    intHeight: number;
    intRotationText: number;
    intRotationValue: number;
    intScaleX: number;
    intScaleY: number;
    intHasImage: boolean[];
    intHasModdedImage: boolean[];
    intCropper: Cropper | null;
    intOriginalFile: File[];
    intOriginalFileDimensions: {
      height: number;
      width: number;
    }[];
    intOriginalFileName: string[];
    intPreviewStyle: string;
    intIdImage: number;
    intHasImages: boolean;
    intValues: string[];
    intHelper: string;
    intTooltipList: HTMLButtonElement[];
    intBtnCollapse: HTMLButtonElement | null;
    intLoopLoadImages: number;
    intViewerLoadImage: boolean;
    intInputImages: HTMLInputElement[];
    itemLimit: number[];
    allErrors: Record<string, string[]>;
  } {
    return {
      intId: "",
      intName: "",
      intWidth: 0,
      intHeight: 0,
      intRotationText: 0,
      intRotationValue: 0,
      intScaleX: 1,
      intScaleY: 1,
      intHasImage: [],
      intHasModdedImage: [],
      intCropper: null,
      intOriginalFile: [],
      intOriginalFileDimensions: [],
      intOriginalFileName: [],
      intPreviewStyle: "",
      intIdImage: 0,
      intHasImages: false,
      intValues: [],
      intHelper: "",
      intBtnCollapse: null,
      intTooltipList: [],
      intLoopLoadImages: 0,
      intViewerLoadImage: false,
      intInputImages: [],
      itemLimit: [0, 0],
      allErrors: {},
    };
  },
  mounted() {
    const json = String(this.$attrs.json ?? "");
    const data = JSON.parse(json);
    this.intId = data.id;
    this.intName = data.name;
    this.intWidth = data.width;
    this.intHeight = data.height;
    this.intValues = data.value;
    this.intHelper = data.helper ?? "";
    this.itemLimit = data.limit;
    this.allErrors = data.errors ?? {};
    this.$nextTick(() => {
      this.initComponent();
      this.updateBootstrapTooltip();
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
  },
  methods: {
    /**
     * Initialise the component with previously images registered.
     */
    initComponent() {
      if (this.intValues.length > 0) {
        this.intBtnCollapse = document.querySelector(
          "[data-bs-target=\"#multiple-images\"]"
        );
        this.intValues.forEach((element, index) => {
          element.charAt(0) != "/" ? "/".concat(element) : "";
          this.intValues.splice(index, 1, element.replace(/^\/|^/, "/"));
        });
        this.intHasImage = Array(this.intValues.length).fill(false);
        this.intOriginalFileDimensions = Array(this.intValues.length).fill({
          width: 0,
          height: 0,
        });
        this.intHasImages = true;
        this.initImagesSaved();
      } else {
        this.intHasImages = false;
      }
    },
    /**
     * Assign previously images registered to respective input.
     */
    initImagesSaved() {
      var actualImages = this.$refs.actualImage as HTMLInputElement[];
      this.intValues.forEach((element, index) => {
        this.createFile(element, "image_" + index + ".png", "image/png").then(
          (file: File) => {
            const container = new DataTransfer();
            container.items.add(file);
            actualImages[index].files = container.files;
          }
        );
      });
    },
    /**
     * Create a file from a path.
     */
    async createFile(path: string, name: string, type: string): Promise<File> {
      let response = await fetch(
        window.location.protocol + "//" + window.location.host + "/" + path
      );
      let data = await response.blob();
      let metadata = {
        type: type,
      };
      return new File([data], name, metadata);
    },
    /**
     * Update Bootstrap tooltips.
     */
    updateBootstrapTooltip() {
      let newTooltipList = [].slice.call(
        document.querySelectorAll(
          ".images-input-" + this.intId + " [data-bs-tooltip=\"tooltip\"]"
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
    chooseAFile(n: number) {
      var actualImages = this.$refs.actualImage as HTMLInputElement[],
          actualImage = actualImages[n] as HTMLInputElement;
      actualImage.click();
    },
    /**
     * Link button change images to the input file images.
     */
    chooseFiles() {
      const actualImages = this.$refs.actualImages as HTMLInputElement;
      actualImages.click();
    },
    /**
     * Remove one specific image.
     */
    removeFile(n: number) {
      this.intValues.splice(n, 1);
      this.intHasImage.splice(n, 1);
      this.intHasModdedImage.splice(n, 1);
      this.intOriginalFile.splice(n, 1);
      this.intOriginalFileName.splice(n, 1);
      this.intOriginalFileDimensions.splice(n, 1);
      if (this.intValues.length <= 0) {
        this.intHasImages = false;
      }
      this.intInputImages = this.$refs.actualImage as HTMLInputElement[];
      this.intInputImages.forEach((element, index) => {
        if (this.intOriginalFile[index] != undefined) {
          var dt = new DataTransfer();
          dt.items.add(this.intOriginalFile[index]);
          element.files = dt.files;
        }
      });
      this.closeBootstrapTooltip();
    },
    /**
     * Remove all images.
     */
    removeFiles() {
      this.intValues.length = this.itemLimit[0];
      this.intHasImage.length = this.itemLimit[0];
      this.intHasModdedImage.length = this.itemLimit[0];
      this.intOriginalFile.length = this.itemLimit[0];
      this.intOriginalFileName.length = this.itemLimit[0];
      this.intOriginalFileDimensions.length = this.itemLimit[0];
      this.itemLimit[0] > 0
        ? (this.intHasImages = true)
        : (this.intHasImages = false);
      this.allErrors = {};
      this.closeBootstrapTooltip();
    },
    /**
     * Change one specific image.
     */
    changedImage(e: Event, n: number) {
      const reader = new FileReader();
      const el = e.target;
      if (!el || !(el instanceof HTMLInputElement)) {
        throw new Error(
          "confirmDoneJS can only be executed on an exising form"
        );
      }
      if (!el.files) {
        throw new Error();
      }
      this.intHasImage[n] = true;
      this.intHasModdedImage[n] = false;
      reader.addEventListener(
        "load",
        () => {
          // On convertit l'image en une chaîne de caractères base64.
          this.intValues[n] = String(reader.result);
        },
        false
      );
      if (el.files[0]) {
        this.intOriginalFile[n] = el.files[0];
        reader.readAsDataURL(el.files[0]);
        reader.onloadend = () =>
          this.fetchDataUrlImageSizes(String(reader.result), n);
      }
    },
    /**
     * Add images to exists image(s).
     */
    changedImages(e: Event) {
      const el = e.target;
      if (!el || !(el instanceof HTMLInputElement)) {
        throw new Error(
          "confirmDoneJS can only be executed on an exising form"
        );
      }
      if (!el.files) {
        throw new Error();
      }
      this.intLoopLoadImages = this.intValues.length;
      this.loadImages([].slice.call(el.files));
      this.intHasImages = true;
      if (this.intBtnCollapse?.classList.contains("collapsed")) {
        this.intBtnCollapse?.click();
      }
    },
    /**
     * Update inputs file.
     */
    loadImages(files: Array<File>) {
      if (files.length > 0) {
        if (this.intValues.length + files.length <= this.itemLimit[1]) {
          this.intOriginalFileDimensions.push({ width: 0, height: 0 });
          let actualFile = files.shift() as File;
          const reader = new FileReader();
          reader.readAsDataURL(actualFile);
          reader.onload = () => {
            // On convertit l'image en une chaîne de caractères base64.
            this.intValues.push(String(reader.result));
          };
          reader.onloadend = () => {
            this.fetchDataUrlImageSizes(
              String(reader.result),
              this.intLoopLoadImages
            );
            this.intInputImages = this.$refs.actualImage as HTMLInputElement[];
            var dt = new DataTransfer();
            dt.items.add(actualFile);
            this.intInputImages[this.intLoopLoadImages].files = dt.files;
            this.intOriginalFile[this.intLoopLoadImages] = actualFile;
            this.intHasImage[this.intValues.length - 1] = true;
            this.intLoopLoadImages++;
            this.loadImages(files);
          };
        }
      } else {
        this.updateBootstrapTooltip();
        this.intLoopLoadImages = this.intValues.length;
      }
    },
    /**
     * Update image source in the viewer.
     */
    viewImageSource(n: number) {
      const imgEditor = this.$refs.imgViewer as HTMLImageElement;
      this.intViewerLoadImage = true;
      setTimeout(() => {
        imgEditor.src = this.intValues[n];
        imgEditor.onload = () => {
          this.intViewerLoadImage = false;
        };
      }, 10);
    },
    /**
     * Remove image source in the viewer.
     */
    removeImageSource() {
      this.intViewerLoadImage = true;
      const imgEditor = this.$refs.imgViewer as HTMLImageElement;
      imgEditor.src = "";
    },
    /**
     * Set cropper to edit a specific image.
     */
    prepareImageEditor(n: number) {
      const imgEditor = this.$refs.imgEditor as HTMLImageElement,
            createCropper = () => {
              if (this.intCropper) {
                this.intCropper.destroy();
              }
              this.intCropper = new Cropper(imgEditor, this.cropperOption);
            };
      var actualImages = this.$refs.actualImage as HTMLInputElement[],
          actualImage = actualImages[n] as HTMLInputElement;
      this.intIdImage = n;
      if (!actualImage || !actualImage.files) {
        throw new Error("actualImage is not defined");
      }
      if (actualImage.files[0]) {
        this.intOriginalFile[n] = actualImage.files[0];
        this.intOriginalFileName[n] = actualImage.files[0].name;
        imgEditor.src = URL.createObjectURL(actualImage.files[0]);
      }

      this.previewStyleCompute();
      this.$nextTick(() => createCropper());
      return;
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
    fetchDataUrlImageSizes(dataUrl: string, n: number) {
      const img = new Image();
      try {
        img.onload = () => {
          this.intOriginalFileDimensions[n].width = img.width;
          this.intOriginalFileDimensions[n].height = img.height;
        };
        img.src = dataUrl;
      } catch (e) {
        this.intOriginalFileDimensions[n].width = img.width;
        this.intOriginalFileDimensions[n].height = img.height;
      }
    },
    /**
     * Set image after the edit in cropper.
     */
    exportToBlob() {
      const container = new DataTransfer();
      var actualImages = this.$refs.actualImage as HTMLInputElement[],
          actualImage = actualImages[this.intIdImage] as HTMLInputElement;
      if (!(this.intCropper instanceof Cropper)) {
        return;
      }
      if (!actualImage.files) {
        throw new Error();
      }
      this.intHasModdedImage[this.intIdImage] = true;
      this.intValues[this.intIdImage] = this.intCropper
        .getCroppedCanvas({
          fillColor: "rgba(0, 0, 0, 0)",
          width: this.intWidth,
          height: this.intHeight,
          imageSmoothingEnabled: true,
          imageSmoothingQuality: "high",
        })
        .toDataURL("image/png");
      this.fetchDataUrlImageSizes(
        this.intValues[this.intIdImage],
        this.intIdImage
      );
      const file = new File(
        [this.dataURLtoBlob("/" + this.intValues[this.intIdImage])],
        this.intOriginalFileName[this.intIdImage],
        {
          type: "image/png",
          lastModified: new Date().getTime(),
        }
      );
      this.intOriginalFile[this.intIdImage] = file;
      container.items.add(file);
      actualImage.files = container.files;
      this.$nextTick(() => {
        this.updateBootstrapTooltip();
      });
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
