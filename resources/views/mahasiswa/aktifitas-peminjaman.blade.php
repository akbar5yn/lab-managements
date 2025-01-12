<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>
    <main class="flex h-full flex-col gap-4">
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
        @if (Session::has('warning'))
            <script>
                window.onload = function() {
                    showAlert("Upps", "{{ Session::get('warning') }}", "warning");
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
                    showAlert("Gagal", "{{ Session::get('error') }}", "error");
                    const swalBody = document.querySelector('body.swal2-height-auto');
                    if (swalBody) {
                        swalBody.style.minHeight = '100vh';
                        swalBody.style.maxHeight = '100vh';
                        swalBody.style.overflowY = 'auto';
                    }
                };
            </script>
        @endif
        <!-- SECTION Show Alat-->
        <section class="flex justify-between gap-2 rounded-xl bg-white p-4 shadow-md">
            <!-- ANCHOR Button Navigation-->
            <div class="flex gap-2">
                <x-navigasi-peminjaman-alat></x-navigasi-peminjaman-alat>
            </div>
        </section>
        <section class="flex h-full max-w-full flex-col overflow-y-scroll rounded-xl bg-[#FFFFFF] shadow-md">
            <div
                class="sticky top-0 z-10 grid grid-cols-[4%_25%_30%_20%_auto] items-center border-b border-gray-400 bg-[#2D3648] text-center text-white shadow">
                <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">No</p>
                <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                    No Transaksi</p>
                <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                    Nama Alat</p>

                <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                    Status Peminjaman</p>
                <p class="h-full border-gray-400 px-2 py-2 font-medium">
                    Detail</p>
            </div>

            @foreach ($getTransactions as $transaction)
                <div x-data="{ isOpen: false }">

                    <div class="grid grid-cols-[4%_25%_30%_20%_auto] rounded-md border-b border-gray-400">
                        <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $loop->iteration }}</p>
                        <p class="break-words border-r border-gray-400 px-2 py-2">{{ $transaction['no_transaksi'] }}</p>
                        <p class="border-r border-gray-400 px-2 py-2">
                            {{ $transaction['relasi_unit']['unit']['nama_alat'] }}
                        </p>

                        <div class="border-r border-gray-400 px-2 py-2 text-center capitalize">
                            <p
                                class="{{ $transaction['status'] == 'pending' ? 'bg-gray-200 text-gray-600' : ($transaction['status'] == 'dipinjam' ? 'bg-green-100 text-green-600' : ($transaction['status'] == 'dikembalikan' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600')) }} rounded px-2 py-1">
                                @php
                                    $statusLabels = [
                                        'belum_dikembalikan' => 'Belum Dikembalikan',
                                        'dipinjam' => 'Dipinjam',
                                        'dikembalikan' => 'Dikembalikan',
                                        'terlambat_dikembalikan' => 'Terlambat Dikembalikan',
                                    ];
                                @endphp
                                {{ $statusLabels[$transaction['status']] ?? ucfirst($transaction['status']) }}
                            </p>
                        </div>
                        <div class="flex w-full items-center justify-center">
                            <button class="rounded bg-[#2D3648] px-5 py-1 text-white" @click="isOpen = !isOpen">
                                <x-heroicon-c-chevron-down class="h-4 w-4 transform transition-transform duration-300"
                                    x-bind:class="isOpen ? '-rotate-180' : ''" />
                            </button>
                        </div>
                    </div>
                    <div x-show="isOpen" x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-100 transform"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="glow-left grid grid-cols-[4%_25%_30%_20%_auto] border-l-4 border-l-emerald-400 p-2">
                        <div class=""></div>
                        <div>
                            <h4 class="text-sm font-medium">Nama Alat - No Unit</h4>
                            <p class="text-light text-[12px] text-gray-500">
                                {{ $transaction['relasi_unit']['unit']['nama_alat'] }} -
                                {{ $transaction['relasi_unit']['no_unit'] }}
                            </p>

                        </div>
                        <div>
                            <h4 class="text-sm font-medium">Keperluan</h4>
                            <p class="text-light text-[12px] text-gray-500">
                                {{ $transaction['keperluan'] }}</p>

                        </div>
                        <div>
                            <h4 class="text-sm font-medium">Tanggal Pinjam</h4>
                            <p class="text-light text-[12px] text-gray-500">
                                {{ $transaction['tanggal_pinjam'] }}</p>

                        </div>
                        <div>
                            <h4 class="text-sm font-medium">Tanggal Kembali</h4>
                            <p class="text-light text-[12px] text-gray-500">
                                {{ $transaction['tanggal_kembali'] }}</p>
                        </div>
                        <hr class="col-span-5 my-2 border">
                        <div></div>
                        <div>
                            <h4 class="text-sm font-medium">Nama Peminjam</h4>
                            <p class="text-light text-[12px] text-gray-500">
                                {{ $transaction['relasi_user']['name'] }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium">No Handphone</h4>
                            <p class="text-light text-[12px] text-gray-500">
                                {{ $transaction['relasi_user']['phone_number'] }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium">Email</h4>
                            <p class="text-light break-words text-[12px] text-gray-500">
                                {{ $transaction['relasi_user']['email'] }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium">Waktu Kadaluwarsa</h4>
                            <p id="countdown-{{ $transaction['no_transaksi'] }}"
                                class="text-light break-words text-[12px] text-gray-500">
                                {{ $transaction['waktu_kadaluwarsa'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

        </section>

        <!-- SECTION button scan -->
        <div class="flex w-full justify-end">
            <a href="{{ route('scan.aktivitas.peminjaman') }}"
                class="rounded-md bg-green-500 px-2 py-1 text-white">Scan Peminjaman</a>
        </div>

        <style>
            .glow-left {
                box-shadow:
                    inset 8px 0 15px -10px rgba(16, 185, 129, 0.6),
                    inset 0 8px 10px -10px rgba(48, 48, 48, 0.6),
                    inset 0 -8px 10px -10px rgba(48, 48, 48, 0.6)
                    /* Shadow hijau ke kiri */
            }
        </style>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const getTransactions = @json($getTransactions);
                getTransactions.forEach(transaction => {
                    const waktuKedaluwarsa = transaction.waktu_kadaluwarsa;
                    const noTransaksi = transaction.no_transaksi;
                    const statusTransaksi = transaction.status;

                    function updateCountdown() {
                        const countdownElement = document.getElementById(`countdown-${noTransaksi}`);

                        // Jika status adalah 'dipinjam', 'terlambat_dikembalikan', atau 'dikembalikan', stop countdown
                        if (['dipinjam', 'terlambat_dikembalikan', 'dikembalikan', 'dibatalkan'].includes(
                                statusTransaksi)) {
                            clearInterval(countdownInterval);
                            countdownElement.innerText = '00:00:00';
                            return;
                        }

                        const currentTime = new Date().getTime();
                        const endTime = new Date(waktuKedaluwarsa).getTime();
                        const timeLeft = endTime - currentTime;

                        if (timeLeft <= 0) {
                            countdownElement.innerText = '00:00:00';
                            clearInterval(countdownInterval);
                        } else {
                            const hours = Math.floor(timeLeft / (1000 * 60 * 60));
                            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                            countdownElement.innerText = `${hours}:${minutes}:${seconds}`;
                        }
                    }

                    // Memulai countdown untuk setiap transaksi
                    const countdownInterval = setInterval(updateCountdown, 1000);
                });
            });
        </script>


</x-layout>
