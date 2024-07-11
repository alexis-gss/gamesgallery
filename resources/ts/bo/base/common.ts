import type { SweetAlertResult } from "sweetalert2";
import sweetalert from "../../modules/sweetalert";

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
                el,
                // eslint-disable-next-line @typescript-eslint/no-unused-vars
                function (response: SweetAlertResult<any>) {
                    el.submit();
                },
                { icon: "warning" },
                el.getAttribute("data-sweetalert-title") ?? undefined,
                el.getAttribute("data-sweetalert-message") ?? undefined,
                el.getAttribute("data-sweetalert-btn-accept") ?? undefined,
                el.getAttribute("data-sweetalert-btn-deny") ?? undefined,
                el.getAttribute("data-sweetalert-btn-color") ?? undefined,
            );
            return false;
        });
    }
});
