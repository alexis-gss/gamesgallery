export {};

import { AxiosStatic } from "axios";
import type VueTagsInput from "@sipec/vue3-tags-input";

declare global {
    type CustomTag = VueTagsInput.ITag;

    interface Window {
        axios: AxiosStatic;
        Swal: Function;
        __SYSTEM: {
            _routes: Record<string, string>;
        };
    }
}
