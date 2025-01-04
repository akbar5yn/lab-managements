<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>
    <main class="flex h-full flex-col gap-4">
        <!-- SECTION Button pengajuan / peminjaman-->
        <section class="flex max-w-full justify-between rounded-xl bg-white p-4 shadow-md">
            <div class="flex gap-4">
                <a href="{{ route('pengajuan.peminjaman.alat') }}"
                    class="{{ request()->is('laboran/peminjaman-alat/pengajuan') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} rounded-lg px-4 py-2">Pengajuan</a>
                <a href="{{ route('peminjaman.alat.berlangsung') }}"
                    class="{{ request()->is('laboran/peminjaman-alat/berlangsung') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} rounded-lg px-4 py-2">Berlangsung</a>
            </div>
            <a href="{{ route('qrcode.page') }}"
                class="{{ request()->is('laboran/qrcode') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} rounded-lg px-4 py-2">QR
                Code</a>

        </section>

        <section class="h-full overflow-y-scroll rounded-xl bg-white shadow-md">
            <div class="p-4">
                <div
                    class="sticky top-0 z-10 grid grid-cols-[4%_25%_30%_20%_auto] items-center border-b border-gray-400 bg-[#e4e4e4] shadow">
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        No</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Nama Peminjaman</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Nomor Transaksi</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Status Peminjaman</p>
                    <p class="flex h-full items-center justify-center px-2 py-2 text-center">
                        Aksi</p>
                </div>

                @foreach ($transaksiPengajuanPeminjaman as $transaction)
                    <div class="grid grid-cols-[4%_25%_30%_20%_auto] border-b border-gray-400">
                        <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $loop->iteration }}</p>
                        <p class="border-r border-gray-400 px-2 py-2">
                            {{ $transaction->relasiUser->name ?? 'User tidak ditemukan' }}</p>
                        <p class="border-r border-gray-400 px-2 py-2">{{ $transaction->no_transaksi }}
                        </p>
                        <div class="border-r border-gray-400 px-2 py-2 text-center">
                            <p
                                class="{{ $transaction->status == 'pending' ? 'bg-gray-200 text-gray-600' : ($transaction->status == 'dipinjam' ? 'bg-green-100 text-green-600' : ($transaction->status == 'dikembalikan' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600')) }} rounded px-2 py-1">
                                @php
                                    $statusLabels = [
                                        'belum_dikembalikan' => 'Belum Dikembalikan',
                                        'dipinjam' => 'Dipinjam',
                                        'dikembalikan' => 'Dikembalikan',
                                        'terlambat_dikembalikan' => 'Terlambat Dikembalikan',
                                    ];
                                @endphp
                                {{ $statusLabels[$transaction->status] ?? ucfirst($transaction->status) }}
                            </p>
                        </div>
                        <div class="flex items-center justify-center gap-5">
                            <a href="{{ route('detail.pengajuan.alat', ['slug' => $transaction->no_transaksi]) }}"
                                class="rounded bg-blue-400 px-2 text-white">Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
</x-layout>
