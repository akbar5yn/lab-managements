<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>
    <main class="flex h-full flex-col gap-4">
        <!-- SECTION Button pengajuan / peminjaman-->
        <section class="flex max-w-full justify-between rounded-xl bg-white p-4 shadow-md">
            <div class="flex gap-4">
                <x-navigasi-peminjaman-alat></x-navigasi-peminjaman-alat>
            </div>
            <a href="{{ route('qrcode.page') }}"
                class="{{ request()->is('laboran/qrcode') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} rounded-lg px-4 py-2">QR
                Code</a>

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

                @foreach ($transaksiPengajuanPeminjaman as $transaction)
                    <div x-data="{ isOpen: false }">

                        <div class="grid grid-cols-[4%_25%_30%_20%_auto] border-b border-gray-400">
                            <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $loop->iteration }}</p>
                            <p class="border-r border-gray-400 px-2 py-2">{{ $transaction->no_transaksi }}</p>
                            <p class="border-r border-gray-400 px-2 py-2">
                                {{ $transaction->relasiUser->name ?? 'User tidak ditemukan' }}</p>
                            <div class="border-r border-gray-400 px-2 py-2 text-center">
                                <p class="rounded bg-gray-200 text-gray-600">
                                    @php
                                        $statusLabels = [
                                            'pending' => 'Pending',
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
</x-layout>
