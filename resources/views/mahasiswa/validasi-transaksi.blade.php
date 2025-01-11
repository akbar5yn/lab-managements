<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>
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
    <main class="flex h-full flex-col gap-4 overflow-y-scroll">
        <form action="{{ route('submit-pengajuan-transaksi') }}" id="submit-pengajuan" method="POST">
            @method('POST')
            @csrf
        </form>
        <section class="flex h-full w-full flex-col gap-4">
            <div class="flex h-full max-w-full flex-col rounded-xl bg-[#FFFFFF] p-4 shadow-md">
                <div
                    class="sticky top-0 z-10 mt-4 grid grid-cols-[15%_20%_20%_15%_15%_auto] items-center border-b border-gray-400 bg-[#F6F8FB] text-center shadow">
                    <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                        No Transaksi</p>
                    <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                        Nama Alat</p>
                    <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                        Keperluan</p>
                    <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                        Tanggal Pinjaman</p>
                    <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                        Tanggal Kembali</p>
                    <p class="h-full border-gray-400 px-2 py-2 font-medium">
                        Aksi</p>
                </div>

                @php
                    $sortedTransaction = collect($transactions)->sortByDesc('created_at');
                @endphp
                @foreach ($sortedTransaction as $transaction)
                    <div class="grid grid-cols-[15%_20%_20%_15%_15%_auto] rounded-md border-b border-gray-400">
                        <p class="break-words border-r border-gray-400 px-2 py-2">{{ $transaction->no_transaksi }}</p>
                        <p class="border-r border-gray-400 px-2 py-2">{{ $transaction->relasiUnit->unit->nama_alat }}
                        </p>
                        <p class="border-r border-gray-400 px-2 py-2">{{ $transaction->keperluan }}</p>
                        <p class="border-r border-gray-400 px-2 py-2">{{ $transaction->tanggal_pinjam }}</p>
                        <p class="border-r border-gray-400 px-2 py-2">{{ $transaction->tanggal_kembali }}</p>
                        <div class="flex w-full items-center justify-center">
                            <form id="form-pembatalan"
                                action="{{ route('batalkan.peminjaman.alat', ['slug' => $transaction->no_transaksi]) }}"
                                class="delete-transaksi" method="POST">
                                @method('PUT')
                                @csrf
                                <button id="submit-pembatalan" type="submit"
                                    class="rounded-md bg-[#2D3648] px-4 py-1 text-sm text-white">Batalkan
                                    Peminjaman</button>
                            </form>
                        </div>
                    </div>
                    <input type="hidden" form="submit-pengajuan" name="transactions[]" value="{{ $transaction->id }}">
                @endforeach
            </div>
            <button id="submit-pengajuan" form="submit-pengajuan" type="submit"
                class="w-full rounded-xl bg-[#08835a] px-3 py-2 text-white">Submit</button>
        </section>
    </main>
</x-layout>
