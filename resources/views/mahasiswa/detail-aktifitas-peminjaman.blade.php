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
                    class="{{ request()->is('mahasiswa/peminjaman-alat/aktifitas*') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} w-fit rounded-lg px-2 py-1 text-lg font-medium shadow-sm">
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
                            <td class="border-b border-slate-300 py-2">No Transaksi</td>
                            <td class="w-full break-words border-b border-slate-300 py-2">
                                {{ $transaction->no_transaksi }}</td>
                        </tr>
                        <tr>
                            <td class="border-b border-slate-300 py-2">Nama Alat</td>
                            <td class="border-b border-slate-300 py-2">{{ $transaction->relasiUnit->unit->nama_alat }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border-b border-slate-300 py-2">Keperluan</td>
                            <td class="border-b border-slate-300 py-2">{{ $transaction->keperluan }} </td>
                        </tr>
                        <tr>
                            <td class="border-b border-slate-300 py-2">Tanggal Pinjam</td>
                            <td class="border-b border-slate-300 py-2">{{ $transaction->tanggal_pinjam }}</td>
                        </tr>
                        <tr>
                            <td class="border-b border-slate-300 py-2">Tanggal Kembali</td>
                            <td class="border-b border-slate-300 py-2">{{ $transaction->tanggal_kembali }}</td>
                        </tr>
                        <tr>
                            <td class="border-b border-slate-300 py-2">Waktu Kaluwarsa</td>
                            <td class="border-b border-slate-300 py-2">
                                <span id="countdown">{{ $transaction->waktu_mundur }}</span>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </section>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Mendapatkan waktu kedaluwarsa dari elemen (misal data dari blade)
                const waktuKedaluwarsa = @json($transaction->waktu_kedaluwarsa);
                const noTransaksi = @json($transaction->no_transaksi);
                const statusTransaksi = @json($transaction->status);


                function updateCountdown() {

                    if (statusTransaksi === 'dipinjam') {
                        clearInterval(countdownInterval);
                        document.getElementById('countdown').innerText = '00:00:00';
                        return;
                    }

                    if (statusTransaksi === 'terlambat_dikembalikan') {
                        clearInterval(countdownInterval);
                        document.getElementById('countdown').innerText = '00:00:00';
                        return;
                    }

                    if (statusTransaksi === 'dikembalikan') {
                        clearInterval(countdownInterval);
                        document.getElementById('countdown').innerText = '00:00:00';
                        return;
                    }

                    if (statusTransaksi === 'dibatalkan') {
                        clearInterval(countdownInterval);
                        document.getElementById('countdown').innerText = '00:00:00';
                        return;
                    }

                    const currentTime = new Date().getTime();
                    const endTime = new Date(waktuKedaluwarsa).getTime();
                    const timeLeft = endTime - currentTime;

                    if (timeLeft <= 0) {
                        document.getElementById('countdown').innerText = '00:00:00';
                        clearInterval(countdownInterval);
                    } else {
                        const hours = Math.floor(timeLeft / (1000 * 60 * 60));
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                        document.getElementById('countdown').innerText = `${hours}:${minutes}:${seconds}`;
                    }
                }

                // Update setiap detik
                const countdownInterval = setInterval(updateCountdown, 1000);
            });
        </script>
</x-layout>
