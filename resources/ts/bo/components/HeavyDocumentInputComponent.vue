<template>
  <div
    :class="`image-heavy-input image-heavy-input-${intId} row w-100 mx-auto`"
  >
    <!-- CHOOSE FILE -->
    <div
      class="col-12 pe-3"
      :class="!intSimpleComponent ? 'col-md-6 mb-3' : ''"
    >
      <label
        v-if="!intSimpleComponent"
        for="documentInputFile"
        class="col-form-label"
      >
        <b>{{ __("bo_label_choose_picture") }} *</b>
      </label>
      <div :class="intIsUploading ? 'd-none' : ''">
        <div class="input-group">
          <button
            @click.prevent="chooseFile"
            class="btn btn-sm btn-secondary"
            type="button"
            data-bs-tooltip="tooltip"
            :title="__('bo_tooltip_image_input_modify_source')"
          >
            <FontAwesomeIcon icon="fa-solid fa-folder-open" />
          </button>
          <input
            type="text"
            class="form-control form-control-sm"
            role="button"
            ref="inputFile"
            :value="
              intDocument?.label
                ? intDocument?.label
                : __('bo_label_choose_picture')
            "
            data-bs-tooltip="tooltip"
            :title="__('bo_tooltip_image_input_modify_source')"
            readonly
          >
          <button
            v-if="intDocumentLoaded"
            class="btn btn-sm btn-success"
            type="button"
            :title="__('bo_tooltip_image_input_saved')"
            data-bs-tooltip="tooltip"
          >
            <FontAwesomeIcon icon="fa-solid fa-check" />
          </button>
          <button
            @click.prevent="viewImageSource()"
            class="btn btn-sm btn-warning"
            type="button"
            data-bs-toggle="modal"
            :data-bs-target="`#modalViewer${intId}`"
            :title="__('bo_tooltip_image_input_preview_image')"
            data-bs-tooltip="tooltip"
          >
            <FontAwesomeIcon icon="fa-solid fa-eye" />
          </button>
        </div>
        <Transition name="fade">
          <p
            v-if="intMessage"
            class="m-0 text-danger"
          >
            {{ intMessage }}
          </p>
        </Transition>
      </div>
      <div
        class="progress w-100 my-1"
        :class="!intIsUploading ? 'd-none' : ''"
      >
        <div
          class="progress-bar progress-bar-striped progress-bar-animated"
          ref="progressBar"
          role="progressbar"
          aria-label="Progress bar"
          aria-valuenow="0"
          aria-valuemin="0"
          aria-valuemax="100"
        >
          {{ intFilePercent }}%
        </div>
      </div>
      <small
        v-if="!intSimpleComponent"
        class="form-text text-body-secondary"
      >
        {{ intHelper }}
      </small>
    </div>
    <input
      class="d-none"
      :id="'inputUuid-' + intId"
      name="uuid[]"
    >
    <input
      class="d-none"
      :id="'inputLabel-' + intId"
      name="label[]"
    >
  </div>
  <!-- VIEWER MODAL -->
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
            {{ __("bo_label_preview_image") }}
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            :aria-label="__('bo_tooltip_image_input_close')"
            :title="__('bo_tooltip_image_input_close')"
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
                {{ __("bo_tooltip_image_input_viewer_loading") }}
              </span>
            </div>
          </div>
          <img
            class="mw-100 mh-100"
            :class="intViewerLoadImage ? 'd-none' : ''"
            ref="imgViewer"
            src=""
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { Tooltip } from "bootstrap";
import Resumable from "resumablejs";
import type { PropType } from "vue";
import { defineComponent } from "vue";
import route from "./../../modules/route";
import trans from "./../../modules/trans";

export default defineComponent({
  name: "HeavyDocumentInputComponent",
  mixins: [route, trans],
  components: {
    FontAwesomeIcon,
  },
  props: {
    id: {
      type: String,
      default: "",
    },
    file: {
      type: Object as PropType<ChunkFile>,
      default: null,
    },
    filetype: {
      type: Array<string>,
      default: null,
    },
    csrf: {
      type: String,
      default: "",
    },
    helper: {
      type: String,
      default: "",
    },
    gameslug: {
      type: String,
      default: "",
    },
    simplecomponent: {
      type: Boolean,
      default: false,
    },
  },
  data(): {
    intId: string;
    intMessage: string | null;
    intSuccess: boolean;
    intIsUploading: boolean;
    intFilePercent: number | null;
    intProgressbar: HTMLDivElement | null;
    intR: ResumableJS | null;
    intDocument: ChunkFile | null;
    intCsrf: string;
    intHelper: string;
    intGameSlug: string;
    intSimpleComponent: boolean;
    intViewerLoadImage: boolean;
    intTooltipList: HTMLButtonElement[];
    intDocumentLoaded: boolean;
    intInputUuid: HTMLInputElement | null;
    intInputLabel: HTMLInputElement | null;
  } {
    return {
      intId: "",
      intR: null,
      intMessage: null,
      intSuccess: false,
      intIsUploading: false,
      intFilePercent: 0,
      intProgressbar: null,
      intDocument: null,
      intCsrf: "",
      intHelper: "",
      intGameSlug: "",
      intSimpleComponent: false,
      intViewerLoadImage: false,
      intTooltipList: [],
      intDocumentLoaded: false,
      intInputUuid: null,
      intInputLabel: null,
    };
  },
  mounted() {
    const json = String(this.$attrs.json ?? "{}"),
          data = JSON.parse(json);
    this.intId = this.id ?? data.id;
    this.intCsrf = this.csrf ?? data.csrf;
    this.intHelper = this.helper ?? data.helper;
    this.intGameSlug = this.gameslug ?? data.gameslug;
    this.intSimpleComponent = this.simplecomponent ?? data.simplecomponent;
    this.initResumable();
    if (this.file !== null) {
      if (!this.file.published) {
        this.intR?.addFile(this.file as unknown as File);
        this.intR?.upload();
      } else {
        this.intDocument = this.file;
        setTimeout(() => this.editImageAttribute(), 100);
      }
    }
    this.$nextTick(() => {
      this.getInputsAttribute();
      this.updateBootstrapTooltip();
    });
  },
  methods: {
    /**
     * Init Resumable.
     */
    initResumable() {
      this.intR = new Resumable({
        chunkSize: 1024 * 1024, // 1MB
        simultaneousUploads: 5,
        maxFiles: 75,
        testChunks: false,
        target: this.getUploadDocumentRoute(),
        query: {
          gameSlug: this.intGameSlug,
          _token: this.intCsrf,
        },
      });
      this.intR.on("fileAdded", this.fileAdded);
      this.intR.on("fileSuccess", this.fileSuccess);
      this.intR.on("fileError", this.fileError);
      this.intR.on("fileProgress", () => {
        if (this.intR !== null) {
          this.intFilePercent = Math.floor(this.intR.progress() * 100);
          if (this.intProgressbar !== null)
            this.intProgressbar.style.width = this.intFilePercent + "%";
        }
      });
      this.intR?.assignBrowse(this.$refs.inputFile as Element, false);
    },
    /**
     * Change the document source.
     */
    chooseFile() {
      const inputFile = this.$refs.inputFile as HTMLInputElement;
      inputFile.click();
    },
    /**
     * Get upload heavy document route.
     */
    getUploadDocumentRoute() {
      const uploadDocumentRoute = route.methods.route("bo.games.upload");
      if (!uploadDocumentRoute) {
        throw new Error("Undefined route bo.games.upload");
      }
      return uploadDocumentRoute;
    },
    /**
     * Add file who will be store.
     * @param file The file would like to store.
     */
    fileAdded() {
      this.intDocumentLoaded = false;
      this.intIsUploading = true;
      setTimeout(() => {
        this.intProgressbar = this.$refs.progressBar as HTMLDivElement;
        this.intProgressbar.style.width = this.intFilePercent + "%";
      }, 10);
      this.closeBootstrapTooltip();
      if (this.intR !== null) this.intR.upload();
    },
    /**
     * Run method if the file is stored.
     * @param file The file stored.
     * @param message Set a new successful message.
     */
    fileSuccess(file: { file: File }, message: string) {
      let result = JSON.parse(message);
      this.intDocument = file.file as unknown as ChunkFile;
      this.intDocument.uuid = result.uid;
      this.intDocument.label = file.file.name;
      this.intSuccess = true;
      this.intDocumentLoaded = true;
      const intInputFileResult = this.$refs.progressBar as HTMLInputElement;
      intInputFileResult.value = String(0 + "%");
      setTimeout(() => {
        this.intIsUploading = false;
        this.$nextTick(() => {
          this.editImageAttribute();
          this.updateBootstrapTooltip();
        });
      }, 800);
    },
    /**
     * Set a new error message.
     */
    fileError() {
      this.intMessage = "Une erreur est survenue, veuillez recharger la page.";
    },
    /**
     * View document source in the modal.
     */
    viewImageSource() {
      const imgEditor = this.$refs.imgViewer as HTMLImageElement;
      this.intViewerLoadImage = true;
      setTimeout(() => {
        imgEditor.src =
          "/storage/pictures/" +
          this.intGameSlug +
          "/" +
          this.intDocument?.uuid +
          "." +
          this.intDocument?.label.split(".")[
            this.intDocument?.label.split(".").length - 1
          ];
        imgEditor.onload = () => {
          this.intViewerLoadImage = false;
        };
      }, 10);
    },
    getInputsAttribute() {
      this.intInputUuid = document.getElementById(
        "inputUuid-" + this.intId
      ) as HTMLInputElement;
      this.intInputLabel = document.getElementById(
        "inputLabel-" + this.intId
      ) as HTMLInputElement;
    },
    /**
     * Edit document data.
     */
    editImageAttribute() {
      if (this.intInputUuid != null && this.intInputLabel != null) {
        this.intInputUuid.value = this.intDocument?.uuid ?? "";
        this.intInputLabel.value = this.intDocument?.label ?? "";
      }
    },
    /**
     * Update Bootstrap tooltips.
     */
    updateBootstrapTooltip() {
      let newTooltipList = [].slice.call(
        document.querySelectorAll(
          ".image-heavy-input-" + this.intId + " [data-bs-tooltip=\"tooltip\"]"
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
