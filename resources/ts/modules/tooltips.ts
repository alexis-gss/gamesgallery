import { Tooltip } from "bootstrap";

type ConstructorTypeParent = "parent";
type ConstructorTypeDom = "dom";

interface ParentSelectorTooltips {
    type: ConstructorTypeParent
    /** The parent element that contains Dom elements for which tooltips shall be created. */
    parentSelector: string;
}

interface DomProvidedTooltips {
    type: ConstructorTypeDom;
    /** Dom elements for which tooltips shall be created. */
    elements: HTMLElement | NodeListOf<HTMLElement>;
}

interface TooltipsOptions {
    /** Tooltip options. */
    options?: Partial<Tooltip.Options>|null|undefined;
}

export type TooltipsConstructor = TooltipsOptions & (ParentSelectorTooltips|DomProvidedTooltips);

export class Tooltips {
    /** BS tooltips instances */
    private tooltips: Array<Tooltip> = [];

    /** The parent element that contains Dom elements for which tooltips shall be created. */
    private parentSelector: string | null = null;

    /** Dom elements for which tooltips shall be created. */
    private elements: Array<HTMLElement> = [];

    /** Tooltip default options. */
    private static defaultOptions: Partial<Tooltip.Options> = {
        delay: {
            show: 1250,
            hide: 0,
        },
    };

    /** Tooltip options. */
    private options: Partial<Tooltip.Options> = {};

    /**
     * @param parentSelector
     * @param options        Tooltip options.
     */
    constructor(params: TooltipsConstructor) {
        if (params.type === "parent") {
            this.parentSelectorConstructor(params);
        }
        if (params.type === "dom") {
            this.domPrividedTooltipsContructor(params);
        }
    }

    public static make(params: TooltipsConstructor = { type: "parent", parentSelector: "body"}
    ) {
        const fullParams = { ...{ type: "parent", options: {} }, ...params };
        return new Tooltips(fullParams);
    }

    private parentSelectorConstructor({ parentSelector, options }: TooltipsOptions & ParentSelectorTooltips) {
        this.parentSelector = parentSelector;
        this.options = { ...Tooltips.defaultOptions, ...options };
        this.initTooltips();
    }

    private domPrividedTooltipsContructor({ elements, options }: TooltipsOptions & DomProvidedTooltips) {
        if (elements instanceof HTMLElement) {
            this.elements = [elements];
        } else {
            this.elements = Array.from(elements);
        }
        this.options = { ...Tooltips.defaultOptions, ...options };
        this.initTooltips();
    }

    /**
     * Close all Bootstrap tooltips and reinstanciate them.
     */
    public refreshTooltips(): void {
        this.closeBootstrapTooltip();
        this.initTooltips();
    }

    /**
     * Close all Bootstrap tooltips for ever.
     */
    public closeBootstrapTooltip(): void {
        this.tooltips.forEach((tooltip) => {
            tooltip.hide();
            // * Prevent pending tooltips beeing shown after we asked to hide them
            tooltip.disable();
        });
    }

    /**
     * Initialize tooltips
     */
    private initTooltips() {
        this.closeBootstrapTooltip();
        /** data-bs-toggle tooltips elements */
        const elements = this.parentSelector ? [].slice
            .call(document.querySelectorAll(`${this.parentSelector} [data-bs-tooltip="tooltip"]`)) :
            this.elements;
        this.tooltips = elements.map((tooltipTriggerEl) => {
            return new Tooltip(tooltipTriggerEl, this.options);
        });
    }
}
