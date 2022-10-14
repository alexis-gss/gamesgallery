import { SweetAlertIcon, SweetAlertResult } from "sweetalert2";
import sweetalert from "../modules/sweetalert";

window.addEventListener("DOMContentLoaded", () => {
    let elements = document.getElementsByClassName("confirmDeleteTS");
    for (const element of elements) {
        element.addEventListener("submit", function (e) {
            e.preventDefault();
            const el = e.target;
            if (!el || !(el instanceof HTMLFormElement)) {
                throw new Error(
                    "confirmDoneJS can only be executed on an exising form"
                );
            }
            console.log(el);
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
    elements = document.getElementsByClassName("confirmJS");
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
});
