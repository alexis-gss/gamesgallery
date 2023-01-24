export default {
    methods: {
        /**
         * Parse error messages for a specific input.
         *
         * @param inputName string
         * @param allErrors Record<string, Array<string>>
         * @return string
         */
        parseValidationInput(
            inputName: string,
            allErrors: Record<string, Array<string>> = {}
        ): string | null {
            let errorList = [] as Array<string>;
            Object.keys(allErrors).filter((value) => {
                if (value == inputName) {
                    errorList = allErrors[value];
                }
            });
            return errorList.length
                ? errorList.reduce((oldString: string | null, string) => {
                    return (oldString ? `${oldString}, ` : "") + string;
                })
                : null;
        },
    },
};
