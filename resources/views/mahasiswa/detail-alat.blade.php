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
        <section
            class="content-of-inventaris flex h-full w-full flex-col space-y-5 overflow-y-scroll rounded-xl bg-white shadow-md">
            <div class="p-4">
                <div
                    class="sticky top-0 z-40 grid grid-cols-[13%_21%_21%_25%_auto] border-b border-gray-400 bg-[#F6F8FB] shadow xl:grid-cols-[15%_20%_20%_25%_auto]">
                    <p
                        class="flex items-center justify-center border-r border-gray-400 px-2 py-2 text-center text-xs xl:text-base">
                        Nomor
                        Unit</p>
                    <p
                        class="flex items-center justify-center border-r border-gray-400 px-2 py-2 text-center text-xs xl:text-base">
                        Tanggal
                        Pinjam
                    </p>
                    <p
                        class="flex items-center justify-center border-r border-gray-400 px-2 py-2 text-center text-xs xl:text-base">
                        Tanggal
                        Kembali
                    </p>
                    <p
                        class="flex items-center justify-center border-r border-gray-400 px-2 py-2 text-center text-xs xl:text-base">
                        Keperluan
                    </p>
                    <p class="flex items-center justify-center px-2 py-2 text-center text-xs xl:text-base">Aksi</p>
                </div>


                @foreach ($allUnits as $index => $unit)
                    <form action="{{ route('pinjam.alat', [$alat->slug, $unit->id]) }}"
                        class="pinjam-form grid grid-cols-[13%_21%_21%_25%_auto] rounded-md xl:grid-cols-[15%_20%_20%_25%_auto]"
                        method="POST">
                        @csrf
                        @method('POST')
                        <input type="text" name="id_user" id="id_user" value="{{ $user_id }}" class="hidden">
                        <input type="hidden" name="id_unit" value="{{ $unit->id }}">
                        <div
                            class="flex flex-col gap-2 border-b border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <p name="no_unit" id="no_unit"
                                class="border-none p-0 px-2 py-2 text-[11px] normal-case xl:text-base">
                                {{ $unit->no_unit }}
                            </p>
                        </div>
                        <div
                            class="flex flex-col gap-2 border-b border-l border-r border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <input type="date" name="tanggal_pinjam"id="tanggal_pinjam_{{ $index }}" required
                                class="border-none p-0 px-2 py-2 text-[11px] normal-case focus:outline-none focus:ring-0 xl:text-base"
                                placeholder="Masukan tanggal">
                        </div>
                        <div
                            class="flex flex-col gap-2 border-b border-l border-r border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <input type="date" name="tanggal_kembali" id="tanggal_kembali_{{ $index }}"
                                required
                                class="border-none p-0 px-2 py-2 text-[11px] normal-case focus:outline-none focus:ring-0 xl:text-base"
                                placeholder="Masukan tanggal">
                        </div>
                        <div
                            class="flex flex-col gap-2 border-b border-l border-r border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <input type="text" name="keperluan" id="keperluan" required
                                class="border-none p-0 px-2 py-2 text-[11px] normal-case focus:outline-none focus:ring-0 xl:text-base"
                                placeholder="Masukan keperluan anda">
                        </div>
                        <div
                            class="flex w-full items-center justify-center gap-2 border-b-2 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <button type="submit"
                                class="pinjam-alat rounded-md bg-[#08835a] px-1 py-1 text-[11px] text-white xl:px-3 xl:py-2 xl:text-sm">Pinjam
                                Alat</button>
                        </div>
                    </form>
                @endforeach
            </div>
            <div class="px-4 pb-4">
                {{ $allUnits->links() }}
            </div>
        </section>
        <div class="animate-fade-in absolute bottom-2 right-2 flex h-fit w-[70%] flex-col gap-3 rounded-xl border bg-white p-4 opacity-0 shadow-xl transition-opacity xl:bottom-4 xl:right-4 xl:w-[30%]"
            id="modal">
            <div class="flex justify-between">
                <h1 class="text-sm font-medium xl:text-lg">Informasi Alat dan Barang</h1>
                <button id="closeButton">X</button>
            </div>
            <div>
                <p class="text-sm xl:text-base">Nama Alat</p>
                <p class="text-sm text-slate-600 xl:text-base">{{ $namaAlat }}</p>
            </div>
            <div>
                <p class="text-sm xl:text-base">Note</p>
                <p class="text-sm text-slate-600 xl:text-base">Silahkan masukan tanggal peminjaman pada salah satu unit
                    yang akan anda pinjam
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
