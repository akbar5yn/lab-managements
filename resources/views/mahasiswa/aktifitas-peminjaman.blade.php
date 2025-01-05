<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>
    <main class="flex h-full flex-col gap-4 overflow-y-scroll">
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
        <section>
            <!-- ANCHOR Button Navigation-->
            <div class="flex gap-2">
                <a href="{{ route('informasi.alat') }}"
                    class="{{ request()->is('mahasiswa/peminjaman-alat/informasi') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} w-fit rounded-lg px-2 py-1 text-lg font-medium shadow-sm">
                    Informasi Alat
                </a>
                <a href="{{ route('aktivitas.peminjaman') }}"
                    class="{{ request()->is('mahasiswa/peminjaman-alat/aktifitas') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} w-fit rounded-lg px-2 py-1 text-lg font-medium shadow-sm">
                    Aktivitas Peminjaman
                </a>
            </div>
        </section>
        <section class="flex max-w-full flex-col rounded-xl bg-[#FFFFFF] p-4 shadow-md">
            <div
                class="sticky top-0 z-10 mt-4 grid grid-cols-[15%_20%_30.3%_20.3%_auto] items-center border-b border-gray-400 bg-[#F6F8FB] text-center shadow">
                <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                    No Transaksi</p>
                <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                    Nama Alat</p>
                <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                    Keperluan</p>
                <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                    Status Peminjaman</p>
                <p class="h-full border-gray-400 px-2 py-2 font-medium">
                    Detail</p>
            </div>

            @php
                $sortedTransaction = collect($getTransactions)->sortByDesc('created_at');
            @endphp
            @foreach ($sortedTransaction as $transaction)
                <div class="grid grid-cols-[15%_20%_30.3%_20.3%_auto] rounded-md border-b border-gray-400">
                    <p class="break-words border-r border-gray-400 px-2 py-2">{{ $transaction->no_transaksi }}</p>
                    <p class="border-r border-gray-400 px-2 py-2">{{ $transaction->relasiUnit->unit->nama_alat }}</p>
                    <p class="border-r border-gray-400 px-2 py-2">{{ $transaction->keperluan }}</p>

                    <div class="border-r border-gray-400 px-2 py-2 text-center capitalize">
                        <p
                            class="{{ $transaction->status == 'pending' ? 'bg-gray-200 text-gray-600' : ($transaction->status == 'dipinjam' ? 'bg-green-100 text-green-600' : ($transaction->status == 'dikembalikan' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600')) }} rounded px-2 py-1">
                            @php
                                $statusLabels = [
                                    'belum_dikembalikan' => 'Belum Dikembalikan',
                                    'dipinjam' => 'Dipinjam',
                                    'dikembalikan' => 'Dikembalikan',
                                    'terlambat_dikembalikan' => 'Terlambat Dikembalikan',
                                ];
                            @endphp
                            {{ $statusLabels[$transaction->status] ?? ucfirst($transaction->status) }}
                        </p>
                    </div>
                    <div class="flex w-full items-center justify-center">

                        <a href="{{ route('detail.aktivitas.peminjaman', ['slug' => $transaction->no_transaksi]) }}"
                            class="rounded-md bg-[#2D3648] px-4 py-1 text-sm text-white">Detail</a>
                    </div>
                </div>
            @endforeach

        </section>

        <!-- SECTION button scan -->
        <div class="absolute bottom-4 right-4">
            <a href="{{ route('scan.aktivitas.peminjaman') }}"
                class="rounded-md bg-green-500 px-2 py-1 text-white">Scan Peminjaman</a>
        </div>
</x-layout>
