declare module "@sipec/vue3-tags-input" {
    export namespace VueTagsInput {
        export interface ITag {
            text: string;
            tiClasses: string[];
        }

        export interface IAddArgs {
            tag: ITag;
            addTag(): void;
        }

        export interface IDeleteArgs {
            index: number;
            tag: ITag;
            deleteTag(): void;
        }

        export interface IValidation {
            classes: string;
            rule: (text: string) => boolean | RegExp;
            disableAdd?: boolean;
        }
    }

    export class VueTagsInput {
        public get disabled(): boolean;
        public get maxlength(): number;
        public get placeholder(): string;
        public get separators(): string[];
        public get tags(): VueTagsInput.ITag[];
        public get validation(): VueTagsInput.IValidation[];

        public isSelected(index: number): boolean;
        public isMarked(index: number): boolean;
        public focus(index: number): void;
        public quote(regex: string): void;
        public cancelEdit(index: number): void;
        public createTagTexts(string: string): VueTagsInput.ITag[];
        public deleteTag(index: number): void;
        public beforeAddingTag(tag: VueTagsInput.ITag): void;
        public addTag(tag: VueTagsInput.ITag, source?: string): void;
        public saveTag(index: number, tag: VueTagsInput.ITag): void;
        public tagsChanged(tags: Array<VueTagsInput.ITag>): void;
        public initTags(): void;
    }

    export default VueTagsInput;
}
