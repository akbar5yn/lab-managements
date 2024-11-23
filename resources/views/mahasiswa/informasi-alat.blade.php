<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>
    <main class="h-full flex-col gap-4 overflow-y-scroll">
        <!-- SECTION Show Alat-->
        <section>
            <!-- ANCHOR Button Navigation-->
            <div class="flex gap-2">
                <a href="{{ route('informasi.alat') }}"
                    class="{{ request()->is('mahasiswa/peminjaman-alat/informasi') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} w-fit rounded-lg px-2 py-1 text-lg font-medium shadow-sm">
                    Informasi Alat
                </a>
                <a href="{{ route('aktivitas.peminjaman') }}"
                    class="{{ request()->is('mahasiswa/peminjaman-alat/aktifitas') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} w-fit rounded-lg border px-2 py-1 text-lg font-medium shadow-sm">
                    Aktivitas Peminjaman
                </a>
            </div>

            <div class="mt-4 grid grid-cols-3 gap-3 pb-2">
                @foreach ($getUnit as $unit)
                    <div class="relative flex min-w-fit flex-col rounded-lg border border-slate-200 bg-white shadow-sm">
                        <div class="flex flex-col gap-4 p-4">
                            <h5 class="text-lg font-medium">
                                {{ $unit->nama_alat }}
                            </h5>
                            <p class="flex-wrap text-sm font-light leading-normal text-slate-600">
                                <span class="rounded-md bg-yellow-200 px-2">Fungsi :</span>
                                {{ $unit->fungsi }}
                            </p>
                            <div class="flex flex-col gap-2 border-b border-gray-700 py-1 lg:flex lg:flex-row">
                                <div class="flex gap-2 rounded bg-neutral-200 px-2 py-1">
                                    <p class="text-xs font-semibold text-gray-500">Tersedia</p>
                                    <p class="text-xs text-gray-500">{{ $unit->alat_count }}</p>
                                </div>
                                <div class="flex gap-2 rounded bg-neutral-200 px-2 py-1">
                                    <p class="text-xs font-semibold text-gray-500">Lokasi</p>
                                    <p class="text-xs text-gray-500">{{ $unit->lokasi }}</p>
                                </div>

                            </div>
                            <div class="mt-2 flex items-center justify-between">
                                <button class="rounded-md bg-[#08835a] px-3 py-1 text-sm text-white">Pinjam
                                    Alat</button>
                            </div>
                        </div>
                    </div>
                @endforeach



            </div>
        </section>
    </main>
</x-layout>
