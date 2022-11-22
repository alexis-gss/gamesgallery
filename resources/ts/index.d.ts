export {};

import { AxiosStatic } from "axios";
import type VueTagsInput from "@sipec/vue3-tags-input";

// * Recursive List<string>
type StringList = Record<PropertyKey, string>;
interface NestedStringListInterface
    extends Record<PropertyKey, NestedStringListInterface | StringList> {}

// * Recursive List<number>
type NumberList = Record<PropertyKey, number>;
interface NestedNumberListInterface
    extends Record<PropertyKey, NestedNumberListInterface | NumberList> {}

// * Recursive List<Model>
type Model = Record<
    string,
    | string
    | number
    | object
    | NestedStringList
    | NestedNumberList
    | NestedModelInterface
>;
interface NestedModelInterface extends Model {}

type NestedStringList = NestedStringListInterface | StringList | string;
type NestedNumberList = NestedNumberListInterface | NumberList | number;
type ModelList = Array<Model>;

declare global {
    type CustomTag = LaravelModel & VueTagsInput.ITag;
    type LaravelModel = Model;
    type LaravelModelList = ModelList;

    interface Window {
        axios: AxiosStatic;
        Swal: Function;
        __SYSTEM: {
            _locale: string;
            _routes: Record<string, string>;
            _translations: {
                json: NestedStringList;
                php: NestedStringList;
            };
        };
    }
}
