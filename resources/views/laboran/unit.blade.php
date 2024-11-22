<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:subtitle>{{ $subtitle }}</x-slot:subtitle>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>
    <main class="flex h-full w-full gap-4">
        @if (Session::has('success'))
            <script>
                window.onload = function() {
                    showAlert("Berhasil", "{{ Session::get('success') }}", "success");
                };
            </script>
        @endif

        @if (Session::has('error'))
            <script>
                window.onload = function() {
                    showAlert("Error", "{{ Session::get('error') }}", "error");
                };
            </script>
        @endif
        <section class="content-of-inventaris h-full w-[75%] overflow-y-scroll rounded-xl bg-white shadow-md">
            <div class="p-4">
                <div
                    class="sticky top-0 z-50 grid grid-cols-[4%_25%_20%_20%_auto] border-b border-gray-400 bg-[#e4e4e4] shadow">
                    <p class="flex items-center justify-center border-r border-gray-400 px-2 py-2 text-center">No</p>
                    <p class="flex items-center justify-center border-r border-gray-400 px-2 py-2 text-center">Nomor
                        Unit</p>
                    <p class="flex items-center justify-center border-r border-gray-400 px-2 py-2 text-center">Status
                        Alat</p>
                    <p class="flex items-center justify-center border-r border-gray-400 px-2 py-2 text-center">Kondisi
                    </p>
                    <p class="flex items-center justify-center px-2 py-2 text-center">Aksi</p>

                </div>

                @foreach ($allUnits as $unit)
                    <div class="grid grid-cols-[4%_25%_20%_20%_auto] border-b border-gray-400">
                        <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $loop->iteration }}</p>
                        <p class="border-r border-gray-400 px-2 py-2">{{ $unit['no_unit'] }}</p>
                        <p class="border-r border-gray-400 px-2 py-2 text-center">
                            {{-- <span
                                class="{{ $unit->kondisi == 'Rusak'
                                    ? 'bg-red-100 text-red-600'
                                    : ($unit->detailPeminjaman->isNotEmpty()
                                        ? 'bg-yellow-100 text-yellow-600'
                                        : 'bg-green-100 text-green-600') }} flex items-center justify-center rounded px-2 py-1">
                                @if ($unit->kondisi == 'Rusak')
                                    Rusak
                                @elseif ($unit->detailPeminjaman->isNotEmpty())
                                    @foreach ($unit->detailPeminjaman as $peminjaman)
                                        {{ $peminjaman->status == 'pending' ? 'Pending' : 'Dipinjam' }}
                                    @endforeach
                                @else
                                    Tersedia
                                @endif
                            </span> --}}

                            @if ($unit->kondisi == 'Rusak')
                                <span
                                    class="flex items-center justify-center rounded bg-red-100 px-2 py-1 text-red-600">Rusak
                                </span>
                            @elseif ($unit->detailPeminjaman->isNotEmpty())
                                @foreach ($unit->detailPeminjaman as $peminjaman)
                                    @if ($peminjaman->status == 'dipinjam')
                                        <span
                                            class="flex items-center justify-center rounded bg-yellow-100 px-2 py-1 text-yellow-600">Dipinjam
                                        </span>
                                    @elseif ($peminjaman->status == 'terlambat_dikembalikan')
                                        <span
                                            class="flex items-center justify-center rounded bg-yellow-100 px-2 py-1 text-yellow-600">Dipinjam
                                        </span>
                                    @else
                                        <span
                                            class="flex items-center justify-center rounded bg-green-100 px-2 py-1 text-green-600">
                                            Tersedia
                                        </span>
                                    @endif
                                @endforeach
                            @else
                                <span
                                    class="flex items-center justify-center rounded bg-green-100 px-2 py-1 text-green-600">
                                    Tersedia
                                </span>
                            @endif
                        </p>
                        <p class="border-r border-gray-400 px-2 py-2">
                            <span
                                class="{{ $unit['kondisi'] == 'Normal' ? 'bg-blue-100 text-blue-600' : 'bg-red-100 text-red-600' }} flex items-center justify-center rounded px-2 py-1">
                                {{ $unit['kondisi'] }}
                            </span>
                        </p>

                        <div class="flex w-full items-center justify-center gap-5">
                            <div x-data="{ isOpen: false }" class="relative inline-block text-left">
                                <div>
                                    <button type="button" @click="isOpen = !isOpen"
                                        class="inline-flex w-full justify-center gap-x-1.5 rounded border bg-blue-400 px-2 text-white"
                                        id="menu-button" aria-expanded="true" aria-haspopup="true">
                                        Kondisi
                                    </button>
                                </div>


                                <div x-show="isOpen" @click.outside="isOpen = false"
                                    x-transition:enter="transition ease-out duration-100 transform"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75 transform"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute left-0 z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="menu-button"
                                    tabindex="-1" x-ref="dropdown">
                                    <div class="py-1" role="none">
                                        <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                        <form action="{{ route('edit.unit', [$alat->slug, $unit->id]) }}"
                                            class="m-0" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="kondisi" value="Normal">
                                            <button type="submit"
                                                class="block px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-100"
                                                role="menuitem" tabindex="-1">Normal</button>

                                        </form>
                                        <form action="{{ route('edit.unit', [$alat->slug, $unit->id]) }}"
                                            class="m-0" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="kondisi" value="Rusak">
                                            <button type="submit"
                                                class="{{ $unit->status === 'Dipinjam' ? 'bg-gray-300 cursor-not-allowed' : '' }} block w-full px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-100"
                                                role="menuitem" tabindex="-1"
                                                @if ($unit->status == 'Dipinjam') disabled
                                                data-ripple-light="true"
                                                data-tooltip-target="tooltip-right" @endif>
                                                Rusak
                                            </button>
                                            @if ($unit->status === 'Dipinjam')
                                                <div data-tooltip="tooltip-right" data-tooltip-placement="right"
                                                    class="absolute z-50 w-40 whitespace-normal break-words rounded-lg bg-black px-3 py-1.5 font-sans text-sm font-normal text-white focus:outline-none">
                                                    Unit sedang dipinjam, tidak dapat diubah
                                                </div>
                                            @endif

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('delete.unit', [$alat->slug, $unit->id]) }}" method="POST"
                                class="delete-unit m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded bg-red-400 px-2 text-white">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>


        </section>
        <section
            class="content-of-inventaris relative flex h-full w-[25%] flex-col gap-3 rounded-xl bg-white p-4 shadow-md">
            <h1 class="text-lg font-medium">Informasi Alat dan Barang</h1>
            <div class="grid grid-cols-2 p-2">
                <p class="rounded-t-md border border-gray-300 bg-green-100 p-2 text-green-600">Tersedia</p>
                <p class="rounded-t-md border border-gray-300 bg-green-100 p-2 text-center text-green-600">
                    {{ $unitTersedia }}</p>
                <p class="border border-gray-300 bg-yellow-100 p-2 text-yellow-600">Dipinjam</p>
                <p class="border border-gray-300 bg-yellow-100 p-2 text-center text-yellow-600">
                    {{ $totalUnitsDipinjam }}
                </p>

                <p class="border border-gray-300 bg-blue-100 p-2 text-blue-600">Normal</p>
                <p class="border border-gray-300 bg-blue-100 p-2 text-center text-blue-600">{{ $countNormal }}</p>

                <p class="border border-gray-300 bg-red-100 p-2 text-red-600">Rusak</p>
                <p class="border border-gray-300 bg-red-100 p-2 text-center text-red-600">{{ $countRusak }}</p>

                <p class="rounded-b-md border border-gray-300 p-2">Total Alat</p>
                <p class="rounded-b-md border border-gray-300 p-2 text-center">{{ $countTotal }}</p>
            </div>
            {{-- <button
                class="absolute bottom-10 left-1/2 -translate-x-1/2 transform rounded-lg border-[#559f86] bg-[#d0f1e6] px-5 py-2 text-base">Tambah
                Unit</button> --}}
            <x-modal attributeTitle="Tambah Unit" attributeButton="Tambah Unit">
                <form action="{{ route('tambah.unit', [$alat->slug]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="flex flex-col gap-6 rounded-lg border p-4">

                        <input type="hidden" min="0" name="nama_alat" id="nama_alat" required
                            x-bind:value="'{{ $alat['nama_alat'] }}'">
                        <input type="hidden" min="0" name="id_alat" id="id_alat" required
                            x-bind:value="'{{ $alat['id'] }}'">
                        <div
                            class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <label class="font-semibold" for="jumlah">Jumlah Alat</label>
                            <input type="text" name="jumlah" id="jumlah" required
                                class="border-none p-0 focus:outline-none focus:ring-0"
                                oninput="capitalizeFirstLetter(this)">
                        </div>
                    </div>
                    <button type="submit"
                        class="mt-2 w-full rounded bg-[#84AFA2] px-4 py-2 text-white">Simpan</button>
                </form>
            </x-modal>
        </section>
    </main>

</x-layout>
