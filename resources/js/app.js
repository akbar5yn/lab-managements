import './bootstrap';
import './bootstrap';
import Swal from 'sweetalert2';
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Html5Qrcode } from "html5-qrcode";

function showAlert(title, text, icon) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: 'OK',
        didOpen: () => {
            const swalBody = document.querySelector('body.swal2-height-auto');
            if (swalBody) {
                swalBody.style.minHeight = '100vh';
                swalBody.style.maxHeight = '100vh';
                swalBody.style.overflowY = 'auto';
            }
        }
    });
}

document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah form dari pengiriman otomatis

        const formElement = this; // Menyimpan referensi ke form yang akan dihapus

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Ini akan menghapus kategori dan semua unit terkait!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tidak, batalkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                formElement.submit(); // Mengirim form jika pengguna mengkonfirmasi
            }
        });
    });
});

document.querySelectorAll('.delete-unit').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah form dari pengiriman otomatis

        const formElement = this; // Menyimpan referensi ke form yang akan dihapus

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Ini akan menghapus unit terkait!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tidak, batalkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                formElement.submit(); // Mengirim form jika pengguna mengkonfirmasi
            }
        });
    });
});

document.querySelectorAll('.delete-ruangan').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah form dari pengiriman otomatis

        const formElement = this; // Menyimpan referensi ke form yang akan dihapus

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Ini akan menghapus ruangan yang anda pilih!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tidak, batalkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                formElement.submit(); // Mengirim form jika pengguna mengkonfirmasi
            }
        });
    });
});

document.querySelectorAll('.update-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah form dari pengiriman otomatis

        const formElement = this; // Menyimpan referensi ke form yang akan dihapus

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Ini akan mengubah beberapa data yang telah anda isi",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Tidak, batalkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                formElement.submit(); // Mengirim form jika pengguna mengkonfirmasi
            }
        });
    });
});

document.querySelectorAll('.delete-transaksi').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah form dari pengiriman otomatis

        const formElement = this; // Menyimpan referensi ke form yang akan dihapus

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Ini akan membatalkan transaksi alat yang Anda buat!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Batalkan!',
            cancelButtonText: 'Tidak!',
            didOpen: () => {
                // Menyesuaikan body SweetAlert setelah elemen dirender ke DOM
                const swalBody = document.querySelector('body.swal2-height-auto');
                if (swalBody) {
                    swalBody.style.minHeight = '100vh';
                    swalBody.style.maxHeight = '100vh';
                    swalBody.style.overflowY = 'auto';
                }
            }
        }).then((result) => {
            // Mengirim form jika pengguna mengkonfirmasi
            if (result.isConfirmed) {
                formElement.submit();
            }
        });
    });
});



window.Html5Qrcode = Html5Qrcode;
window.showAlert = showAlert;