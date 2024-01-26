export { };

import type VueTagsInput from "@sipec/vue3-tags-input";
import { AxiosStatic } from "axios";
import * as echarts from "echarts";
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
interface NestedModelInterface extends Model { }

type RankObj = {
    id: number;
    rank: number;
    game_id: number;
    game_name: string,
    game_slug: string,
    created_at: Date;
    updated_at: Date;
};

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
    type RankObject = RankObj;

    interface Window {
        axios: AxiosStatic;
        Echarts: typeof echarts;
        Swal: Function;
        vueDebug: boolean | undefined;
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
