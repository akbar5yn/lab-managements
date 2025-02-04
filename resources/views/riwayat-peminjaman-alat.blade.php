<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>

    <main class="flex h-full flex-col gap-4">
        <section class="flex flex-col justify-between gap-2 xl:flex-row xl:rounded-xl xl:bg-white xl:p-4 xl:shadow-md">
            <!-- ANCHOR Button Navigation-->
            <div class="flex justify-center gap-2">
                <x-navigasi-peminjaman-alat></x-navigasi-peminjaman-alat>
            </div>
        </section>
        <section class="h-full overflow-y-scroll xl:rounded-xl xl:bg-white xl:shadow-md">
            <div class="flex flex-col xl:gap-0">
                <div
                    class="sticky top-0 z-10 hidden items-center border-b border-gray-400 bg-[#2D3648] text-white shadow xl:grid xl:grid-cols-[4%_25%_25%_25%_auto]">
                    <p
                        class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center text-xs xl:text-base">
                        No</p>
                    <p
                        class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center text-xs xl:text-base">
                        Nama Peminjam</p>
                    <p
                        class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center text-xs xl:text-base">
                        Nomor Transaksi</p>
                    <p
                        class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center text-xs xl:text-base">
                        Status Peminjaman</p>
                    <p class="flex h-full items-center justify-center px-2 py-2 text-center text-xs xl:text-base">
                        Detail</p>
                </div>

                @if (Auth::check() && Auth::user()->role == 'laboran')

                    @php
                        $sortedTransaction = collect($riwayatPeminjamanAlat)->sortByDesc('created_at');
                    @endphp
                    @foreach ($sortedTransaction as $riwayat)
                        <div x-data="{ isOpen: false }">

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

                                    <button class="rounded bg-[#2D3648] px-5 py-1 text-white" @click="isOpen = !isOpen">
                                        <x-heroicon-c-chevron-down
                                            class="h-4 w-4 transform transition-transform duration-300"
                                            x-bind:class="isOpen ? '-rotate-180' : ''" />
                                    </button>
                                </div>
                            </div>
                            <div x-show="isOpen" x-transition:enter="transition ease-out duration-300 transform"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-100 transform"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="glow-left grid grid-cols-[4%_25%_25%_25%_auto] border-l-4 border-l-emerald-400 p-2">
                                <div class=""></div>
                                <div>
                                    <h4 class="text-sm font-medium">Keperluan</h4>
                                    <p class="text-light text-[12px] text-gray-500">
                                        {{ $riwayat->relasiTransaksiAlat->keperluan }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium">No Handphone</h4>
                                    <p class="text-light text-[12px] text-gray-500">
                                        {{ $riwayat->relasiTransaksiAlat->relasiUser->phone_number }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium">Email</h4>
                                    <p class="text-light break-words text-[12px] text-gray-500">
                                        {{ $riwayat->relasiTransaksiAlat->relasiUser->email }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium">Kondisi Alat</h4>
                                    <p class="text-light text-[12px] capitalize text-gray-500">
                                        {{ $riwayat->kondisi_alat }}</p>
                                </div>
                                <hr class="col-span-5 my-2 border">
                                <div></div>
                                <div>
                                    <h4 class="text-sm font-medium">Nama Alat - No Unit</h4>
                                    <p class="text-light text-[12px] text-gray-500">
                                        {{ $riwayat->relasiTransaksiAlat->relasiUnit->unit->nama_alat }} -
                                        {{ $riwayat->relasiTransaksiAlat->relasiUnit->no_unit }}
                                    </p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium">Tanggal Pinjam</h4>
                                    <p class="text-light text-[12px] text-gray-500">
                                        {{ $riwayat->relasiTransaksiAlat->tanggal_pinjam }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium">Tanggal Kembali</h4>
                                    <p class="text-light text-[12px] text-gray-500">
                                        {{ $riwayat->relasiTransaksiAlat->tanggal_kembali }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium">Tanggal Dikembalikan</h4>
                                    <p class="text-light text-[12px] text-gray-500">
                                        {{ $riwayat->tanggal_pengembalian ?? '-' }}</p>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @endif

                @if (Auth::check() && Auth::user()->role == 'mahasiswa')
                    @php
                        $sortedTransaction = collect($riwayatMahasiswa)->sortByDesc('created_at');
                    @endphp
                    @foreach ($sortedTransaction as $riwayat)
                        <div x-data="{ isOpen: false }">

                            <div class="hidden border-b border-gray-400 xl:grid xl:grid-cols-[4%_25%_25%_25%_auto]">
                                <p class="border-r border-gray-400 px-2 py-2 text-center text-[11px] xl:text-base">
                                    {{ $loop->iteration }}</p>
                                <p class="border-r border-gray-400 px-2 py-2 text-[11px] xl:text-base">
                                    {{ $riwayat->relasiTransaksiAlat->relasiUser->name ?? 'User tidak ditemukan' }}</p>
                                <p class="break-words border-r border-gray-400 px-2 py-2 text-[11px] xl:text-base">
                                    {{ $riwayat->no_transaksi }}
                                </p>
                                <div class="border-r border-gray-400 px-2 py-2 text-center">
                                    <p
                                        class="{{ $riwayat->relasiTransaksiAlat->status == 'dikembalikan' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600' }} rounded text-[11px] xl:text-base">
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
                                    <button class="rounded bg-[#2D3648] px-2 text-white xl:px-5 xl:py-1"
                                        @click="isOpen = !isOpen">
                                        <x-heroicon-c-chevron-down
                                            class="size-4 transform transition-transform duration-300 xl:h-4 xl:w-4"
                                            x-bind:class="isOpen ? '-rotate-180' : ''" />
                                    </button>
                                </div>
                            </div>
                            <div x-show="isOpen" x-transition:enter="transition ease-out duration-300 transform"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-100 transform"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="glow-left hidden overflow-x-scroll border-l-4 border-l-emerald-400 p-2 xl:grid xl:grid-cols-[4%_25%_25%_25%_auto]">
                                <div class=""></div>
                                <div>
                                    <h4 class="text-[10px] font-medium xl:text-sm">Keperluan</h4>
                                    <p class="text-light text-[10px] text-gray-500 xl:text-[12px]">
                                        {{ $riwayat->relasiTransaksiAlat->keperluan }}</p>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-medium xl:text-sm">No Handphone</h4>
                                    <p class="text-light text-[10px] text-gray-500 xl:text-[12px]">
                                        {{ $riwayat->relasiTransaksiAlat->relasiUser->phone_number }}</p>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-medium xl:text-sm">Email</h4>
                                    <p class="text-light text-[10px] text-gray-500 xl:text-[12px]">
                                        {{ $riwayat->relasiTransaksiAlat->relasiUser->email }}</p>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-medium xl:text-sm">Kondisi Alat</h4>
                                    <p class="text-light text-[10px] capitalize text-gray-500 xl:text-[12px]">
                                        {{ $riwayat->kondisi_alat }}</p>
                                </div>
                                <hr class="col-span-5 my-2 border">
                                <div></div>
                                <div>
                                    <h4 class="text-[10px] font-medium xl:text-sm">Nama Alat - No Unit</h4>
                                    <p class="text-light text-[10px] text-gray-500 xl:text-[12px]">
                                        {{ $riwayat->relasiTransaksiAlat->relasiUnit->unit->nama_alat }} -
                                        {{ $riwayat->relasiTransaksiAlat->relasiUnit->no_unit }}
                                    </p>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-medium xl:text-sm">Tanggal Pinjam</h4>
                                    <p class="text-light text-[10px] text-gray-500 xl:text-[12px]">
                                        {{ $riwayat->relasiTransaksiAlat->tanggal_pinjam }}</p>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-medium xl:text-sm">Tanggal Kembali</h4>
                                    <p class="text-light text-[10px] text-gray-500 xl:text-[12px]">
                                        {{ $riwayat->relasiTransaksiAlat->tanggal_kembali }}</p>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-medium xl:text-sm">Tanggal Dikembalikan</h4>
                                    <p class="text-light text-[10px] text-gray-500 xl:text-[12px]">
                                        {{ $riwayat->tanggal_pengembalian ?? '-' }}</p>
                                </div>

                            </div>
                        </div>

                        <!-- ANCHOR Mobile View -->
                        <section class="mb-4 rounded-md bg-white shadow-md xl:hidden">
                            <header class="rounded-t-md bg-[#2D3648] p-2 text-white">
                                <h1 class="text-xs font-semibold">
                                    {{ $riwayat->relasiTransaksiAlat->relasiUnit->unit->nama_alat }}
                                </h1>
                                <span class="rounded-sm bg-emerald-400 p-[0.5px] text-[11px] text-black">
                                    {{ $riwayat->no_transaksi }}</span>
                            </header>
                            <article class="grid grid-cols-[40%_2%_50%] p-2 text-[11px]">
                                <p class="text-gray-500">No Unit</p>
                                <p>:</p>
                                <p>{{ $riwayat->relasiTransaksiAlat->relasiUnit->no_unit }}</p>
                                <p class="text-gray-500">Keperluan</p>
                                <p>:</p>
                                <p class="break-words"> {{ $riwayat->relasiTransaksiAlat->keperluan }}</p>
                                <p class="text-gray-500">Tanggal Pinjam</p>
                                <p>:</p>
                                <p>{{ $riwayat->relasiTransaksiAlat->tanggal_pinjam }}</p>
                                <p class="text-gray-500">Tanggal Kembali</p>
                                <p>:</p>
                                <p>{{ $riwayat->relasiTransaksiAlat->tanggal_kembali }}</p>
                                <p class="text-gray-500">Tanggal Dikembalikan</p>
                                <p>:</p>
                                <p class="text-light break-words text-[10px] text-gray-500 xl:text-[12px]">
                                    {{ $riwayat->tanggal_pengembalian ?? '-' }}</p>
                                <p class="text-gray-500">Kondisi Alat</p>
                                <p>:</p>
                                <p>
                                    {{ $riwayat->kondisi_alat }}</p>
                                <p class="text-gray-500">Status Peminjaman</p>
                                <p>:</p>
                                <p
                                    class="{{ $riwayat->relasiTransaksiAlat->status == 'pending' ? 'bg-gray-200 text-gray-600' : ($riwayat->relasiTransaksiAlat->status == 'dipinjam' ? 'bg-green-100 text-green-600' : ($riwayat->relasiTransaksiAlat->status == 'dikembalikan' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600')) }} w-fit rounded px-1 text-[11px]">
                                    @php
                                        $statusLabels = [
                                            'belum_dikembalikan' => 'Belum Dikembalikan',
                                            'dipinjam' => 'Dipinjam',
                                            'dikembalikan' => 'Dikembalikan',
                                            'terlambat_dikembalikan' => 'Terlambat Dikembalikan',
                                        ];
                                    @endphp
                                    {{ $statusLabels[$riwayat->relasiTransaksiAlat->status] ?? ucfirst($riwayat->relasiTransaksiAlat->status) }}
                                </p>
                            </article>
                        </section>
                    @endforeach
                @endif
            </div>
        </section>
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
</x-layout>
