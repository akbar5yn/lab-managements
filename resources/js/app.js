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

window.showAlert = showAlert;