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
    /**
     * Show/hide password.
     */
    const elements = document.getElementsByClassName(
        "password-btn"
    ) as HTMLCollectionOf<Element>;
    const inputPassword = document.getElementsByClassName(
        "password-input"
    ) as HTMLCollectionOf<HTMLInputElement>;
    for (let i = 0; i < elements.length; i++) {
        elements[i].addEventListener("click", function () {
            for (const item of elements[i].children) {
                item.classList.toggle("d-none");
            }
            if (inputPassword[i].type === "password") {
                inputPassword[i].type = "text";
            } else {
                inputPassword[i].type = "password";
            }
        });
    }
});
