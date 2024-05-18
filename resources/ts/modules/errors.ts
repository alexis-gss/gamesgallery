export default {
    methods: {
        /**
         * Parse error messages for a specific input.
         *
         * @param inputName string
         * @param allErrors Record<string, Array<string>>
         * @return string
         */
        parseValidationErrors(
            allErrors: Record<string, Array<string>> = {}
        ): string | null {
            const errorList = Object.values(allErrors);
            if (!errorList.length) {
                return null;
            }
            return errorList
                .reduce((oldInputErrors: Array<string> | null, inputErrors) =>
                    oldInputErrors
                        ? oldInputErrors.concat(inputErrors)
                        : inputErrors
                )
                .reduce(
                    (oldInputString: string | null, inputString: string) =>
                        (oldInputString ? `${oldInputString}, ` : "") +
                        inputString
                );
        },
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
            Object.keys(allErrors).filter((value, index) => {
                if (value == inputName) {
                    errorList = allErrors[index];
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
