<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>

    <div class="mt-10 flex flex-col items-center">
        <h1 class="mb-4 text-xl font-bold">Scan QR Code</h1>

        <!-- Area Kamera -->
        <div id="reader" class="h-full w-full max-w-md rounded-lg border border-gray-300"></div>
        <label for="qr-upload" class="cursor-pointer rounded-lg bg-blue-500 px-4 py-2 text-white hover:bg-blue-600">
            Unggah dari Galeri
        </label>
        <input id="qr-upload" type="file" accept="image/*" class="hidden">
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const html5QrCode = new Html5Qrcode("reader");
            let isScanning = true;

            // Mulai scan kamera
            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 250
                },
                (decodedText, decodedResult) => {
                    if (isScanning) {
                        isScanning = false;

                        // Stop scanning kamera
                        html5QrCode.stop().then(() => {
                            console.log("QR scanning stopped.");
                        }).catch((err) => {
                            console.error("Stop scanning error:", err);
                        });

                        handleDecodedResult(decodedText);
                    }
                },
                (errorMessage) => {
                    console.warn(`Scan Error: ${errorMessage}`);
                }
            ).catch((err) => {
                console.error("Camera Error:", err);
            });

            // Fungsi untuk menangani hasil scan QR Code
            function handleDecodedResult(decodedText) {
                const url = new URL(decodedText);
                const pathParts = url.pathname.split('/');

                // Ambil key dari URL path
                const qrKey = pathParts[pathParts.length - 1];
                console.log('Decoded QR URL:', decodedText); // Cek URL hasil scan
                console.log('QR Key:', qrKey);

                if (!qrKey) {
                    console.error('QR Key tidak ditemukan dalam URL!');
                    alert("QR Code tidak valid. Silakan coba lagi.");
                    return;
                }

                // Gunakan Axios untuk request ke endpoint
                axios.get(`/mahasiswa/update-scan-status/${qrKey}`)
                    .then(response => {
                        if (response.data.success) {
                            // Redirect ke halaman transaksi setelah status diperbarui
                            window.location.href = decodedText;
                        } else {
                            console.log(response.data);
                            showAlert(
                                "Kesalahan",
                                "QR Code tidak valid atau sudah kedaluwarsa. Mohon untuk hubungi laboran",
                                "error"
                            );
                        }
                    })
                    .catch(error => {
                        console.error("Error updating QR scan status:", error);
                        alert("Terjadi kesalahan. Silakan coba lagi.");
                    });
            }

            // Scan QR Code melalui file
            const fileInput = document.getElementById("qr-upload");
            fileInput.addEventListener("change", (event) => {
                const file = event.target.files[0];
                if (!file) {
                    alert("Tidak ada file yang dipilih.");
                    return;
                }

                // Hentikan kamera sebelum scan file
                html5QrCode.stop().then(() => {
                    console.log("Camera scan stopped. Starting file scan...");

                    // Mulai proses scan file
                    html5QrCode.scanFile(file, true)
                        .then((decodedText) => {
                            console.log("Decoded text from file:", decodedText);
                            handleDecodedResult(decodedText); // Arahkan ke fungsi yang sama
                        })
                        .catch((error) => {
                            console.error("Error scanning file:", error);
                            alert("Gagal memindai gambar. Pastikan file mengandung QR Code.");
                        });
                }).catch((err) => {
                    console.error("Error stopping camera scan:", err);
                });
            });
        });
    </script>


</x-layout>
