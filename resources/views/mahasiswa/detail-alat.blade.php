<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:subtitle>{{ $subtitle }}</x-slot:subtitle>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>

    <main class="relative flex h-full w-full gap-4">

        {{-- SECTION: Session Alerts --}}
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
        {{-- END SECTION: Session Alerts --}}

        <section
            class="content-of-inventaris flex h-full w-full flex-col space-y-5 overflow-y-scroll rounded-xl bg-white shadow-md">
            <section class="w-full rounded-xl bg-white p-4">
                <form method="GET" action="{{ url()->current() }}" class="flex flex-col md:flex-row gap-4 items-end">

                    <div class="flex-1 w-full">
                        <label for="cek_tanggal" class="block text-sm font-semibold text-gray-700">Cek Ketersediaan Pada
                            Tanggal:</label>
                        <input type="date" name="cek_tanggal" id="cek_tanggal_filter_input" required
                            value="{{ $cekTanggal ?? \Carbon\Carbon::now()->toDateString() }}"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-[#265166] focus:ring-0">
                    </div>

                    <div class="w-full md:w-auto">
                        <button type="submit"
                            class="w-full rounded-md bg-[#265166] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#1a3845]">
                            Tampilkan Status
                        </button>
                    </div>
                </form>

                <p class="text-xs text-gray-600 mt-2">Status unit ditampilkan untuk tanggal: <span
                        class="font-bold">{{ \Carbon\Carbon::parse($cekTanggal)->translatedFormat('d F Y') }}</span></p>
            </section>
            <div class="px-4 grid md:grid-cols-2 gap-2">
                @foreach ($allUnits as $index => $unit)
                    @php
                        $hasActiveTransaction = $unit->relasiTransaksi->isNotEmpty();
                        $statusText = $hasActiveTransaction ? 'Dipinjam' : 'Tersedia';
                        $statusColor = $hasActiveTransaction
                            ? 'bg-red-300 text-red-900'
                            : 'bg-green-100 text-green-800';
                        $buttonText = $hasActiveTransaction ? 'Tidak Tersedia' : 'Pinjam Alat';
                    @endphp
                    <form action="{{ route('pinjam.alat', [$alat->slug, $unit->id]) }}"
                        class="pinjam-form flex flex-col gap-4 rounded-lg border border-gray-300 p-4 shadow-md transition hover:shadow-lg
                        {{ $hasActiveTransaction ? 'bg-gray-100 opacity-80 pointer-events-none' : 'bg-white hover:shadow-xl' }}"
                        method="POST">
                        @csrf
                        @method('POST')
                        <input type="text" name="id_user" id="id_user" value="{{ $user_id }}" class="hidden">
                        <input type="hidden" name="id_unit" value="{{ $unit->id }}">

                        <div class="flex items-center justify-between border-b border-[#2D3648] pb-2">
                            <h3 class="text-base font-bold text-[#2D3648] xl:text-lg">Unit: {{ $unit->no_unit }}</h3>
                            <div class="flex items-center gap-2 justify-between py-1">
                                <span
                                    class="inline-flex items-center rounded-full px-3 py-0.5 text-xs font-medium {{ $statusColor }}">
                                    {{ $statusText }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                            <div class="flex flex-col space-y-1">
                                <label for="tanggal_pinjam_{{ $index }}"
                                    class="text-xs font-medium text-gray-700 xl:text-sm">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" id="tanggal_pinjam_{{ $index }}"
                                    required
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-[#559f86] focus:ring-0 {{ $hasActiveTransaction ? 'bg-gray-200' : '' }}"
                                    {{ $hasActiveTransaction ? 'disabled' : '' }}>
                            </div>

                            <div class="flex flex-col space-y-1">
                                <label for="tanggal_kembali_{{ $index }}"
                                    class="text-xs font-medium text-gray-700 xl:text-sm">Tanggal Kembali</label>
                                <input type="date" name="tanggal_kembali" id="tanggal_kembali_{{ $index }}"
                                    required
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-[#559f86] focus:ring-0 {{ $hasActiveTransaction ? 'bg-gray-200' : '' }}"
                                    {{ $hasActiveTransaction ? 'disabled' : '' }}>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-1">
                            <label for="keperluan_{{ $index }}"
                                class="text-xs font-medium text-gray-700 xl:text-sm">Keperluan Peminjaman</label>
                            <input type="text" name="keperluan" id="keperluan_{{ $index }}" required
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-[#559f86] focus:ring-0 {{ $hasActiveTransaction ? 'bg-gray-200' : '' }}"
                                placeholder="Masukan keperluan anda" {{ $hasActiveTransaction ? 'disabled' : '' }}>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="pinjam-alat rounded-md px-4 py-2 text-sm font-semibold text-white transition
                                {{ $hasActiveTransaction ? 'bg-gray-400 cursor-not-allowed' : 'bg-[#08835a] hover:bg-[#066a47]' }}"
                                {{ $hasActiveTransaction ? 'disabled' : '' }}> {{ $buttonText }}
                            </button>
                        </div>
                    </form>
                @endforeach
            </div>

            <div class="px-4 pb-4">
                {{ $allUnits->links() }}
            </div>
        </section>

        {{-- SECTION: Floating Info Modal --}}
        <div class="animate-fade-in absolute bottom-4 right-4 flex h-fit w-[90%] flex-col gap-3 rounded-xl border bg-white p-4 opacity-0 shadow-xl transition-opacity md:w-[70%] lg:w-[30%]"
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
        {{-- END SECTION: Floating Info Modal --}}

    </main>

</x-layout>

<style>
    /* Styling Animasi tetap sama */
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
        /* Tambahkan posisi absolute/fixed untuk floating modal */
        position: absolute;
        /* Tetap absolute di dalam main relative */
        /* Sesuaikan W/H agar lebih responsif */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logika Flatpickr (Wajib ada)
        @foreach ($allUnits as $index => $unit)
            flatpickr('#tanggal_pinjam_{{ $index }}', {
                minDate: "{{ $minDate }}",
                maxDate: "{{ $maxDate }}",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y",
                onChange: function(selectedDates, dateStr, instance) {
                    const nextDay = new Date(selectedDates[0]);
                    nextDay.setDate(nextDay.getDate() + 1);

                    const tanggalKembaliInput = document.getElementById(
                        'tanggal_kembali_{{ $index }}');
                    flatpickr(tanggalKembaliInput, {
                        minDate: nextDay,
                        dateFormat: "Y-m-d",
                        altInput: true,
                        altFormat: "d-m-Y"
                    });
                }
            });

            flatpickr('#tanggal_kembali_{{ $index }}', {
                minDate: "{{ $minReturnDate }}",
                maxDate: "{{ $maxDate }}",
                dateFormat: "Y-m-d"
            });
        @endforeach

        flatpickr('#cek_tanggal_filter_input', { // Target ID input filter
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d-m-Y",
        });

        // Logika Modal Info
        function showModal() {
            const modal = document.getElementById('modal');
            modal.classList.remove('opacity-0');
            modal.classList.remove('hidden');
            modal.classList.add('animate-fade-in');
        }

        document.getElementById('closeButton').addEventListener('click', function() {
            const modal = document.getElementById('modal');
            modal.classList.remove('animate-fade-in');
            modal.classList.add('animate-fade-out');

            setTimeout(() => {
                modal.classList.add('hidden'); // Sembunyikan elemen setelah fade out
            }, 300);
        });
        showModal();
    });
</script>
