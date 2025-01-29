@if (Auth::check() && Auth::user()->role == 'laboran')
    <a href="{{ route('pengajuan.peminjaman.alat') }}"
        class="{{ request()->is('laboran/peminjaman-alat/pengajuan') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} rounded-lg px-4 py-2">Pengajuan</a>
    <a href="{{ route('peminjaman.alat.berlangsung') }}"
        class="{{ request()->is('laboran/peminjaman-alat/berlangsung') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} rounded-lg px-4 py-2">Berlangsung</a>
    <a href="{{ route('riwayat.peminjaman.alat') }}"
        class="{{ request()->is('riwayat-peminjaman-alat') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} rounded-lg px-4 py-2">Riwayat</a>
@endif

@if (Auth::check() && Auth::user()->role == 'mahasiswa')
    <a href="{{ route('informasi.alat') }}"
        class="{{ request()->is('mahasiswa/informasi-alat') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} w-fit rounded-lg px-1 py-1 text-[12px] font-medium shadow-sm xl:text-lg">
        Informasi Alat
    </a>
    <a href="{{ route('aktivitas.peminjaman') }}"
        class="{{ request()->is('mahasiswa/peminjaman-alat/aktifitas*') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} w-fit rounded-lg border px-1 py-1 text-[12px] font-medium shadow-sm xl:text-lg">
        Aktivitas Peminjaman
    </a>
    <a href="{{ route('riwayat.peminjaman.alat') }}"
        class="{{ request()->is('riwayat-peminjaman-alat') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} rounded-lg px-1 py-1 text-[12px] font-medium xl:text-lg">Riwayat</a>
@endif
