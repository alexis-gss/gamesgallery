import type { SweetAlertResult } from "sweetalert2";
import sweetalert from "../../modules/sweetalert";
import * as trans from "../../modules/trans";

window.addEventListener("DOMContentLoaded", () => {
    /**
     * Popup action item.
     */
    const elementsAction = document.getElementsByClassName(
        "confirmActionTS"
    ) as HTMLCollectionOf<Element>;
    for (const element of elementsAction) {
        element.addEventListener("submit", function (e) {
            e.preventDefault();
            const el = e.target;
            if (!el || !(el instanceof HTMLFormElement)) {
                throw new Error(
                    "confirmDoneJS can only be executed on an exising form"
                );
            }
            sweetalert.methods.confirm(
                trans.default.methods.__("crud.sweetalert.are_you_sure"),
                el.getAttribute("data-message") ?? undefined,
                el,
                // eslint-disable-next-line @typescript-eslint/no-unused-vars
                function (response: SweetAlertResult<any>) {
                    el.submit();
                },
                { icon: "warning" }
            );
            return false;
        });
    }
});
