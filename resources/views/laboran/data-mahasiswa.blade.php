<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:role>{{ $role }}</x-slot:role>
    <x-slot:name>{{ $name }}</x-slot:name>
    <main class="inventaris flex h-full flex-col gap-4">
        <section class="head-of-inventaris flex max-w-full justify-between gap-4 rounded-xl bg-white p-4 shadow-md">
            <div class="flex items-center gap-3">
                <div id="kategori" x-data="{ isOpen: false }" class="relative inline-block text-left">
                    <div>
                        <button type="button" @click="isOpen = !isOpen"
                            class="inline-flex w-full justify-center gap-x-1.5 rounded-lg border bg-white px-3 py-2 text-sm font-semibold ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            id="menu-button" aria-expanded="true" aria-haspopup="true">
                            Kategori Prodi
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
                    <input type="search" id="search" x-model="search"
                        class="auto w-full border-none bg-transparent p-1 focus:ring-0">
                </div>
            </div>
            <x-modal attributeTitle="Form Data Mahasiswa" attributeButton="Tambah Mahasiswa">
                <form action="{{ route('create.mahasiswa') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="flex flex-col gap-6 rounded-lg border p-4">

                        <div
                            class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <label class="font-semibold" id="name" for="name">Nama Mahasiswa</label>
                            <input type="text" name="name" id="name" required
                                class="border-none p-0 capitalize focus:outline-none focus:ring-0">
                        </div>
                        <div
                            class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <label class="font-semibold" for="username" id="username">NIM</label>
                            <input type="text" name="username" id="username" required
                                class="border-none p-0 focus:outline-none focus:ring-0">
                        </div>
                        <div
                            class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <label class="font-semibold" for="prodi">Program Studi</label>
                            <input type="text" name="prodi" id="prodi" required
                                class="border-none p-0 focus:outline-none focus:ring-0">
                        </div>
                    </div>
                    <button type="submit" class="mt-2 w-full rounded bg-[#84AFA2] px-4 py-2 text-white">Simpan</button>
                </form>
            </x-modal>


        </section>
        <section class="h-full overflow-y-scroll rounded-xl bg-white shadow-md">
            <div>
                <div
                    class="sticky top-0 z-10 grid grid-cols-[4%_25%_25%_25%_auto] items-center border-b border-gray-400 bg-[#2D3648] text-white shadow">
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        No</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Nama</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Program Studi</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        NIM</p>

                    <p class="flex h-full items-center justify-center px-2 py-2 text-center">
                        Aksi</p>
                </div>
            </div>
            <!-- SECTION Form update-->

            @foreach ($dataMhs as $mahasiswa)
                <form action="{{ route('update.mahasiswa', $mahasiswa['id']) }}"
                    id="update-mahasiswa-{{ $mahasiswa['id'] }}" method="POST">
                    @method('PUT')
                    @csrf
                </form>
                <div x-data="{ isOpen: false }">
                    <div x-data="{ isEdit: false }"
                        class="grid grid-cols-[4%_25%_25%_25%_auto] border-b border-gray-400 text-sm">
                        <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $loop->iteration }}</p>
                        <div class="border-r border-gray-400">
                            <input x-bind:value="'{{ $mahasiswa['name'] }}'" :disabled="!isEdit"
                                :class="{
                                    'bg-white cursor-text w-full transition-all duration-300 ease-in-out border-0 ring-inset ring-2 focus:ring-inset focus:ring-2': isEdit,
                                    'bg-gray-100 cursor-not-allowed w-full transition-all duration-300 ease-in-out focus:outline-none focus:ring-0 border-none':
                                        !isEdit
                                }"
                                form="update-mahasiswa-{{ $mahasiswa['id'] }}" name="name">
                        </div>
                        <div class="border-r border-gray-400">
                            <input
                                :class="{
                                    'bg-white cursor-text w-full transition-all duration-300 ease-in-out border-0 ring-inset ring-2 focus:ring-inset focus:ring-2': isEdit,
                                    'bg-gray-100 cursor-not-allowed w-full transition-all duration-300 ease-in-out focus:outline-none focus:ring-0 border-none':
                                        !isEdit
                                }"
                                x-bind:value="'{{ $mahasiswa['prodi'] }}'" :disabled="!isEdit"
                                form="update-mahasiswa-{{ $mahasiswa['id'] }}" name="prodi">
                        </div>
                        <div class="border-r border-gray-400">
                            <input
                                :class="{
                                    'bg-white cursor-text w-full transition-all duration-300 ease-in-out border-0 ring-inset ring-2 focus:ring-inset focus:ring-2': isEdit,
                                    'bg-gray-100 cursor-not-allowed w-full transition-all duration-300 ease-in-out focus:outline-none focus:ring-0 border-none':
                                        !isEdit
                                }"
                                x-bind:value="'{{ $mahasiswa['username'] }}'" :disabled="!isEdit"
                                form="update-mahasiswa-{{ $mahasiswa['id'] }}" name="username">
                        </div>


                        <div class="flex items-center justify-center gap-5">

                            <button class="rounded bg-[#2D3648] px-5 py-1 text-white" @click="isEdit = !isEdit">
                                <x-heroicon-m-pencil-square
                                    class="h-4 w-4 transform transition-transform duration-300" />
                            </button>
                            <button type="submit" id="update-mahasiswa"
                                form="update-mahasiswa-{{ $mahasiswa['id'] }}"
                                :class="{
                                    'rounded bg-[#2D3648] px-5 py-[2px] text-white transition-all duration-300 ease-in-out': isEdit,
                                    'rounded bg-gray-400 cursor-default px-5 py-[2px] text-white transition-all duration-300 ease-in-out':
                                        !isEdit
                                }">
                                Simpan
                            </button>
                            <button class="rounded bg-[#2D3648] px-5 py-1 text-white" @click="isOpen = !isOpen">
                                <x-heroicon-c-chevron-down class="h-4 w-4 transform transition-transform duration-300"
                                    x-bind:class="isOpen ? '-rotate-180' : ''" />
                            </button>
                        </div>
                    </div>
                    <div x-show="isOpen" x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-100 transform"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="glow-left grid grid-cols-[4%_25%_25%_25%_auto] border-l-4 border-l-emerald-400 p-2">
                        <div class=""></div>
                        <div>
                            <h4 class="text-sm font-medium">Name</h4>
                            <p class="text-light text-[12px] text-gray-500">
                                {{ $mahasiswa['name'] }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium">Program Studi</h4>
                            <p class="text-light text-[12px] text-gray-500">
                                {{ $mahasiswa['prodi'] }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium">NIM</h4>
                            <p class="text-light text-[12px] text-gray-500">
                                {{ $mahasiswa['username'] }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium">Email</h4>
                            <p class="text-light break-words text-[12px] text-gray-500">
                                {{ $mahasiswa['email'] ? $mahasiswa['email'] : 'Belum ditambahkan' }}</p>
                        </div>
                        <hr class="col-span-5 my-2 border">
                        <div class=""></div>
                        <div>
                            <h4 class="text-sm font-medium">No Handphone</h4>
                            <p class="text-light break-words text-[12px] text-gray-500">
                                {{ $mahasiswa['phone_number'] ? $mahasiswa['phone_number'] : 'Belum ditambahkan' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    </main>
    <style>
        .glow-left {
            box-shadow:
                inset 8px 0 15px -10px rgba(16, 185, 129, 0.6),
                inset 0 8px 10px -10px rgba(48, 48, 48, 0.6),
                inset 0 -8px 10px -10px rgba(48, 48, 48, 0.6)
                /* Shadow hijau ke kiri */
        }
    </style>
</x-layout>
