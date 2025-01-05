<x-layout>
    <x-slot:title>
        <a href="{{ route('riwayat.peminjaman.alat') }}">
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
            <div class="border-r border-gray-400 px-2 py-2 text-center">
                <p
                    class="{{ $transaksi->status == 'dikembalikan' ? 'bg-green-200 text-green-600' : ($transaksi->status == 'expire' ? 'bg-red-200 text-red-600' : 'bg-red-200 text-red-600') }} rounded">
                    @php
                        $statusLabels = [
                            'pending' => 'Pending',
                            'dikembalikan' => 'Dikembalikan',
                        ];
                    @endphp
                    {{ $statusLabels[$transaksi->status] ?? ucfirst($transaksi->status) }}
                </p>
            </div>
        </div>

        <!-- ANCHOR Verifikasi Pengembalian-->
        <h1 class="mb-5 mt-10 text-lg font-medium">Informasi Pengembalian</h1>
        <div
            class="sticky top-0 z-10 grid grid-cols-[50%_50%] items-center border-b border-gray-400 bg-[#e4e4e4] shadow">
            <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                Tanggal Pengembalian</p>
            <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                Kondisi Alat</p>
        </div>
        <div class="grid grid-cols-[50%_50%] border-b border-gray-400">
            <p class="border-x border-gray-400 px-2 py-2">
                {{ $transaksi->relasiRiwayatTransaksi->tanggal_pengembalian ?? '-' }}
            </p>
            <div class="border-r border-gray-400 px-2 py-2 text-center">
                <p class="rounded bg-green-200 text-green-600">
                    @php
                        $statusLabels = [
                            'normal' => 'Normal',
                        ];
                    @endphp
                    {{ $statusLabels[$transaksi->relasiRiwayatTransaksi->kondisi_alat] ?? ucfirst($transaksi->relasiRiwayatTransaksi->kondisi_alat) }}
                </p>
            </div>
        </div>
    </main>
</x-layout>
