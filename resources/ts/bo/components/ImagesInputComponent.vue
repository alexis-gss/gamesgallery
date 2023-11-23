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
            :title="__('bo_tooltip_image_input_modify_sources')"
            data-bs-tooltip="tooltip"
            :disabled="intValues.length >= itemLimit[1]"
          >
            <FontAwesomeIcon icon="fa-solid fa-folder-open" />
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
              __('bo_other_number_images', {
                number: intValues.length + '/' + itemLimit[1],
              })
            "
            class="form-control right-aligned"
            :title="__('bo_tooltip_image_input_modify_sources')"
            data-bs-tooltip="tooltip"
            :aria-describedby="`Help${intId}`"
            :disabled="intValues.length >= itemLimit[1]"
            readonly
          >
          <button
            class="btn btn-primary btn-collapse collapsed"
            type="button"
            :title="__('bo_tooltip_image_input_show_hide_content')"
            data-bs-tooltip="tooltip"
            data-bs-toggle="collapse"
            data-bs-target="#multiple-images"
            aria-expanded="false"
            aria-controls="multiple-images"
            :disabled="!intHasImages"
          >
            <FontAwesomeIcon icon="fa-solid fa-arrow-down" />
          </button>
          <button
            v-if="intValues.length > itemLimit[0]"
            @click.prevent="removeFiles"
            class="btn btn-danger"
            type="button"
            :title="__('bo_tooltip_image_input_remove_images')"
            data-bs-tooltip="tooltip"
            :disabled="intValues.length <= 0"
          >
            <FontAwesomeIcon icon="fa-solid fa-eraser" />
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
      <div class="row w-100 mx-auto mb-2 py-1">
        <div
          v-for="n = 0 in intValues.length"
          :key="n"
          class="col-12 form-group text-center px-1"
        >
          <div class="d-flex justify-content-between align-items-center py-1">
            <HeavyDocumentInputComponent
              :id="intValues[n - 1].uniqueIdentifier"
              :file="intValues[n - 1]"
              :gameslug="intModel?.slug ?? 'default_folder'"
              :csrf="intCsrf"
              :simplecomponent="true"
            />
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
      </div>
      <!-- End content collapse -->
    </div>
    <Transition name="fade">
      <p
        v-if="intMessage"
        class="m-0 text-danger"
      >
        {{ intMessage }}
      </p>
    </Transition>
    <small
      :id="`Help${intId}`"
      class="form-text text-body-secondary"
    >
      {{ intHelper }}
    </small>
  </div>
</template>

<script lang="ts">
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { Tooltip } from "bootstrap";
import { defineComponent } from "vue";
import error from "./../../modules/error";
import trans from "./../../modules/trans";
import HeavyDocumentInputComponent from "./HeavyDocumentInputComponent.vue";

export default defineComponent({
  name: "ImagesInputComponent",
  mixins: [error, trans],
  components: {
    FontAwesomeIcon,
    HeavyDocumentInputComponent,
  },
  data(): {
    intId: string;
    intModel: LaravelModel | null;
    intName: string;
    intIdImage: number;
    intHasImages: boolean;
    intValues: ChunkFile[];
    intHelper: string;
    intTooltipList: HTMLButtonElement[];
    intBtnCollapse: HTMLButtonElement | null;
    intLoopLoadImages: number;
    intViewerLoadImage: boolean;
    intInputImages: HTMLInputElement | null;
    itemLimit: number[];
    intCsrf: string;
    intMessage: string | null;
    allErrors: Record<string, string[]>;
  } {
    return {
      intId: "",
      intModel: null,
      intName: "",
      intIdImage: 0,
      intHasImages: false,
      intValues: [],
      intHelper: "",
      intBtnCollapse: null,
      intTooltipList: [],
      intLoopLoadImages: 0,
      intViewerLoadImage: false,
      intInputImages: null,
      itemLimit: [0, 0],
      intCsrf: "",
      intMessage: null,
      allErrors: {},
    };
  },
  mounted() {
    const json = String(this.$attrs.json ?? "");
    const data = JSON.parse(json);
    this.intId = data.id;
    this.intModel = data.model;
    this.intName = data.name;
    if (data.value.length > 0) {
      this.initImagesSaved(data.value);
    }
    this.intHelper = data.helper ?? "";
    this.itemLimit = data.limit;
    this.intCsrf = data.csrf;
    this.allErrors = data.errors ?? {};
    this.$nextTick(() => {
      this.initComponent();
      this.updateBootstrapTooltip();
    });
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
        this.intHasImages = true;
      } else {
        this.intHasImages = false;
      }
    },
    /**
     * Assign previously images registered to respective input.
     */
    initImagesSaved(models: LaravelModelList) {
      models.forEach((model: LaravelModel, modelIndex: number) => {
        let oldValue = {} as ChunkFile;
        oldValue.uuid = model.uuid as string;
        oldValue.label = model.label as string;
        oldValue.published = model.published ? true : (false as boolean);
        oldValue.uniqueIdentifier = (String(modelIndex) +
          "-" +
          Date.now()) as string;
        this.intValues.push(oldValue);
      });
    },
    /**
     * Link button change images to the input file images.
     */
    chooseFiles() {
      const actualImages = this.$refs.actualImages as HTMLInputElement;
      actualImages.click();
    },
    /**
     * Remove all images.
     */
    removeFiles() {
      this.intValues.length = this.itemLimit[0];
      this.itemLimit[0] > 0
        ? (this.intHasImages = true)
        : (this.intHasImages = false);
      this.allErrors = {};
      this.closeBootstrapTooltip();
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
          let actualFile = files.shift() as unknown as ChunkFile;
          actualFile.published = false;
          actualFile.uniqueIdentifier =
            String(this.intLoopLoadImages) + "-" + Date.now();
          this.intValues.push(actualFile);
          this.intInputImages = this.$refs.actualImages as HTMLInputElement;
          var dt = new DataTransfer();
          dt.items.add(actualFile as unknown as File);
          this.intInputImages.files = dt.files;
          this.intLoopLoadImages++;
          setTimeout(() => {
            this.loadImages(files);
          }, 200);
        } else {
          this.setErrorMessage("Pictures download limit exceeded");
        }
      } else {
        this.updateBootstrapTooltip();
        this.intLoopLoadImages = this.intValues.length;
      }
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
     * Remove image source in the viewer.
     */
    setErrorMessage($message: string) {
      this.intMessage = $message;
      setTimeout(() => {
        this.intMessage = null;
      }, 5000);
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
  },
});
</script>
