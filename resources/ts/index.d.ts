export {};

import { AxiosStatic } from "axios";

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
declare global {
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
