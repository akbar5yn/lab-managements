<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:role>{{ $role }}</x-slot:role>
    <x-slot:name>{{ $name }}</x-slot:name>
    <div class="flex h-full flex-col gap-4">
        <!-- SECTION Overview-->
        <section class="flex h-[25%] max-w-full flex-col gap-4 rounded-xl bg-[#FFFFFF] p-4 shadow-md">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-medium xl:text-lg">Overview</h2>
            </div>
            <div class="flex h-full snap-x snap-start scroll-pl-2 justify-between gap-5 overflow-x-scroll pb-2 md:ml-4">
                <div
                    class="border-1 flex h-fit snap-start items-center gap-5 rounded-xl border border-[#559f86] bg-[#d0f1e673] px-2 py-2 backdrop-brightness-200 md:h-auto md:w-full md:px-5 md:py-2">
                    <div class="min-h-fit rounded-md border border-[#559f86] bg-[#d0f1e6] p-3">
                        <x-heroicon-s-academic-cap class="size-5 xl:size-8" />

                    </div>
                    <div class="w-[100px] md:w-full">
                        <p class="font-semi-bold text-[14px] text-xs font-semibold xl:text-xl">{{ Str::title($prodi) }}
                        </p>
                        <p class="w-full text-[11px] text-gray-600 xl:text-sm">Program Studi</p>
                    </div>
                </div>
                <div
                    class="border-1 flex h-fit snap-start items-center gap-5 rounded-xl border border-[#559f86] bg-[#d0f1e673] px-2 py-2 backdrop-brightness-200 md:h-auto md:w-full md:px-5 md:py-2">
                    <div class="min-h-fit rounded-md border border-[#559f86] bg-[#d0f1e6] p-3">
                        <x-heroicon-s-archive-box-arrow-down class="size-5 xl:size-8" />
                    </div>
                    <div class="w-[100px] md:w-full">
                        <p class="font-semi-bold text-xs font-semibold xl:text-xl">{{ $totalBarangDiajukan }}</p>
                        <p class="w-full text-[11px] text-gray-600 xl:text-sm">Total barang yand diajukan</p>
                    </div>
                </div>
                <div
                    class="border-1 flex h-fit snap-start items-center gap-5 rounded-xl border border-[#559f86] bg-[#d0f1e673] px-2 py-2 backdrop-brightness-200 md:h-auto md:w-full md:px-5 md:py-2">
                    <div class="min-h-fit rounded-md border border-[#559f86] bg-[#d0f1e6] p-3">
                        <x-heroicon-s-inbox-arrow-down class="size-5 xl:size-8" />
                    </div>
                    <div class="w-[100px] md:w-full">
                        <p class="font-semi-bold text-xs font-semibold xl:text-xl">{{ $totalBarangPinjam }}</p>
                        <p class="w-full text-[11px] text-gray-600 xl:text-sm">Total barang yand dipinjam</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION Ketersediaan Alat-->
        <section class="flex h-[75%] w-full flex-col gap-4 xl:flex xl:flex-row">
            <section class="flex h-full max-w-full flex-col rounded-xl bg-[#FFFFFF] p-4 shadow-md xl:w-[50%]">
                <div class="flex items-center justify-between py-[2px]">
                    <h2 class="text-base font-medium xl:text-lg">Jumlah Alat & Barang</h2>
                </div>
                <div
                    class="sticky top-0 z-10 mt-4 grid grid-cols-[40.3%_35.3%_auto] items-center rounded-md bg-[#2D3648] text-white shadow">
                    <p class="h-full border-r border-gray-400 py-2 text-center text-sm font-medium xl:text-base">
                        Nama Alat</p>

                    <p class="h-full border-r border-gray-400 py-2 text-center text-sm font-medium xl:text-base">
                        Lokasi</p>

                    <p class="h-full border-gray-400 py-2 text-center text-sm font-medium xl:text-base">
                        Jumlah</p>
                </div>
                <div class="mt-3 flex flex-col gap-2 overflow-y-scroll">
                    @foreach ($getUnit as $alat)
                        <div class="grid grid-cols-[40.3%_35.3%_auto] rounded-md border border-gray-400 shadow">
                            <p class="border-r border-gray-400 px-2 py-2 text-xs xl:text-base">{{ $alat->nama_alat }}
                            </p>
                            <p class="border-r border-gray-400 px-2 py-2 text-xs xl:text-base">{{ $alat->lokasi }}</p>
                            <p class="px-2 py-2 text-center text-xs xl:text-base">{{ $alat->alat_count }} Unit</p>
                        </div>
                    @endforeach

                </div>

            </section>
            <section class="flex h-full max-w-full flex-col rounded-xl bg-[#FFFFFF] p-4 shadow-md xl:w-[50%]">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-medium xl:text-lg">Ketersediaan Alat & Barang</h2>
                    <form id="cekForm" action="" method="GET" class="m-0 self-center">
                        <section class="flex items-center gap-4">
                            <input name="cek_tanggal" type="date" id="cek_tanggal_input"
                                value="{{ request()->input('cek_tanggal', now()->toDateString()) }}"
                                class="flex items-center rounded-lg border border-gray-400 py-1 text-xs hover:bg-gray-50 xl:text-sm">
                        </section>
                    </form>
                </div>
                <div
                    class="sticky top-0 z-10 mt-4 grid grid-cols-[40%_35.3%_auto] items-center rounded-md border-b border-gray-400 bg-[#2D3648] text-center text-white shadow">
                    <p class="h-full border-r border-gray-400 py-2 text-sm font-medium xl:text-base">
                        Nama Alat</p>

                    <p class="h-full border-r border-gray-400 py-2 text-sm font-medium xl:text-base">
                        Lokasi</p>

                    <p class="h-full w-full break-words border-gray-400 py-2 text-sm font-medium xl:text-base">
                        Tersedia</p>
                </div>
                <div class="mt-3 flex flex-col gap-2 overflow-y-scroll">
                    @foreach ($unitTersedia as $unit)
                        <div>
                            <div class="grid grid-cols-[40%_35.3%_auto] rounded-md border border-gray-400">
                                <p class="border-r border-gray-400 px-2 py-2 text-xs xl:text-base">
                                    {{ $unit->nama_alat }}</p>
                                <p class="border-r border-gray-400 px-2 py-2 text-xs xl:text-base">{{ $unit->lokasi }}
                                </p>
                                <p class="px-2 py-2 text-center text-xs xl:text-base">{{ $unit->alat_count }} Unit</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </section>
        </section>
    </div>

    <script>
        document.getElementById('cek_tanggal_input').addEventListener('change', function() {
            document.getElementById('cekForm').submit(); // Mengirimkan form secara otomatis saat tanggal berubah
        });
    </script>
</x-layout>
