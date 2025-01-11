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
        <section class="flex justify-between gap-2 rounded-xl bg-white p-4 shadow-md">
            <div class="flex gap-2">
                <x-navigasi-peminjaman-alat></x-navigasi-peminjaman-alat>

            </div>
            <div class="flex items-center gap-2">
                <div class="flex w-[400px] items-center gap-2 rounded-lg border-[2px] p-[0.7px] px-2">
                    <label for="search" class="text-gray-400"><x-heroicon-m-magnifying-glass class="w-4" /></label>
                    <input type="search" id="search" x-model="search" placeholder="Cari Alat"
                        class="auto w-full border-none bg-transparent p-1 focus:ring-0">
                </div>
            </div>
        </section>

        <section class="grid grid-cols-3 gap-3 overflow-y-scroll">
            @foreach ($getUnit as $unit)
                <div class="relative flex min-w-fit flex-col rounded-lg border border-slate-200 bg-white shadow-sm">
                    <div class="flex h-full flex-col justify-between gap-4 p-4">
                        <div class="flex flex-col gap-4">
                            <h5 class="text-lg font-medium">
                                {{ $unit->nama_alat }}
                            </h5>
                            <p class="flex-wrap text-sm font-light leading-normal text-slate-600">
                                <span class="rounded-md bg-yellow-200 px-2">Fungsi :</span>
                                {{ $unit->fungsi }}
                            </p>
                        </div>
                        <div class="flex w-full flex-col gap-2">
                            <div class="flex flex-col gap-2 border-b border-gray-700 py-1 lg:flex lg:flex-row">
                                <div class="flex gap-2 rounded bg-neutral-200 px-2 py-1">
                                    <p class="text-xs font-semibold text-gray-500">Jumlah Unit</p>
                                    <p class="text-xs text-gray-500">{{ $unit->alat_count }}</p>
                                </div>
                                <div class="flex gap-2 rounded bg-neutral-200 px-2 py-1">
                                    <p class="text-xs font-semibold text-gray-500">Lokasi</p>
                                    <p class="text-xs text-gray-500">{{ $unit->lokasi }}</p>
                                </div>
                            </div>
                            <div class="flex justify-start">
                                <a href="{{ route('detail.alat', $unit->slug) }}"
                                    class="rounded-md bg-[#2D3648] px-3 py-2 text-sm text-white">Detail
                                    Alat</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </section>

    </main>
</x-layout>
