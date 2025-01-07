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
                class="sticky top-0 z-10 grid grid-cols-[15%_20%_30.3%_20.3%_auto] items-center border-b border-gray-400 bg-[#2D3648] text-center text-white shadow">
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
        <div class="flex w-full justify-end">
            <a href="{{ route('scan.aktivitas.peminjaman') }}"
                class="rounded-md bg-green-500 px-2 py-1 text-white">Scan Peminjaman</a>
        </div>
</x-layout>
