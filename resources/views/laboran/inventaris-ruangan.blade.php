<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>

    <main class="inventaris flex h-full flex-col gap-4">
        <!-- SECTION Filtering, Searching, And Adding Rooms-->
        <section class="head-of-inventaris flex max-w-full justify-between gap-4 rounded-xl bg-white p-4 shadow-md">
            <div class="flex w-[400px] items-center rounded-lg border-[2px] p-[0.7px] px-2">
                <label for="search">Search</label>
                <input type="search" id="search" class="auto w-full border-none bg-transparent p-1 focus:ring-0">
            </div>
            <div>
                <button class="rounded-lg border border-[#559f86] bg-[#d0f1e6] px-5 py-2 text-sm">Tambah Ruangan</button>
            </div>
        </section>

        <!-- SECTION Table of Content-->
        <section class="content-of-inventaris h-full overflow-y-scroll rounded-xl bg-white shadow-md">
            <div class="p-4">
                <div
                    class="sticky top-0 z-10 grid grid-cols-[4%_30%_30%_15%_auto] items-center border-b border-gray-400 bg-[#e4e4e4] shadow">
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        No</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Nama Ruangan</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Lokasi</p>
                    <p class="flex h-full items-center justify-center border-r border-gray-400 px-2 py-2 text-center">
                        Kapasistas</p>
                    <p class="flex h-full items-center justify-center px-2 py-2 text-center">
                        Aksi</p>
                </div>

                @foreach ($dataRuangan as $ruangan)
                    <div class="grid grid-cols-[4%_30%_30%_15%_auto] border-b border-gray-400">
                        <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $loop->iteration }}</p>
                        <p class="border-r border-gray-400 px-2 py-2">{{ $ruangan->nama_ruangan }}</p>
                        <p class="border-r border-gray-400 px-2 py-2">{{ $ruangan->lokasi_ruangan }}</p>
                        <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $ruangan->kapasitas }}
                            <span class="text-gray-500">(Orang)</span>
                        </p>
                        <div class="flex items-center justify-center gap-5">
                            <a href="/inventaris-alat/{{ $ruangan->id_ruangan }}"
                                class="rounded bg-blue-400 px-2 text-white">Edit</a>
                            <a href="" class="rounded bg-red-400 px-2 text-white">Delete</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
</x-layout>
