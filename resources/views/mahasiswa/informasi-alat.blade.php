<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:subtitle>{{ $subtitle }}</x-slot:subtitle>
    <x-slot:role>{{ $role }}</x-slot:role>
    <main class="flex h-full flex-col gap-4">
        @if (Session::has('success'))
            <script>
                window.onload = function() {
                    showAlert("Berhasil", "{{ Session::get('success') }}", "success");
                    const swalBody = document.querySelector('body.swal2-height-auto');
                    if (swalBody) {
                        swalBody.style.minHeight = '100vh';
                        swalBody.style.maxHeight = '100vh';
                        swalBody.style.overflowY = 'auto';
                    }
                };
            </script>
        @endif

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
        <section class="flex justify-between gap-2">
            <div class="flex gap-2">
                <a href="{{ route('informasi.alat') }}"
                    class="{{ request()->is('mahasiswa/informasi-alat') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} w-fit rounded-lg px-2 py-1 text-lg font-medium shadow-sm">
                    Informasi Alat
                </a>
                <a href="{{ route('aktivitas.peminjaman') }}"
                    class="{{ request()->is('mahasiswa/peminjaman-alat/aktifitas') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} w-fit rounded-lg border px-2 py-1 text-lg font-medium shadow-sm">
                    Aktivitas Peminjaman
                </a>
            </div>
            <div class="flex items-center gap-2">
                <div id="kategori" x-data="{ isOpen: false }" class="relative inline-block text-left">
                    <div>
                        <button type="button" @click="isOpen = !isOpen"
                            class="inline-flex w-full justify-center gap-x-1.5 rounded-lg border bg-white px-3 py-2 text-sm font-semibold ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            id="menu-button" aria-expanded="true" aria-haspopup="true">
                            Kategori Ruangan
                            <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>


                    <div x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75 transform"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute left-0 z-50 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="menu-item-0">Lab A</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="menu-item-1">Lab B</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="menu-item-2">Lab C</a>
                        </div>
                    </div>
                </div>
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
                                    class="rounded-md bg-[#08835a] px-3 py-2 text-sm text-white">Pinjam
                                    Alat</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </section>

    </main>
</x-layout>
