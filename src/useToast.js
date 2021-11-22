import Swal from "sweetalert2";

export default (message, type = 'success') => {
    Swal.fire({
        toast: true,
        position: "top-end",
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: 2000,
    });
}
