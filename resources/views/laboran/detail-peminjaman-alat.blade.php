<x-layout>
    <x-slot:title>
        <a href="{{ route('peminjaman.alat.berlangsung') }}">
            {{ $title }}
        </a>
    </x-slot:title>
    <x-slot:role>{{ $role }}</x-slot:role>
    <x-slot:name>{{ $name }}</x-slot:name>

    <x-slot:subtitle>{{ $subtitle }}</x-slot:subtitle>
    <!--TODO Tambahkan halaman detail peminjaman untuk tiap peminjam nya agar menampilkan data (tanggal pinjam/kembali, Nama Peminjam, Barang dipinjam, no hp, email, keperluan, stauts peminjaman)-->

    <main class="relative h-full rounded-xl bg-white p-4 shadow-md">
        <!-- ANCHOR Informasi Peminjaman-->
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

        <!-- ANCHOR Informasi Alat -->
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
                Status Peminjaman</p>
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

        <!-- ANCHOR Verifikasi Pengembalian-->
        <h1 class="mb-5 mt-10 text-lg font-medium">Verifikasi Pengembalian</h1>
        <div
            class="sticky top-0 z-10 grid grid-cols-[40%_40%_20%] items-center border-b border-gray-400 bg-[#e4e4e4] shadow">
            <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                Tanggal Pengembalian</p>
            <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                Kondisi Alat</p>
            <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                Aksi</p>
        </div>

        <form action="{{ route('post.riwayat.transaksi.alat') }}" method="POST" class="grid grid-cols-[40%_40%_20%]">
            @csrf
            @method('POST')
            <input type="hidden" min="0" name="no_transaksi" id="no_transaksi" required
                value="{{ $transaksi->no_transaksi }}">
            <input type="date" id="tgl_pengembalian" name="tgl_pengembalian"
                class="border-gray-400 focus-within:border-[#2D3648] focus:ring-0"
                placeholder="Tanggal pengembalian....">
            <div x-data="{ isOpen: false, status: 'normal' }" class="relative inline-block w-full text-left">
                <!-- Input -->
                <div class="flex w-full items-center">
                    <input type="text"
                        class="w-full cursor-pointer border-gray-400 focus-within:border-[#2D3648] focus:ring-0"
                        name="kondisi_alat" id="kondisi_alat" x-model="status" @click="isOpen = !isOpen" readonly>
                    <x-heroicon-c-chevron-down
                        class="absolute right-10 h-4 w-4 transform transition-transform duration-300"
                        x-bind:class="isOpen ? '-rotate-180' : ''" />
                </div>

                <!-- Dropdown -->
                <div x-show="isOpen" @click.outside="isOpen = false"
                    x-transition:enter="transition ease-out duration-100 transform"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75 transform"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute left-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                    role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="w-full py-1" role="none">
                        <!-- Button Normal -->
                        <button type="button" @click="status = 'normal'; isOpen = false"
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
            <div class="flex items-center justify-center border border-gray-400">

                <button type="submit"
                    class="rounded-lg border border-[#559f86] bg-[#d0f1e6] px-5 text-center">Submit</button>
            </div>

        </form>
    </main>
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#tgl_pengembalian", {
            minDate: "today", // Batasan tanggal minimal
            dateFormat: "Y-m-d", // Format tanggal
        });
    });
</script>
