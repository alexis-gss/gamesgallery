import type { UserDefinedSafelist } from "purgecss";

const sassSafelist: UserDefinedSafelist = [
    // Bootstrap
    /^cropper-/, /^offcanvas-/, /^tooltip/, /^bs-tooltip/, /^data-popper/, /.*\[data-popper-placement].*/,
    /^bs-popover/, /^popover/, /^modal-/, /^bg-*/, /^collapsing/, /^showing/, /^col-.*/, /^data-bs-.*/,
    // Vue
    /-(leave|enter|appear)(|-(to|from|active))$/, /^(?!(|.*?:)cursor-move).+-move$/, /^router-link(|-exact)-active$/, /data-v-.*/,
    // Other libraries
    /^aos-.*/, /^simplebar-.*/, /^g.*/
];
export { sassSafelist };
