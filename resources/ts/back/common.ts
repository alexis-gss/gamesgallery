import { SweetAlertIcon, SweetAlertResult } from "sweetalert2";
import sweetalert from "../modules/sweetalert";

window.addEventListener("DOMContentLoaded", () => {
    /**
     * Popup delete item.
     */
    let elements = document.getElementsByClassName(
        "confirmDeleteTS"
    ) as HTMLCollectionOf<Element>;
    for (const element of elements) {
        element.addEventListener("submit", function (e) {
            e.preventDefault();
            const el = e.target;
            if (!el || !(el instanceof HTMLFormElement)) {
                throw new Error(
                    "confirmDoneJS can only be executed on an exising form"
                );
            }
            sweetalert.methods.confirm(
                "Are you sure ?",
                "All data will be lost.",
                el as HTMLFormElement,
                // eslint-disable-next-line @typescript-eslint/no-unused-vars
                function (response: SweetAlertResult<any>) {
                    (el as HTMLFormElement).submit();
                },
                { icon: "warning" }
            );
            return false;
        });
    }
    /**
     * Popup confim.
     */
    elements = document.getElementsByClassName(
        "confirmJS"
    ) as HTMLCollectionOf<Element>;
    for (const element of elements) {
        if (!element.getAttribute("confirmJS")) {
            const el = element;
            if (!el || !(el instanceof HTMLElement)) {
                throw new Error(
                    "confirmJS can only be executed on a html element"
                );
            }
            (async () => {
                const promise = new Promise(
                    // eslint-disable-next-line @typescript-eslint/no-unused-vars
                    (resolve: (value: boolean) => void, reject) => {
                        sweetalert.methods.message(el.dataset.value, el, {
                            icon: el.dataset.icon as SweetAlertIcon,
                        });
                        return false;
                    }
                );
                if (await promise) {
                    element.setAttribute("confirmJS", "true");
                    el.click();
                    element.removeAttribute("confirmJS");
                }
            })();
        }
    }
    /**
     * Show/hide password.
     */
    elements = document.getElementsByClassName(
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
