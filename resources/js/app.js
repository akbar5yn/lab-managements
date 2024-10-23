import './bootstrap';
import './bootstrap';
import Swal from 'sweetalert2';

function showAlert(title, text, icon) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: 'OK',
    });
}

window.showAlert = showAlert;