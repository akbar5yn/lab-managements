<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>
    <main class="flex h-full flex-col gap-4 overflow-y-scroll">
        <!-- SECTION Show Alat-->
        <section>
            <!-- ANCHOR Button Navigation-->
            <div class="flex gap-2">
                <a href="{{ route('informasi.alat') }}"
                    class="{{ request()->is('mahasiswa/peminjaman-alat/informasi') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} w-fit rounded-lg px-2 py-1 text-lg font-medium shadow-sm">
                    Informasi Alat
                </a>
                <a href="{{ route('aktivitas.peminjaman') }}"
                    class="{{ request()->is('mahasiswa/peminjaman-alat/aktifitas') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} w-fit rounded-lg px-2 py-1 text-lg font-medium shadow-sm">
                    Aktivitas Peminjaman
                </a>
            </div>
        </section>
        <section class="relative flex h-full max-w-full flex-col rounded-xl bg-[#FFFFFF] p-4 shadow-md">
            <h1 class="mb-5 text-lg font-medium">Detail Aktifitas Peminjaman</h1>
            <table class="table-auto border-collapse rounded-md">
                <thead>
                    <tr>
                        <th class="... w-[50%] border-b border-slate-300 text-left">Keterangan</th>
                        <th class="... border-b border-slate-300 text-left">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactionDetails as $transaction)
                        <tr>
                            <td class="border-b border-slate-300 py-2">ID Transaksi</td>
                            <td class="border-b border-slate-300 py-2">NE-20244901</td>
                        </tr>
                        <tr>
                            <td class="border-b border-slate-300 py-2">Nama Alat</td>
                            <td class="border-b border-slate-300 py-2">{{ $transaction->relasiUnit->unit->nama_alat }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border-b border-slate-300 py-2">Keperluan</td>
                            <td class="border-b border-slate-300 py-2">{{ $transaction->keperluan }} Lorem ipsum dolor
                                sit amet consectetur adipisicing elit. Cupiditate, reprehenderit?</td>
                        </tr>
                        <tr>
                            <td class="border-b border-slate-300 py-2">Tanggal Pinjam</td>
                            <td class="border-b border-slate-300 py-2">{{ $transaction->tanggal_pinjam }}</td>
                        </tr>
                        <tr>
                            <td class="border-b border-slate-300 py-2">Tanggal Kembali</td>
                            <td class="border-b border-slate-300 py-2">{{ $transaction->tanggal_kembali }}</td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </section>
</x-layout>
