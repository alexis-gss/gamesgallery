import Swal from 'sweetalert2';

window.popupDelete = function(e, title, message, confirm) {
    e.preventDefault();
    Swal.fire({
        icon: 'warning',
        title: title,
        html: message,
        showCancelButton: true,
        showCloseButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: confirm,
        closeOnConfirm: false,
        allowEscapeKey: true,
    }).then((result) => {
        if (result.isConfirmed) {
            e.target.submit();
        }
    });
};

window.popupMessage = function(type, message) {
    Swal.fire({
        icon: type,
        title: message,
        toast: true,
        position: 'center',
        timer: 3000,
        showConfirmButton: false,
        timerProgressBar: true,
        showCloseButton: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
};