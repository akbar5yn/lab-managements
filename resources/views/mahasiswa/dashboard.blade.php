<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:role>{{ $role }}</x-slot:role>
    <x-slot:name>{{ $name }}</x-slot:name>
    <div class="flex h-full flex-col gap-4">
        <!-- SECTION Ketersediaan Alat-->
        <section class="flex h-[25%] max-w-full flex-col gap-4 rounded-xl bg-[#FFFFFF] p-4 shadow-md">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-medium">Overview</h2>
            </div>
            <div class="ml-4 flex h-full justify-between gap-5 pb-2">
                <div
                    class="border-1 flex w-full snap-start items-center gap-5 rounded-xl border border-[#559f86] bg-[#d0f1e673] px-5 py-2 backdrop-brightness-200">
                    <div class="min-h-fit rounded-md border border-[#559f86] bg-[#d0f1e6] p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
                            <path
                                d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                            <path
                                d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                            <path
                                d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                        </svg>

                    </div>
                    <div>
                        <p class="font-semi-bold text-xl font-semibold">{{ Str::title($prodi) }}</p>
                        <p class="text-sm text-gray-600">Program Studi</p>
                    </div>
                </div>
                <div
                    class="border-1 flex w-full snap-start items-center gap-5 rounded-xl border border-[#559f86] bg-[#d0f1e673] px-5 py-2 backdrop-brightness-200">
                    <div class="min-h-fit rounded-md border border-[#559f86] bg-[#d0f1e6] p-3">
                        <x-heroicon-s-inbox-arrow-down class="size-8" />
                    </div>
                    <div>
                        <p class="font-semi-bold text-xl font-semibold">10</p>
                        <p class="text-sm text-gray-600">Total barang yand dipinjam</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION Ketersediaan Alat-->
        <section class="flex h-[75%] w-full gap-4">
            <section class="flex h-full w-[50%] max-w-full flex-col rounded-xl bg-[#FFFFFF] p-4 shadow-md">
                <div class="flex items-center justify-between py-[2px]">
                    <h2 class="text-lg font-medium">Jumlah Alat & Barang</h2>
                </div>
                <div
                    class="sticky top-0 z-10 mt-4 grid grid-cols-[40.3%_35.3%_auto] items-center gap-2 rounded-md bg-[#2D3648] text-white shadow">
                    <p class="h-full border-gray-400 px-2 py-2 text-center font-medium">
                        Nama Alat</p>

                    <p class="h-full border-x border-gray-400 px-2 py-2 text-center font-medium">
                        Lokasi</p>

                    <p class="h-full border-gray-400 px-2 py-2 text-center font-medium">
                        Jumlah</p>
                </div>
                <div class="mt-3 flex flex-col gap-2 overflow-y-scroll">
                    @foreach ($getUnit as $alat)
                        <div class="grid grid-cols-[40.3%_35.3%_auto] gap-2 rounded-md border border-gray-400 shadow">
                            <p class="px-2 py-2">{{ $alat->nama_alat }}</p>
                            <p class="border-x border-gray-400 px-2 py-2">{{ $alat->lokasi }}</p>
                            <p class="px-2 py-2 text-center">{{ $alat->alat_count }} Unit</p>
                        </div>
                    @endforeach

                </div>

            </section>
            <section class="flex h-full w-[50%] max-w-full flex-col rounded-xl bg-[#FFFFFF] p-4 shadow-md">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium">Ketersediaan Alat & Barang</h2>
                    <form id="cekForm" action="" method="GET" class="m-0 self-center">
                        <section class="flex items-center gap-4">
                            <input name="cek_tanggal" type="date" id="cek_tanggal_input"
                                value="{{ request()->input('cek_tanggal', now()->toDateString()) }}"
                                class="flex items-center rounded-lg border border-gray-400 py-1 text-sm hover:bg-gray-50">
                        </section>
                    </form>
                </div>
                <div
                    class="sticky top-0 z-10 mt-4 grid grid-cols-[40%_35.3%_auto] items-center gap-2 rounded-md border-b border-gray-400 bg-[#2D3648] text-center text-white shadow">
                    <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                        Nama Alat</p>

                    <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                        Lokasi</p>

                    <p class="h-full border-gray-400 px-2 py-2 font-medium">
                        Ketersediaan</p>
                </div>
                <div class="mt-3 flex flex-col gap-2 overflow-y-scroll">
                    @foreach ($unitTersedia as $unit)
                        <div>
                            <div class="grid grid-cols-[40%_35.3%_auto] gap-2 rounded-md border border-gray-400">
                                <p class="px-2 py-2">{{ $unit->nama_alat }}</p>
                                <p class="px-2 py-2">{{ $unit->lokasi }}</p>
                                <p class="px-2 py-2">{{ $unit->alat_count }}</p>
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
