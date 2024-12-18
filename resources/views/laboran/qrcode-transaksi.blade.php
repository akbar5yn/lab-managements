<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>

    <main class="flex h-full flex-col gap-4 overflow-y-scroll">

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

        <h1>QR Code untuk Transaksi Pending</h1>

        @if (isset($message))
            <p>{{ $message }}</p>
        @else
            <div class="qr-code">
                {!! $qrCode !!}
            </div>

            <p><strong>Bagikan QR Code kepada mahasiswa untuk melakukan validasi pengajuan peminjaman</strong></p>
        @endif
    </main>
</x-layout>
