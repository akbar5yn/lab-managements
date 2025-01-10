<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>
    <main class="flex h-full flex-col gap-4">
        <!-- SECTION Button pengajuan / peminjaman-->
        <section class="flex max-w-full gap-4 rounded-xl bg-white p-4 shadow-md">
            <x-navigasi-peminjaman-alat></x-navigasi-peminjaman-alat>
        </section>

        <section class="h-full overflow-y-scroll rounded-xl bg-white shadow-md">
            <div class="">
                <div
                    class="sticky top-0 z-10 grid grid-cols-[4%_25%_30%_20%_auto] items-center border-b border-gray-400 bg-[#2D3648] text-white shadow">
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        No</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Nomor Transaksi</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Nama Peminjam</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Status Peminjaman</p>
                    <p class="flex h-full items-center justify-center px-2 py-2 text-center">
                        Aksi</p>
                </div>
                @foreach ($transaksiPeminjaman as $transaction)
                    <div x-data="{ isOpen: false }">
                        <div class="grid grid-cols-[4%_25%_30%_20%_auto] border-b border-gray-400">
                            <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $loop->iteration }}</p>
                            <p class="border-r border-gray-400 px-2 py-2">{{ $transaction->no_transaksi }}</p>
                            <p class="border-r border-gray-400 px-2 py-2">
                                {{ $transaction->relasiUser->name ?? 'User tidak ditemukan' }}</p>
                            <div class="border-r border-gray-400 px-2 py-2 text-center">
                                <p
                                    class="{{ $transaction->status == 'dipinjam' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} rounded">
                                    @php
                                        $statusLabels = [
                                            'dipinjam' => 'Dipinjam',
                                            'terlambat_dikembalikan' => 'Terlambat Dikembalikan',
                                        ];
                                    @endphp
                                    {{ $statusLabels[$transaction->status] ?? ucfirst($transaction->status) }}
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
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100 transform"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="glow-left grid grid-cols-[4%_25%_30%_20%_auto] border-l-4 border-l-emerald-400 p-2">
                            <div class=""></div>
                            <div>
                                <h4 class="text-sm font-medium">Nama Alat - No Unit</h4>
                                <p class="text-light text-[12px] text-gray-500">
                                    {{ $transaction->relasiUnit->unit->nama_alat }} -
                                    {{ $transaction->relasiUnit->no_unit }}
                                </p>

                            </div>
                            <div>
                                <h4 class="text-sm font-medium">Keperluan</h4>
                                <p class="text-light text-[12px] text-gray-500">
                                    {{ $transaction->keperluan }}</p>

                            </div>
                            <div>
                                <h4 class="text-sm font-medium">Tanggal Pinjam</h4>
                                <p class="text-light text-[12px] text-gray-500">
                                    {{ $transaction->tanggal_pinjam }}</p>

                            </div>
                            <div>
                                <h4 class="text-sm font-medium">Tanggal Kembali</h4>
                                <p class="text-light text-[12px] text-gray-500">
                                    {{ $transaction->tanggal_kembali }}</p>
                            </div>
                            <hr class="col-span-5 my-2 border">
                            <div></div>
                            <div>
                                <h4 class="text-sm font-medium">No Handphone</h4>
                                <p class="text-light text-[12px] text-gray-500">
                                    {{ $transaction->relasiUser->phone_number }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium">Email</h4>
                                <p class="text-light break-words text-[12px] text-gray-500">
                                    {{ $transaction->relasiUser->email }}</p>
                            </div>
                            <div class="col-span-2 flex items-center">
                                <x-modal attributeTitle="Verifikasi pengembalian alat"
                                    attributeButton="Verifikasi Pengembalian">
                                    <form action="{{ route('post.riwayat.transaksi.alat') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" min="0" name="no_transaksi" id="no_transaksi"
                                            required value="{{ $transaction->no_transaksi }}">
                                        <div class="flex flex-col gap-6 rounded-lg border p-4">

                                            <div
                                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                                <label for="tgl_pengembalian font-semibold">Tanggal Pengembalian</label>
                                                <input type="date" id="tgl_pengembalian" name="tgl_pengembalian"
                                                    class="border-none p-0 capitalize focus:outline-none focus:ring-0"
                                                    placeholder="Masukan tanggal">
                                            </div>

                                            <div x-data="{ isOpen: false, status: 'normal' }" class="relative inline-block w-full text-left">
                                                <!-- Input -->
                                                <div
                                                    class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                                    <label for="kondisi_alat font-semibold">Kondisi Alat</label>
                                                    <div class="flex w-full items-center">
                                                        <input type="text"
                                                            class="w-full cursor-pointer border-none p-0 capitalize focus:outline-none focus:ring-0"
                                                            name="kondisi_alat" id="kondisi_alat" x-model="status"
                                                            @click="isOpen = !isOpen" readonly>
                                                        <x-heroicon-c-chevron-down
                                                            class="absolute right-10 h-4 w-4 transform transition-transform duration-300"
                                                            x-bind:class="isOpen ? '-rotate-180' : ''" />
                                                    </div>
                                                </div>

                                                <!-- Dropdown -->
                                                <div x-show="isOpen" @click.outside="isOpen = false"
                                                    x-transition:enter="transition ease-out duration-100 transform"
                                                    x-transition:enter-start="opacity-0 scale-95"
                                                    x-transition:enter-end="opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-75 transform"
                                                    x-transition:leave-start="opacity-100 scale-100"
                                                    x-transition:leave-end="opacity-0 scale-95"
                                                    class="absolute left-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                    role="menu" aria-orientation="vertical"
                                                    aria-labelledby="menu-button" tabindex="-1">
                                                    <div class="w-full py-1" role="none">
                                                        <!-- Button Normal -->
                                                        <button type="button"
                                                            @click="status = 'normal'; isOpen = false"
                                                            class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100"
                                                            role="menuitem">
                                                            Normal
                                                        </button>

                                                        <!-- Button Rusak -->
                                                        <button type="button" @click="status = 'rusak'; isOpen = false"
                                                            class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100"
                                                            role="menuitem">
                                                            Rusak
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center">

                                            <button type="submit"
                                                class="mt-2 w-full rounded border border-[#559f86] bg-[#d0f1e6] px-5 text-center">Submit</button>
                                        </div>

                                    </form>
                                </x-modal>
                            </div>
                        </div>
                    </div>
                @endforeach
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#tgl_pengembalian", {
                minDate: "today", // Batasan tanggal minimal
                dateFormat: "Y-m-d", // Format tanggal
            });
        });
    </script>
</x-layout>
