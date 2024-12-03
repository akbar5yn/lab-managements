<x-layout>
    <x-slot:title>
        <a href="{{ route('pengajuan.peminjaman.alat') }}">
            {{ $title }}
        </a>
    </x-slot:title>
    <x-slot:role>{{ $role }}</x-slot:role>
    <x-slot:name>{{ $name }}</x-slot:name>

    <x-slot:subtitle>{{ $subtitle }}</x-slot:subtitle>
    <!--TODO Tambahkan halaman detail peminjaman untuk tiap peminjam nya agar menampilkan data (tanggal pinjam/kembali, Nama Peminjam, Barang dipinjam, no hp, email, keperluan, stauts peminjaman)-->

    <main class="relative h-full rounded-xl bg-white p-4 shadow-md">
        <h1 class="mb-5 text-lg font-medium">Informasi Peminjam</h1>
        <div
            class="sticky top-0 z-10 grid grid-cols-[25%_25%_25%_auto] items-center border-b border-gray-400 bg-[#e4e4e4] shadow">
            <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                Nama Peminjam</p>

            <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                Keperluan Peminjaman</p>

            <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                No Handphone</p>
            <p class="flex h-full items-center justify-center px-2 py-2 text-center">
                Email</p>
        </div>
        <div class="grid grid-cols-[25%_25%_25%_auto] border-b border-gray-400">
            <p class="border-x border-gray-400 px-2 py-2">{{ $transaksi->relasiUser->name }}</p>
            <p class="border-r border-gray-400 px-2 py-2">{{ $transaksi->keperluan }}</p>
            <p class="border-r border-gray-400 px-2 py-2">{{ $transaksi->relasiUser->phone_number }}</p>
            <p class="border-r border-gray-400 px-2 py-2">{{ $transaksi->relasiUser->email }}</p>
        </div>

        <h1 class="mb-5 mt-10 text-lg font-medium">Informasi Alat</h1>

        <div
            class="sticky top-0 z-10 grid grid-cols-[25%_25%_25%_auto] items-center border-b border-gray-400 bg-[#e4e4e4] shadow">
            <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                Barang Dipinjam</p>

            <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                Tanggal Pinjam</p>

            <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                Tanggal Kembali</p>
            <p class="flex h-full items-center justify-center px-2 py-2 text-center">
                Status</p>
        </div>
        <div class="grid grid-cols-[25%_25%_25%_auto] border-b border-gray-400">
            <p class="border-x border-gray-400 px-2 py-2">
                {{ $transaksi->relasiUnit->unit->nama_alat }}</p>
            <p class="border-r border-gray-400 px-2 py-2">{{ $transaksi->tanggal_pinjam }}</p>
            <p class="border-r border-gray-400 px-2 py-2">{{ $transaksi->tanggal_kembali }}</p>
            <p class="border-r border-gray-400 px-2 py-2 text-center">
                <span
                    class="{{ $transaksi->status == 'pending' ? 'bg-gray-200 text-gray-600' : ($transaksi->status == 'dipinjam' ? 'bg-green-100 text-green-600' : ($transaksi->status == 'dikembalikan' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600')) }} rounded px-2 py-1">
                    @php
                        $statusLabels = [
                            'belum_dikembalikan' => 'Belum Dikembalikan',
                            'dipinjam' => 'Dipinjam',
                            'dikembalikan' => 'Dikembalikan',
                            'terlambat_dikembalikan' => 'Terlambat Dikembalikan',
                        ];
                    @endphp
                    {{ $statusLabels[$transaksi->status] ?? ucfirst($transaksi->status) }}
                </span>
            </p>
        </div>
        <div class="absolute bottom-10 right-10 flex gap-2" x-data="{ showTolak: false, showSetujui: false, isDisabled: true }">
            <!-- Tombol Tolak dengan Tooltip -->
            <div class="group relative" @mouseenter="isDisabled && (showTolak = true)" @mouseleave="showTolak = false">
                <button type="button" :disabled="isDisabled"
                    class="rounded-md border border-[#9f5555] bg-[#f1d0d0] px-5 py-1 disabled:border-none disabled:bg-gray-200 disabled:text-gray-500">
                    Tolak
                </button>
                <!-- Tooltip -->
                <div x-show="showTolak" x-transition:enter="transition-opacity duration-300"
                    x-transition:leave="transition-opacity duration-300"
                    class="absolute bottom-full right-0 mb-2 w-[200px] rounded bg-black px-2 py-1 text-center text-sm text-white opacity-0 transition-opacity duration-300 ease-in-out group-hover:opacity-100">
                    Tombol akan aktif setelah mahasiswa melakukan scan barcode
                    <div
                        class="absolute right-8 top-full h-0 w-0 border-l-8 border-r-8 border-t-8 border-l-transparent border-r-transparent border-t-black">
                    </div>
                </div>

            </div>

            <!-- Tombol Setujui dengan Tooltip -->
            <div class="group relative" @mouseenter="isDisabled && (showSetujui = true)"
                @mouseleave="showSetujui = false">
                <button type="button" :disabled="isDisabled"
                    class="rounded-md border border-[#559f86] bg-[#d0f1e6] px-5 py-1 disabled:border-none disabled:bg-gray-200 disabled:text-gray-500">
                    Setujui
                </button>
                <!-- Tooltip -->
                <div x-show="showSetujui" x-transition:enter="transition-opacity duration-300"
                    x-transition:leave="transition-opacity duration-300"
                    class="absolute bottom-full right-0 mb-2 w-[200px] rounded bg-black px-2 py-1 text-center text-sm text-white opacity-0 transition-opacity duration-300 ease-in-out group-hover:opacity-100">
                    Tombol akan aktif setelah mahasiswa melakukan scan barcode
                    <div
                        class="absolute right-10 top-full h-0 w-0 border-l-8 border-r-8 border-t-8 border-l-transparent border-r-transparent border-t-black">
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
