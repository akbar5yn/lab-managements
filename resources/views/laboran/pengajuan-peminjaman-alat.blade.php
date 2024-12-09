<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>
    <main class="flex h-full flex-col gap-4">
        <!-- SECTION Button pengajuan / peminjaman-->
        <section class="flex max-w-full gap-4 rounded-xl bg-white p-4 shadow-md">
            <a href="{{ route('pengajuan.peminjaman.alat') }}"
                class="{{ request()->is('laboran/peminjaman-alat/pengajuan') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} rounded-lg px-4 py-2">Pengajuan</a>
            <a href="{{ route('peminjaman.alat.berlangsung') }}"
                class="{{ request()->is('laboran/peminjaman-alat/berlangsung') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} rounded-lg px-4 py-2">Berlangsung</a>
        </section>

        <section class="h-full overflow-y-scroll rounded-xl bg-white shadow-md">
            <div class="p-4">
                <div
                    class="sticky top-0 z-10 grid grid-cols-[4%_25%_20%_20%_auto] items-center border-b border-gray-400 bg-[#e4e4e4] shadow">
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        No</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Nama Peminjaman</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        No Transaksi</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Email</p>
                    <p class="flex h-full items-center justify-center px-2 py-2 text-center">
                        Aksi</p>
                </div>

                @foreach ($transaksiPengajuanPeminjaman as $transaction)
                    <div class="grid grid-cols-[4%_25%_20%_20%_auto] border-b border-gray-400">
                        <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $loop->iteration }}</p>
                        <p class="border-r border-gray-400 px-2 py-2">
                            {{ $transaction->relasiUser->name ?? 'User tidak ditemukan' }}</p>
                        <p class="border-r border-gray-400 px-2 py-2">{{ $transaction->no_transaksi }}</p>
                        <p class="border-r border-gray-400 px-2 py-2">
                            {{ $transaction->relasiUser->email }}</p>
                        <div class="flex items-center justify-center gap-5">
                            <a href="{{ route('detail.pengajuan.alat', ['slug' => $transaction->no_transaksi]) }}"
                                class="rounded bg-blue-400 px-2 text-white">Detail</a>
                            <div class="flex gap-2" x-data="{ showTolak: false, showSetujui: false, isDisabled: true }">
                                <!-- Tombol Tolak dengan Tooltip -->
                                <div class="group relative">
                                    <button type="button" :disabled="isDisabled"
                                        @mouseenter="isDisabled && (showTolak = true)" @mouseleave="showTolak = false"
                                        class="rounded-md border border-[#9f5555] bg-[#f1d0d0] px-2 disabled:border-none disabled:bg-gray-200 disabled:text-gray-500">
                                        Tolak
                                    </button>
                                    <!-- Tooltip -->
                                    <div x-show="showTolak" x-transition:enter="transition-opacity duration-300"
                                        x-transition:leave="transition-opacity duration-300"
                                        class="absolute bottom-full right-0 z-50 mb-2 w-[200px] rounded bg-black px-2 py-1 text-center text-[10px] text-white opacity-0 transition-opacity duration-300 ease-in-out group-hover:opacity-100">
                                        Tombol akan aktif setelah mahasiswa melakukan scan barcode
                                        <div
                                            class="absolute right-8 top-full h-0 w-0 border-l-8 border-r-8 border-t-8 border-l-transparent border-r-transparent border-t-black">
                                        </div>
                                    </div>

                                </div>

                                <!-- Tombol Setujui dengan Tooltip -->
                                <div class="group relative">
                                    <button type="button" :disabled="isDisabled"
                                        @mouseenter="isDisabled && (showSetujui = true)"
                                        @mouseleave="showSetujui = false"
                                        class="rounded-md border border-[#559f86] bg-[#d0f1e6] px-2 disabled:border-none disabled:bg-gray-200 disabled:text-gray-500">
                                        Setujui
                                    </button>
                                    <!-- Tooltip -->
                                    <div x-show="showSetujui" x-transition:enter="transition-opacity duration-300"
                                        x-transition:leave="transition-opacity duration-300"
                                        class="absolute bottom-full right-0 z-50 mb-2 w-[200px] rounded bg-black px-2 py-1 text-center text-[10px] text-white opacity-0 transition-opacity duration-300 ease-in-out group-hover:opacity-100">
                                        Tombol akan aktif setelah mahasiswa melakukan scan barcode
                                        <div
                                            class="absolute right-10 top-full h-0 w-0 border-l-8 border-r-8 border-t-8 border-l-transparent border-r-transparent border-t-black">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
</x-layout>
