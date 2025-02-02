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
        <section class="flex justify-between gap-2 xl:rounded-xl xl:bg-white xl:p-4 xl:shadow-md">
            <!-- ANCHOR Button Navigation-->
            <div class="flex gap-2">
                <x-navigasi-peminjaman-alat></x-navigasi-peminjaman-alat>
            </div>
        </section>
        <section
            class="flex h-full max-w-full flex-col gap-4 overflow-y-scroll pb-2 xl:gap-0 xl:rounded-xl xl:bg-[#FFFFFF] xl:pb-0 xl:shadow-md">
            <div
                class="sticky top-0 z-10 hidden items-center border-b border-gray-400 bg-[#2D3648] text-center text-white shadow xl:grid xl:grid-cols-[4%_25%_30%_20%_auto]">
                <p class="h-full border-r border-gray-400 px-2 py-2 text-xs font-medium xl:text-base">No</p>
                <p class="h-full border-r border-gray-400 px-2 py-2 text-xs font-medium xl:text-base">
                    No Transaksi</p>
                <p class="h-full border-r border-gray-400 px-2 py-2 text-xs font-medium xl:text-base">
                    Nama Alat</p>

                <p class="h-full border-r border-gray-400 px-2 py-2 text-xs font-medium xl:text-base">
                    Status Peminjaman</p>
                <p class="h-full border-gray-400 px-2 py-2 text-xs font-medium xl:text-base">
                    Detail</p>
            </div>

            @foreach ($getTransactions as $transaction)
                <div x-data="{ isOpen: false }">

                    <div class="hidden rounded-md border-b border-gray-400 xl:grid xl:grid-cols-[4%_25%_30%_20%_auto]">
                        <p class="border-r border-gray-400 px-2 py-2 text-center text-[11px] xl:text-base">
                            {{ $loop->iteration }}</p>
                        <p class="break-words border-r border-gray-400 px-2 py-2 text-[11px] xl:text-base">
                            {{ $transaction['no_transaksi'] }}</p>
                        <p class="border-r border-gray-400 px-2 py-2 text-[11px] xl:text-base">
                            {{ $transaction['relasi_unit']['unit']['nama_alat'] }}
                        </p>

                        <div class="border-r border-gray-400 px-2 py-2 text-center capitalize">
                            <p
                                class="{{ $transaction['status'] == 'pending' ? 'bg-gray-200 text-gray-600' : ($transaction['status'] == 'dipinjam' ? 'bg-green-100 text-green-600' : ($transaction['status'] == 'dikembalikan' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600')) }} rounded px-2 py-1 text-[11px] xl:text-base">
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
                            <button class="rounded bg-[#2D3648] px-2 text-white xl:px-5 xl:py-1"
                                @click="isOpen = !isOpen">
                                <x-heroicon-c-chevron-down
                                    class="size-4 transform transition-transform duration-300 xl:h-4 xl:w-4"
                                    x-bind:class="isOpen ? '-rotate-180' : ''" />
                            </button>
                        </div>
                    </div>
                    <div x-show="isOpen" x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-100 transform"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="glow-left hidden w-full overflow-x-scroll border-l-4 border-l-emerald-400 p-2 xl:grid xl:grid-cols-[4%_25%_30%_20%_auto]">
                        <div class=""></div>
                        <div>
                            <h4 class="text-[10px] font-medium xl:text-sm">Nama Alat - No Unit</h4>
                            <p class="text-light text-[10px] text-gray-500 xl:text-[12px]">
                                {{ $transaction['relasi_unit']['unit']['nama_alat'] }} -
                                {{ $transaction['relasi_unit']['no_unit'] }}
                            </p>

                        </div>
                        <div>
                            <h4 class="text-[10px] font-medium xl:text-sm">Keperluan</h4>
                            <p class="text-light text-[10px] text-gray-500 xl:text-[12px]">
                                {{ $transaction['keperluan'] }}</p>

                        </div>
                        <div>
                            <h4 class="text-[10px] font-medium xl:text-sm">Tanggal Pinjam</h4>
                            <p class="text-light text-[10px] text-gray-500 xl:text-[12px]">
                                {{ $transaction['tanggal_pinjam'] }}</p>

                        </div>
                        <div>
                            <h4 class="text-[10px] font-medium xl:text-sm">Tanggal Kembali</h4>
                            <p class="text-light text-[10px] text-gray-500 xl:text-[12px]">
                                {{ $transaction['tanggal_kembali'] }}</p>
                        </div>
                        <hr class="col-span-5 my-2 border">
                        <div></div>
                        <div>
                            <h4 class="text-[10px] font-medium xl:text-sm">Nama Peminjam</h4>
                            <p class="text-light text-[10px] text-gray-500 xl:text-[12px]">
                                {{ $transaction['relasi_user']['name'] }}</p>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-medium xl:text-sm">No Handphone</h4>
                            <p class="text-light text-[10px] text-gray-500 xl:text-[12px]">
                                {{ $transaction['relasi_user']['phone_number'] }}</p>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-medium xl:text-sm">Email</h4>
                            <p class="text-light break-words text-[10px] text-gray-500 xl:text-[12px]">
                                {{ $transaction['relasi_user']['email'] }}</p>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-medium xl:text-sm">Waktu Kadaluwarsa</h4>
                            <p id="countdown-desktop-{{ $transaction['no_transaksi'] }}"
                                class="text-light break-words text-[10px] text-gray-500 xl:text-[12px]">
                                {{ $transaction['waktu_kadaluwarsa'] }}</p>
                        </div>
                    </div>

                    <!-- SECTION Mobile View-->
                    <section class="rounded-md bg-white shadow-md xl:hidden">
                        <header class="rounded-t-md bg-[#2D3648] p-2 text-white">
                            <h1 class="text-xs font-semibold">{{ $transaction['relasi_unit']['unit']['nama_alat'] }}
                            </h1>
                            <span
                                class="rounded-sm bg-emerald-400 p-[0.5px] text-[11px] text-black">{{ $transaction['no_transaksi'] }}</span>
                        </header>
                        <article class="grid grid-cols-2 p-2 text-[11px]">
                            <p class="text-gray-500">No Unit :</p>
                            <p>{{ $transaction['relasi_unit']['no_unit'] }}</p>
                            <p class="text-gray-500">Keperluan :</p>
                            <p> {{ $transaction['keperluan'] }}</p>
                            <p class="text-gray-500">Tanggal Pinjam :</p>
                            <p>{{ $transaction['tanggal_pinjam'] }}</p>
                            <p class="text-gray-500">Tanggal Kembali :</p>
                            <p>{{ $transaction['tanggal_kembali'] }}</p>
                            <p class="text-gray-500">Waktu Kadaluwarsa :</p>
                            <p id="countdown-mobile-{{ $transaction['no_transaksi'] }}"
                                class="text-light break-words text-[10px] text-gray-500 xl:text-[12px]">
                                {{ $transaction['waktu_kadaluwarsa'] }}</p>
                            <p class="text-gray-500">Status Peminjaman :</p>
                            <p
                                class="{{ $transaction['status'] == 'pending' ? 'bg-gray-200 text-gray-600' : ($transaction['status'] == 'dipinjam' ? 'bg-green-100 text-green-600' : ($transaction['status'] == 'dikembalikan' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600')) }} w-fit rounded text-[11px]">
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
                        </article>
                    </section>
                </div>
            @endforeach

        </section>

        <!-- SECTION button scan -->
        <div class="flex w-full justify-end text-xs xl:text-base">
            <a href="{{ route('scan.aktivitas.peminjaman') }}"
                class="rounded-md bg-green-500 px-2 py-1 text-white">Scan Peminjaman</a>
        </div>
    </main>

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
                    // Ambil elemen countdown untuk desktop & mobile berdasarkan ID
                    const countdownDesktop = document.getElementById(`countdown-desktop-${noTransaksi}`);
                    const countdownMobile = document.getElementById(`countdown-mobile-${noTransaksi}`);

                    // Jika status bukan 'pending', hentikan countdown
                    if (['dipinjam', 'terlambat_dikembalikan', 'dikembalikan', 'dibatalkan'].includes(
                            statusTransaksi)) {
                        clearInterval(countdownInterval);
                        if (countdownDesktop) countdownDesktop.innerText = '00:00:00';
                        if (countdownMobile) countdownMobile.innerText = '00:00:00';
                        return;
                    }

                    const currentTime = new Date().getTime();
                    const endTime = new Date(waktuKedaluwarsa).getTime();
                    const timeLeft = endTime - currentTime;

                    if (timeLeft <= 0) {
                        if (countdownDesktop) countdownDesktop.innerText = '00:00:00';
                        if (countdownMobile) countdownMobile.innerText = '00:00:00';
                        clearInterval(countdownInterval);
                    } else {
                        const hours = Math.floor(timeLeft / (1000 * 60 * 60));
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                        const formattedTime =
                            `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                        // Update kedua elemen (desktop & mobile)
                        if (countdownDesktop) countdownDesktop.innerText = formattedTime;
                        if (countdownMobile) countdownMobile.innerText = formattedTime;
                    }
                }

                const countdownInterval = setInterval(updateCountdown, 1000);
            });
        });
    </script>


</x-layout>
