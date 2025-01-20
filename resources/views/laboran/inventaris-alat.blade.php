<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>


    <main class="inventaris flex h-full flex-col gap-4">
        <!-- SECTION Filtering, Searching, And Adding Tools-->
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
        <section class="head-of-inventaris flex max-w-full justify-between gap-4 rounded-xl bg-white p-4 shadow-md">
            <div class="flex items-center gap-3">
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
                            <form action="" method="GET">
                                <button class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-200"
                                    role="menuitem" tabindex="-1" name="lokasi" id="menu-item-0">
                                    Tampilkan Semua
                                </button>
                                @foreach ($getLokasi as $getLocation)
                                    <button
                                        class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-200"
                                        role="menuitem" tabindex="-1" name="lokasi" value="{{ $getLocation->lokasi }}"
                                        id="menu-item-0">{{ $getLocation->lokasi }}
                                    </button>
                                @endforeach
                            </form>
                        </div>
                    </div>

                </div>
                <form action="" method="GET" class="flex items-center">
                    <div class="flex w-[400px] items-center gap-2 rounded-lg border-[2px] p-[0.7px] px-2">

                        <input type="search" id="search" name="search" value="{{ request('search') }}"
                            class="auto w-full border-none bg-transparent p-1 focus:ring-0">
                        <button for="search" class="text-gray-400"><x-heroicon-m-magnifying-glass
                                class="w-4" /></button>
                    </div>
                </form>
            </div>
            <div>
                {{-- //TODO - Modal Add Category --}}
                <x-modal attributeTitle="Tambah Alat & Barang" attributeButton="Tambah Alat">
                    <form action="{{ route('post.alat') }}" method="POST">
                        @csrf
                        <div class="flex flex-col gap-6 rounded-lg border p-4">

                            <div
                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                <label class="font-semibold" for="nama_alat">Nama Alat</label>
                                <input type="text" name="nama_alat" id="nama_alat" required
                                    class="border-none p-0 capitalize focus:outline-none focus:ring-0">
                            </div>
                            <div
                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                <label class="font-semibold" for="lokasi">Lokasi</label>
                                <input type="text" name="lokasi" id="lokasi" required
                                    class="border-none p-0 capitalize focus:outline-none focus:ring-0">
                            </div>
                            <div
                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                <label class="font-semibold" for="tahun_pengadaan">Tahun Pengadaan</label>
                                <input type="number" min="0" name="tahun_pengadaan" id="tahun_pengadaan"
                                    required class="border-none p-0 focus:outline-none focus:ring-0">
                            </div>
                            <div
                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                <label class="font-semibold" for="fungsi">Fungsi Alat</label>
                                <input type="text" name="fungsi" id="fungsi" required
                                    class="border-none p-0 focus:outline-none focus:ring-0"
                                    oninput="capitalizeFirstLetter(this)">
                            </div>
                            <div
                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                <label class="font-semibold" for="jumlah">Jumlah Unit</label>
                                <input type="number" min="0" name="jumlah" id="jumlah" required
                                    class="appearance-none border-none p-0 focus:outline-none focus:ring-0">
                            </div>
                        </div>
                        <button type="submit"
                            class="mt-2 w-full rounded bg-[#84AFA2] px-4 py-2 text-white">Simpan</button>
                    </form>
                </x-modal>
            </div>
        </section>

        <!-- SECTION Table of Content-->
        <section class="content-of-inventaris h-full overflow-y-scroll rounded-xl bg-white shadow-md">
            <div class="p-4">
                <div
                    class="sticky top-0 z-10 grid grid-cols-[4%_20%_17%_10%_25%_auto] items-center border-b border-gray-400 bg-[#e4e4e4] shadow">
                    <p
                        class="flex h-full items-center justify-center self-center border-r border-gray-400 px-2 py-2 text-center">
                        No</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Nama Alat</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Lokasi</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Tahun Pengadaan</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Fungsi Alat</p>
                    <p class="flex h-full items-center justify-center px-2 py-2 text-center">Aksi</p>
                </div>

                @if ($getSortedTools->isEmpty())
                    <div class="flex h-[50%] flex-col items-center justify-center">
                        <h1 class="text-xl font-medium text-gray-400">Alat dan barang tidak tersedia di Database
                        </h1>
                        <h1 class="text-xl font-medium text-gray-400">Tambahkan alat dan barang</h1>
                    </div>
                @elseif ($lokasi)
                    @foreach ($getSortedTools as $tool)
                        <div class="grid grid-cols-[4%_20%_17%_10%_25%_auto] border-b border-gray-400">
                            <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $loop->iteration }}</p>
                            <p class="border-r border-gray-400 px-2 py-2">{{ $tool->nama_alat }}</p>
                            <p class="border-r border-gray-400 px-2 py-2">{{ $tool->lokasi }}</p>
                            <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $tool->tahun_pengadaan }}
                            </p>
                            <p class="border-r border-gray-400 px-2 py-2">{{ $tool->fungsi }}</p>
                            <div class="flex items-center justify-center gap-5">
                                <a href="{{ route('alat.unit', ['slug' => $tool->slug]) }}"
                                    class="rounded bg-blue-400 px-2 text-white">Detail</a>
                                <form action="{{ route('delete.alat', $tool->id) }}" method="POST"
                                    class="delete-form m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded bg-red-400 px-2 text-white">Hapus</button>
                                </form>

                                {{-- //TODO  Modal to update category --}}
                                <x-modal attributeTitle="Edit Alat & Barang" attributeButton="Edit">
                                    <form action="{{ route('edit.alat', $tool->id) }}" method="POST"
                                        class="update-form">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex flex-col gap-6 rounded-lg border p-4">
                                            <div
                                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                                <label class="font-semibold" for="nama_alat">Nama Alat</label>
                                                <input type="text" name="nama_alat" id="nama_alat" required
                                                    class="border-none p-0 capitalize focus:outline-none focus:ring-0"
                                                    x-bind:value="'{{ $tool['nama_alat'] }}'">
                                            </div>
                                            <div
                                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                                <label class="font-semibold" for="lokasi">Lokasi</label>
                                                <input type="text" name="lokasi" id="lokasi" required
                                                    class="border-none p-0 capitalize focus:outline-none focus:ring-0"
                                                    x-bind:value="'{{ $tool['lokasi'] }}'">
                                            </div>
                                            <div
                                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                                <label class="font-semibold" for="tahun_pengadaan">Tahun
                                                    Pengadaan</label>
                                                <input type="number" min="0" name="tahun_pengadaan"
                                                    id="tahun_pengadaan" required
                                                    class="border-none p-0 focus:outline-none focus:ring-0"
                                                    x-bind:value="'{{ $tool['tahun_pengadaan'] }}'">
                                            </div>
                                            <div
                                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                                <label class="font-semibold" for="fungsi">Fungsi Alat</label>
                                                <input type="text" name="fungsi" id="fungsi" required
                                                    class="border-none p-0 focus:outline-none focus:ring-0"
                                                    x-bind:value="'{{ $tool['fungsi'] }}'"
                                                    oninput="capitalizeFirstLetter(this)">
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="mt-2 w-full rounded bg-[#84AFA2] px-4 py-2 text-white">Simpan</button>
                                    </form>
                                </x-modal>

                            </div>
                        </div>
                    @endforeach
                @else
                    @foreach ($getSortedTools as $tool)
                        <div class="grid grid-cols-[4%_20%_17%_10%_25%_auto] border-b border-gray-400">
                            <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $loop->iteration }}</p>
                            <p class="border-r border-gray-400 px-2 py-2">{{ $tool->nama_alat }}</p>
                            <p class="border-r border-gray-400 px-2 py-2">{{ $tool->lokasi }}</p>
                            <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $tool->tahun_pengadaan }}
                            </p>
                            <p class="border-r border-gray-400 px-2 py-2">{{ $tool->fungsi }}</p>
                            <div class="flex items-center justify-center gap-5">
                                <a href="{{ route('alat.unit', ['slug' => $tool->slug]) }}"
                                    class="rounded bg-blue-400 px-2 text-white">Detail</a>
                                <form action="{{ route('delete.alat', $tool->id) }}" method="POST"
                                    class="delete-form m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded bg-red-400 px-2 text-white">Hapus</button>
                                </form>

                                {{-- //TODO  Modal to update category --}}
                                <x-modal attributeTitle="Edit Alat & Barang" attributeButton="Edit">
                                    <form action="{{ route('edit.alat', $tool->id) }}" method="POST"
                                        class="update-form">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex flex-col gap-6 rounded-lg border p-4">
                                            <div
                                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                                <label class="font-semibold" for="nama_alat">Nama Alat</label>
                                                <input type="text" name="nama_alat" id="nama_alat" required
                                                    class="border-none p-0 capitalize focus:outline-none focus:ring-0"
                                                    x-bind:value="'{{ $tool['nama_alat'] }}'">
                                            </div>
                                            <div
                                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                                <label class="font-semibold" for="lokasi">Lokasi</label>
                                                <input type="text" name="lokasi" id="lokasi" required
                                                    class="border-none p-0 capitalize focus:outline-none focus:ring-0"
                                                    x-bind:value="'{{ $tool['lokasi'] }}'">
                                            </div>
                                            <div
                                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                                <label class="font-semibold" for="tahun_pengadaan">Tahun
                                                    Pengadaan</label>
                                                <input type="number" min="0" name="tahun_pengadaan"
                                                    id="tahun_pengadaan" required
                                                    class="border-none p-0 focus:outline-none focus:ring-0"
                                                    x-bind:value="'{{ $tool['tahun_pengadaan'] }}'">
                                            </div>
                                            <div
                                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                                <label class="font-semibold" for="fungsi">Fungsi Alat</label>
                                                <input type="text" name="fungsi" id="fungsi" required
                                                    class="border-none p-0 focus:outline-none focus:ring-0"
                                                    x-bind:value="'{{ $tool['fungsi'] }}'"
                                                    oninput="capitalizeFirstLetter(this)">
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="mt-2 w-full rounded bg-[#84AFA2] px-4 py-2 text-white">Simpan</button>
                                    </form>
                                </x-modal>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>
    </main>
</x-layout>
