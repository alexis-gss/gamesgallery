export {};

import { AxiosStatic } from "axios";
import * as echarts from "echarts";
import type VueTagsInput from "@sipec/vue3-tags-input";
import type Resumable from "resumablejs";

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
    | boolean
    | object
    | NestedStringList
    | NestedNumberList
    | NestedModelInterface
>;
interface NestedModelInterface extends Model {}

type NestedStringList = NestedStringListInterface | StringList | string;
type NestedNumberList = NestedNumberListInterface | NumberList | number;
type ModelList = Array<Model>;

interface UploadFile extends Blob {
    readonly lastModified: number;
    readonly webkitRelativePath: string;
    uuid: string;
    label: string;
    published: boolean;
    uniqueIdentifier: string;
}

declare global {
    type CustomTag = LaravelModel & VueTagsInput.ITag;
    type LaravelModel = Model;
    type LaravelModelList = ModelList;
    type ResumableJS = Resumable;
    type ChunkFile = UploadFile;

    interface Window {
        axios: AxiosStatic;
        Echarts: typeof echarts;
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
