<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:subtitle>{{ $subtitle }}</x-slot:subtitle>
    <x-slot:role>{{ $role }}</x-slot:role>
    <main class="flex h-full flex-col gap-4">
        @if (Session::has('error'))
            <script>
                window.onload = function() {
                    showAlert("Error", "{{ Session::get('error') }}", "error");
                    const swalBody = document.querySelector('body.swal2-height-auto');
                    if (swalBody) {
                        swalBody.style.minHeight = '100vh';
                        swalBody.style.maxHeight = '100vh';
                        swalBody.style.overflowY = 'auto';
                    }
                };
            </script>
        @endif

        @if (Session::has('warning'))
            <script>
                window.onload = function() {
                    showAlert("Ups Maaf", "{{ Session::get('warning') }}", "warning");
                    const swalBody = document.querySelector('body.swal2-height-auto');
                    if (swalBody) {
                        swalBody.style.minHeight = '100vh';
                        swalBody.style.maxHeight = '100vh';
                        swalBody.style.overflowY = 'auto';
                    }
                };
            </script>
        @endif

        <!-- SECTION Show Alat-->
        <!-- ANCHOR Button Navigation and filtering-->
        <section class="flex flex-col justify-between gap-2 xl:flex-row xl:rounded-xl xl:bg-white xl:p-4 xl:shadow-md">
            <div class="flex justify-center gap-2">
                <x-navigasi-peminjaman-alat></x-navigasi-peminjaman-alat>

            </div>
            <div class="flex w-full gap-2 xl:w-auto xl:items-center">
                <div class="flex w-full items-center gap-2 rounded-lg border-[2px] p-[0.7px] px-2 xl:w-[400px]">
                    <label for="search" class="text-gray-400"><x-heroicon-m-magnifying-glass class="w-4" /></label>
                    <input type="search" id="search-alat" name="search-alat" placeholder="Cari Alat"
                        class="auto w-full border-none bg-transparent p-1 text-sm focus:ring-0 xl:text-base">
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-3 overflow-y-scroll pb-4 xl:grid-cols-3 xl:pb-0">
            @foreach ($getUnit as $unit)
                <div class="relative flex min-w-fit flex-col rounded-lg border border-slate-200 bg-white shadow-sm">
                    <div class="flex h-full flex-col justify-between gap-4 p-4">
                        <div class="flex flex-col gap-4">
                            <h5 class="text-sm font-medium xl:text-lg">
                                {{ $unit->nama_alat }}
                            </h5>
                            <p class="flex-wrap text-[11px] font-light leading-normal text-slate-600 xl:text-sm">
                                <span class="rounded-md bg-yellow-200 px-2">Fungsi :</span>
                                {{ $unit->fungsi }}
                            </p>
                        </div>
                        <div class="flex w-full flex-col gap-2">
                            <div class="flex flex-col gap-2 border-b border-gray-700 py-1 lg:flex lg:flex-row">
                                <div class="flex gap-2 rounded bg-neutral-200 px-2 py-1">
                                    <p class="text-[10px] font-semibold text-gray-500 xl:text-xs">Jumlah Unit</p>
                                    <p class="text-[10px] text-gray-500 xl:text-xs">{{ $unit->alat_count }}</p>
                                </div>
                                <div class="flex flex-col gap-x-2 rounded bg-neutral-200 px-2 py-1 xl:flex-row">
                                    <p class="text-[10px] font-semibold text-gray-500 xl:text-xs">Lokasi</p>
                                    <p class="text-[10px] text-gray-500 xl:text-xs">{{ $unit->lokasi }}</p>
                                </div>
                            </div>
                            <div class="flex justify-start">
                                <a href="{{ route('detail.alat', $unit->slug) }}"
                                    class="rounded-md bg-[#2D3648] px-2 py-1 text-xs text-white xl:px-3 xl:py-2 xl:text-sm">Detail
                                    Alat</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </section>

    </main>
</x-layout>
