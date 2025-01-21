<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:role>{{ $role }}</x-slot:role>
    <x-slot:name>{{ $name }}</x-slot:name>
    <div class="flex h-full flex-col gap-4">
        <!-- ANCHOR Over View -->
        <section class="flex max-w-full flex-col gap-4 rounded-xl bg-[#FFFFFF] p-4 shadow-md">
            <h2 class="text-lg font-medium">Over View</h2>
            <article class="ml-4 flex snap-x snap-start scroll-pl-2 gap-10 overflow-x-scroll pb-2">
                <div
                    class="border-1 flex min-w-fit snap-start items-center gap-5 rounded-xl border border-[#559f86] bg-[#d0f1e673] p-2 backdrop-brightness-200">
                    <div class="min-h-fit rounded-md border border-[#559f86] bg-[#d0f1e6] p-3">
                        <x-heroicon-s-users class="w-6" />
                    </div>
                    <div>
                        <p class="font-semi-bold text-xl font-semibold">{{ $totalMhs }}</p>
                        <p class="text-sm text-gray-600">Mahasiswa</p>
                    </div>
                </div>
                <div
                    class="border-1 flex min-w-fit snap-start items-center gap-5 rounded-xl border border-[#559f86] bg-[#d0f1e673] p-2 backdrop-brightness-200">
                    <div class="min-h-fit rounded-md border border-[#559f86] bg-[#d0f1e6] p-3">
                        <x-heroicon-s-cube class="w-6" />
                    </div>
                    <div>
                        <p class="font-semi-bold text-xl font-semibold">{{ $totalUnit }}</p>
                        <p class="text-sm text-gray-600">Total Unit Barang</p>
                    </div>
                </div>
                <div
                    class="border-1 flex min-w-fit snap-start items-center gap-5 rounded-xl border border-[#559f86] bg-[#d0f1e673] p-2 backdrop-brightness-200">
                    <div class="min-h-fit rounded-md border border-[#559f86] bg-[#d0f1e6] p-3">
                        <x-heroicon-s-square-3-stack-3d class="w-6" />
                    </div>
                    <div>
                        <p class="font-semi-bold text-xl font-semibold">{{ $totalPengajuan }}</p>
                        <p class="text-sm text-gray-600">Pengajuan Peminjaman <br> Alat & Barang</p>
                    </div>
                </div>
                <div
                    class="border-1 flex min-w-fit snap-start items-center gap-5 rounded-xl border border-[#559f86] bg-[#d0f1e673] p-2 backdrop-brightness-200">
                    <div class="min-h-fit rounded-md border border-[#559f86] bg-[#d0f1e6] p-3">
                        <x-heroicon-s-inbox-arrow-down class="w-6" />
                    </div>
                    <div>
                        <p class="font-semi-bold text-xl font-semibold">{{ $totalPeminjaman }}</p>
                        <p class="text-sm text-gray-600">Peminjaman <br> Alat & Barang Berlangsung</p>
                    </div>
                </div>
                <div
                    class="border-1 flex min-w-fit snap-start items-center gap-5 rounded-xl border border-[#edbca0] bg-[#F7F4F3] p-2 backdrop-brightness-200">
                    <div class="flex min-h-fit items-center rounded-md border border-[#edbca0] bg-[#F1DCD0] p-3">
                        <x-heroicon-s-wrench-screwdriver class="w-6" />
                    </div>
                    <div>
                        <p class="font-semi-bold text-xl font-semibold">{{ $unitRusak }}</p>
                        <p class="text-sm text-gray-600">Alat / Barang Rusak</p>
                    </div>
                </div>
            </article>
        </section>

        <div class="grid h-full grid-cols-2 gap-5 overflow-y-hidden pb-1">

            <!-- ANCHOR Penggunaan alat dan barang -->
            <section
                class="sticky top-0 flex h-full max-w-full flex-col gap-4 overflow-y-scroll rounded-xl bg-[#FFFFFF] p-4 shadow-md">
                <h2 class="text-lg font-medium">Informasi Pengajuan Alat & Barang</h2>

                <!-- ANCHOR Table -->
                <section class="flex h-full flex-col gap-5 overflow-y-scroll">
                    <div
                        class="sticky top-0 z-10 grid grid-cols-[4%_48%_48%] items-center rounded-md border-b border-gray-400 bg-[#2D3648] text-sm text-white shadow">
                        <p
                            class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                            No</p>
                        <p
                            class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                            Nama Peminjam</p>
                        <p class="flex h-full items-center justify-center px-2 py-2 text-center">
                            Nama Alat</p>

                    </div>
                    @if ($transaksiPengajuanPeminjaman)
                        @foreach ($transaksiPengajuanPeminjaman as $pengajuan)
                            <div
                                class="calendar-button grid w-full grid-cols-[4%_48%_48%] items-center rounded-md border border-gray-400 text-sm shadow">
                                <span class="border-r border-gray-400 p-2">{{ $loop->iteration }}</span>
                                <span class="border-r border-gray-400 p-2">{{ $pengajuan->relasiUser->name }}</span>
                                <span class="p-2">{{ $pengajuan->relasiUnit->unit->nama_alat }}
                                </span>
                            </div>
                        @endforeach
                    @else
                        <div
                            class="grid grid-cols-[4%_48%_48%] rounded-md border border-gray-500 p-1 text-center text-sm">
                            <p class="col-span-3 text-gray-500">Tidak ada transaksi pengajuan peminjaman yang sedang
                                berlangsung.
                            </p>
                        </div>
                    @endif
                </section>
            </section>
            <section
                class="sticky top-0 flex h-full max-w-full flex-col gap-4 overflow-y-scroll rounded-xl bg-[#FFFFFF] p-4 shadow-md">
                <h2 class="text-lg font-medium">Informasi Penggunaan Alat & Barang</h2>



                <!-- ANCHOR Table -->
                <section class="flex h-full flex-col gap-5 overflow-y-scroll">
                    <div
                        class="sticky top-0 z-10 grid grid-cols-[4%_48%_48%] items-center rounded-md border-b border-gray-400 bg-[#2D3648] text-sm text-white shadow">
                        <p
                            class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                            No</p>
                        <p
                            class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                            Nama Peminjam</p>
                        <p class="flex h-full items-center justify-center px-2 py-2 text-center">
                            Nama Alat</p>

                    </div>
                    @if ($transaksiPeminjaman)
                        @foreach ($transaksiPeminjaman as $peminjaman)
                            <div
                                class="calendar-button grid w-full grid-cols-[4%_48%_48%] items-center rounded-md border border-gray-400 text-sm shadow">
                                <span class="border-r border-gray-400 p-2">{{ $loop->iteration }}</span>
                                <span class="border-r border-gray-400 p-2">{{ $peminjaman->relasiUser->name }}</span>
                                <span class="p-2">{{ $peminjaman->relasiUnit->unit->nama_alat }}
                                </span>
                            </div>
                        @endforeach
                    @else
                        <div
                            class="grid grid-cols-[4%_48%_48%] rounded-md border border-gray-500 p-1 text-center text-sm">
                            <p class="col-span-3 text-gray-500">Tidak ada transaksi peminjaman yang sedang berlangsung.
                            </p>
                        </div>
                    @endif
                </section>
            </section>
        </div>
    </div>
</x-layout>
