<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>

    <main class="flex h-full flex-col gap-4">
        <section class="flex max-w-full gap-4 rounded-xl bg-white p-4 shadow-md">
            <x-navigasi-peminjaman-alat></x-navigasi-peminjaman-alat>
        </section>
        <section class="h-full overflow-y-scroll rounded-xl bg-white shadow-md">
            <div class="p-4">
                <div
                    class="sticky top-0 z-10 grid grid-cols-[4%_25%_25%_25%_auto] items-center border-b border-gray-400 bg-[#e4e4e4] shadow">
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        No</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Nama Peminjam</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Nomor Transaksi</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Status Peminjaman</p>
                    <p class="flex h-full items-center justify-center px-2 py-2 text-center">
                        Aksi</p>
                </div>

                @if (Auth::check() && Auth::user()->role == 'laboran')

                    @php
                        $sortedTransaction = collect($riwayatPeminjamanAlat)->sortByDesc('created_at');
                    @endphp
                    @foreach ($sortedTransaction as $riwayat)
                        <div class="grid grid-cols-[4%_25%_25%_25%_auto] border-b border-gray-400">
                            <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $loop->iteration }}</p>
                            <p class="border-r border-gray-400 px-2 py-2">
                                {{ $riwayat->relasiTransaksiAlat->relasiUser->name ?? 'User tidak ditemukan' }}</p>
                            <p class="border-r border-gray-400 px-2 py-2">{{ $riwayat->no_transaksi }}</p>
                            <div class="border-r border-gray-400 px-2 py-2 text-center">
                                <p
                                    class="{{ $riwayat->relasiTransaksiAlat->status == 'dikembalikan' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600' }} rounded">
                                    @php
                                        $statusLabels = [
                                            'dikembalikan' => 'Dikembalikan',
                                            'expire' => 'Expire',
                                            'dibatalkan' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    {{ $statusLabels[$riwayat->relasiTransaksiAlat->status] ?? ucfirst($riwayat->relasiTransaksiAlat->status) }}
                                </p>
                            </div>
                            <div class="flex items-center justify-center gap-5">
                                <a href="{{ route('detail.riwayat', ['slug' => $riwayat->no_transaksi]) }}"
                                    class="rounded bg-blue-400 px-2 text-white">Detail Riwayat</a>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if (Auth::check() && Auth::user()->role == 'mahasiswa')
                    @php
                        $sortedTransaction = collect($riwayatMahasiswa)->sortByDesc('created_at');
                    @endphp
                    @foreach ($sortedTransaction as $riwayat)
                        <div class="grid grid-cols-[4%_25%_25%_25%_auto] border-b border-gray-400">
                            <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $loop->iteration }}</p>
                            <p class="border-r border-gray-400 px-2 py-2">
                                {{ $riwayat->relasiTransaksiAlat->relasiUser->name ?? 'User tidak ditemukan' }}</p>
                            <p class="border-r border-gray-400 px-2 py-2">{{ $riwayat->no_transaksi }}</p>
                            <div class="border-r border-gray-400 px-2 py-2 text-center">
                                <p
                                    class="{{ $riwayat->relasiTransaksiAlat->status == 'dikembalikan' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600' }} rounded">
                                    @php
                                        $statusLabels = [
                                            'dikembalikan' => 'Dikembalikan',
                                            'expire' => 'Expire',
                                            'dibatalkan' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    {{ $statusLabels[$riwayat->relasiTransaksiAlat->status] ?? ucfirst($riwayat->relasiTransaksiAlat->status) }}
                                </p>
                            </div>
                            <div class="flex items-center justify-center gap-5">
                                <a href="{{ route('detail.riwayat', ['slug' => $riwayat->no_transaksi]) }}"
                                    class="rounded bg-blue-400 px-2 text-white">Detail Riwayat</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>
    </main>
</x-layout>
