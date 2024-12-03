<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:subtitle>{{ $subtitle }}</x-slot:subtitle>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>

    <main class="relative flex h-full w-full gap-4">
        @if (Session::has('success'))
            <script>
                window.onload = function() {
                    showAlert("Peminjaman berhasil di buat", "{{ Session::get('success') }}", "success");
                };
            </script>
        @endif

        @if (Session::has('error'))
            <script>
                window.onload = function() {
                    showAlert("Error", "{{ Session::get('error') }}", "error");
                };
            </script>
        @endif

        @if (Session::has('warning'))
            <script>
                window.onload = function() {
                    showAlert("Ups Maaf", "{{ Session::get('warning') }}", "warning");
                };
            </script>
        @endif
        <section class="content-of-inventaris h-full w-full overflow-y-scroll rounded-xl bg-white shadow-md">
            <div class="p-4">
                <div
                    class="sticky top-0 z-50 grid grid-cols-[15%_20%_20%_25%_auto] border-b border-gray-400 bg-[#F6F8FB] shadow">
                    <p class="flex items-center justify-center border-r border-gray-400 px-2 py-2 text-center">Nomor
                        Unit</p>
                    <p class="flex items-center justify-center border-r border-gray-400 px-2 py-2 text-center">Tanggal
                        Pinjam
                    </p>
                    <p class="flex items-center justify-center border-r border-gray-400 px-2 py-2 text-center">Tanggal
                        Kembali
                    </p>
                    <p class="flex items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Keperluan
                    </p>
                    <p class="flex items-center justify-center px-2 py-2 text-center">Aksi</p>
                </div>


                @foreach ($allUnits as $index => $unit)
                    <form action="{{ route('pinjam.alat', [$alat->slug, $unit->id]) }}"
                        class="pinjam-form grid grid-cols-[15%_20%_20%_25%_auto] rounded-md" method="POST">
                        @csrf
                        @method('POST')
                        <input type="text" name="id_user" id="id_user" value="{{ $user_id }}" class="hidden">
                        <input type="hidden" name="id_unit" value="{{ $unit->id }}">
                        <div
                            class="flex flex-col gap-2 border-b border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <p name="no_unit" id="no_unit" class="border-none p-0 px-2 py-2 normal-case">
                                {{ $unit->no_unit }}
                            </p>
                        </div>
                        <div
                            class="flex flex-col gap-2 border-b border-l border-r border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <input type="date" name="tanggal_pinjam"id="tanggal_pinjam_{{ $index }}" required
                                class="border-none p-0 px-2 py-2 normal-case focus:outline-none focus:ring-0"
                                placeholder="Masukan tanggal">
                        </div>
                        <div
                            class="flex flex-col gap-2 border-b border-l border-r border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <input type="date" name="tanggal_kembali" id="tanggal_kembali_{{ $index }}"
                                required class="border-none p-0 px-2 py-2 normal-case focus:outline-none focus:ring-0"
                                placeholder="Masukan tanggal">
                        </div>
                        <div
                            class="flex flex-col gap-2 border-b border-l border-r border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <input type="text" name="keperluan" id="keperluan" required
                                class="border-none p-0 px-2 py-2 normal-case focus:outline-none focus:ring-0"
                                placeholder="Masukan keperluan anda">
                        </div>
                        <div
                            class="flex w-full items-center justify-center gap-2 border-b-2 border-r border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <button type="button"
                                onclick="addToCart({{ $unit->id }}, '{{ $user_id }}', '{{ csrf_token() }}', {{ $index }})"
                                class="pinjam-alat rounded-md bg-[#08835a] px-3 py-2 text-sm text-white">
                                <x-heroicon-c-shopping-cart class="w-5" />
                            </button>
                            </button>
                            <button type="submit"
                                class="pinjam-alat rounded-md bg-[#08835a] px-3 py-2 text-sm text-white">Pinjam
                                Alat</button>
                        </div>
                    </form>
                @endforeach
            </div>
        </section>
        <div class="animate-fade-in absolute bottom-4 right-4 flex h-fit w-[20%] flex-col gap-3 rounded-xl border bg-white p-4 opacity-0 shadow-xl transition-opacity"
            id="modal">
            <div class="flex justify-between">
                <h1 class="text-lg font-medium">Informasi Alat dan Barang</h1>
                <button id="closeButton">X</button>
            </div>
            <div>
                <p>Nama Alat</p>
                <p class="text-slate-600">{{ $namaAlat }}</p>
            </div>
            <div>
                <p>Note</p>
                <p class="text-slate-600">Silahkan masukan tanggal peminjaman pada salah satu unit yang akan anda pinjam
                    jika tersedia</p>
            </div>
        </div>


    </main>

</x-layout>

<style>
    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .animate-fade-out {
        animation: fadeOut 0.3s ease-in forwards;
    }

    #modal {
        transition: opacity 0.3s ease-in-out;
    }
</style>

<script>
    // ANCHOR Cart
    function addToCart(unitId, userId, csrfToken, index) {
        const tanggalPinjam = document.getElementById(`tanggal_pinjam_${index}`).value;
        const tanggalKembali = document.getElementById(`tanggal_kembali_${index}`).value;
        const keperluan = document.getElementById('keperluan').value;

        if (!tanggalPinjam || !tanggalKembali || !keperluan) {
            showAlert("Ups", "Silakan isi semua kolom yang diperlukan.", "warning");
            return;
        }

        // Cek overlap dengan data di local storage
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const isOverlap = cart.some(item =>
            item.id_unit === unitId && (
                (tanggalPinjam <= item.tanggal_kembali && tanggalPinjam >= item.tanggal_pinjam) ||
                (tanggalKembali >= item.tanggal_pinjam && tanggalKembali <= item.tanggal_kembali) ||
                (tanggalPinjam <= item.tanggal_pinjam && tanggalKembali >= item.tanggal_kembali)
            )
        );

        if (isOverlap) {
            showAlert("Ups", "Unit ini telah diajukan untuk tanggal tersebut di keranjang lokal Anda!", "error");
            return;
        }

        // Jika tidak ada overlap di local storage, lanjutkan ke pengecekan backend
        axios.post('{{ route('pinjam.checkOverlap') }}', {
                id_unit: unitId,
                tanggal_pinjam: tanggalPinjam,
                tanggal_kembali: tanggalKembali,
                _token: csrfToken // CSRF token
            })
            .then(response => {
                // Jika tidak ada overlap di backend, tambahkan ke cart
                cart.push({
                    id_unit: unitId,
                    tanggal_pinjam: tanggalPinjam,
                    tanggal_kembali: tanggalKembali,
                    keperluan: keperluan,
                    user_id: userId,
                    csrf_token: csrfToken
                });

                localStorage.setItem('cart', JSON.stringify(cart));
                showAlert("Sukses", response.data.message, "success");
            })
            .catch(error => {
                if (error.response && error.response.status === 400) {
                    showAlert("Ups", error.response.data.error, "error"); // Menampilkan pesan error dari server
                } else {
                    console.error('Error checking overlap:', error);
                    showAlert("Error", "Terjadi kesalahan. Silakan coba lagi.", "error");
                }
            });
    }



    document.addEventListener('DOMContentLoaded', function() {
        @foreach ($allUnits as $index => $unit)
            flatpickr('#tanggal_pinjam_{{ $index }}', {
                minDate: "{{ $minDate }}",
                maxDate: "{{ $maxDate }}",
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    const nextDay = new Date(selectedDates[0]);
                    nextDay.setDate(nextDay.getDate() + 1);

                    const tanggalKembaliInput = document.getElementById(
                        'tanggal_kembali_{{ $index }}');
                    flatpickr(tanggalKembaliInput, {
                        minDate: nextDay,
                        dateFormat: "Y-m-d"
                    });
                }
            });

            flatpickr('#tanggal_kembali_{{ $index }}', {
                minDate: "{{ $minReturnDate }}",
                maxDate: "{{ $maxDate }}",
                dateFormat: "Y-m-d"
            });
        @endforeach
    });


    function showModal() {
        const modal = document.getElementById('modal');
        modal.classList.remove('hidden');
        modal.classList.add('animate-fade-in');
    }

    document.getElementById('closeButton').addEventListener('click', function() {
        const modal = document.getElementById('modal');
        modal.classList.remove('animate-fade-in');
        modal.classList.add('animate-fade-out');

        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    });
    showModal();
</script>
