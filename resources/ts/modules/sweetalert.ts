// SweetAlert
import Swal, { SweetAlertOptions, SweetAlertResult } from "sweetalert2";
import * as trans from "../modules/trans";

export default {
    methods: {
        confirm(
            title: string,
            text = "",
            self: Object,
            after: (response: SweetAlertResult<any>) => void = (
                // eslint-disable-next-line @typescript-eslint/no-unused-vars
                response: SweetAlertResult<any>
            ) => {},
            options: SweetAlertOptions = {}
        ) {
            if (!self) {
                throw Error("Self is needed to set \"this\" on callback");
            }
            if (!after) {
                throw Error("Callback is needed when using confirm");
            }
            const icon = options.icon ?? "warning";
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonText: trans.default.methods.__("crud.sweetalert.confirm"),
                cancelButtonText: trans.default.methods.__("crud.sweetalert.cancel"),
                showCloseButton: true,
                allowEscapeKey: true,
                // * Bootstrap Styling
                customClass: {
                    confirmButton: "btn btn-primary mx-1",
                    cancelButton: "btn btn-danger mx-1",
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    if (after) {
                        after.apply(self, [result]);
                    }
                }
            });
            return false;
        },
        message(title = "", self: Object, options: SweetAlertOptions = {}) {
            if (!self) {
                throw Error("Self is needed to set \"this\" on callback");
            }
            const icon = options.icon ?? "warning";
            Swal.fire({
                title: title,
                icon: icon,
                toast: true,
                width: "fit-content",
                position: "bottom-start",
                showConfirmButton: false,
                showCloseButton: true,
                timer: 8000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });
            return false;
        },
    },
};
