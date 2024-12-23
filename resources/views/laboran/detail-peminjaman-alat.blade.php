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
    </main>
</x-layout>
