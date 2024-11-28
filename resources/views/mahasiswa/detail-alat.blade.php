<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:subtitle>{{ $subtitle }}</x-slot:subtitle>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>

    <main class="relative flex h-full w-full gap-4">
        @if (Session::has('success'))
            <script>
                window.onload = function() {
                    showAlert("Berhasil", "{{ Session::get('success') }}", "success");
                    const swalBody = document.querySelector('body.swal2-height-auto');
                    if (swalBody) {
                        swalBody.style.minHeight = '100vh';
                        swalBody.style.maxHeight = '100vh';
                        swalBody.style.overflowY = 'auto';
                    }
                };
            </script>
        @endif

        @if (Session::has('error'))
            <script>
                window.onload = function() {
                    showAlert("Error", "{{ Session::get('error') }}", "error");
                    const swalBody = document.querySelector('body.swal2-height-auto');
                    if (swalBody) {
                        swalBody.style.minHeight = '100vh';
                        swalBody.style.maxHeight = '100vh';
                        swalBody.style.overflowY = 'auto';
                    }
                };
            </script>
        @endif

        @if (Session::has('warning'))
            <script>
                window.onload = function() {
                    showAlert("Ups Maaf", "{{ Session::get('warning') }}", "warning");
                    const swalBody = document.querySelector('body.swal2-height-auto');
                    if (swalBody) {
                        swalBody.style.minHeight = '100vh';
                        swalBody.style.maxHeight = '100vh';
                        swalBody.style.overflowY = 'auto';
                    }
                };
            </script>
        @endif
        <section class="content-of-inventaris h-full w-full overflow-y-scroll rounded-xl bg-white shadow-md">
            <div class="p-4">
                <div
                    class="sticky top-0 z-50 grid grid-cols-[20%_20%_20%_25%_auto] border-b border-gray-400 bg-[#F6F8FB] shadow">
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
                        class="pinjam-form grid grid-cols-[20%_20%_20%_25%_auto] rounded-md" method="POST">
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

    /* Animasi muncul */
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    /* Animasi hilang */
    .animate-fade-out {
        animation: fadeOut 0.3s ease-in forwards;
    }
</style>

<script>
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
                minDate: "{{ $minReturnDate }}", // Ensure minimum return date is the next day
                maxDate: "{{ $maxDate }}",
                dateFormat: "Y-m-d"
            });
        @endforeach
    });


    document.getElementById('closeButton').addEventListener('click', function() {
        const modal = document.getElementById('modal');
        modal.classList.remove('animate-fade-in'); // Hapus kelas animasi masuk
        modal.classList.add('animate-fade-out'); // Tambahkan kelas animasi keluar

        // Sembunyikan modal setelah animasi selesai
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300); // Durasi sama dengan durasi animasi fade-out
    });
</script>
