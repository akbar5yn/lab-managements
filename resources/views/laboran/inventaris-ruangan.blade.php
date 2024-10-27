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
        <!-- SECTION Filtering, Searching, And Adding Rooms-->
        <section class="head-of-inventaris flex max-w-full justify-between gap-4 rounded-xl bg-white p-4 shadow-md">
            <div class="flex w-[400px] items-center rounded-lg border-[2px] p-[0.7px] px-2">
                <label for="search">Search</label>
                <input type="search" id="search" class="auto w-full border-none bg-transparent p-1 focus:ring-0">
            </div>
            <div>
                <x-modal attributeTitle="Tambah Ruangan" attributeButton="Tambahkan Ruangan">
                    <form action="{{ route('post.ruangan') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="flex flex-col gap-6 rounded-lg border p-4">

                            <div
                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                <label class="font-semibold" for="nama_ruangan">Nama Ruangan</label>
                                <input type="text" name="nama_ruangan" id="nama_ruangan" required
                                    class="border-none p-0 capitalize focus:outline-none focus:ring-0">
                            </div>
                            <div
                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                <label class="font-semibold" for="lokasi_ruangan">Lokasi Ruangan</label>
                                <input type="text" name="lokasi_ruangan" id="lokasi_ruangan" required
                                    class="border-none p-0 capitalize focus:outline-none focus:ring-0">
                            </div>
                            <div
                                class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                <label class="font-semibold" for="kapasitas">Kapasista Ruangan</label>
                                <input type="number" min="0" name="kapasitas" id="kapasitas" required
                                    class="border-none p-0 focus:outline-none focus:ring-0">
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

                @php
                    $urutkanRuangan = collect($dataRuangan)->sortByDesc('created_at');
                @endphp

                @foreach ($urutkanRuangan as $ruangan)
                    <div class="grid grid-cols-[4%_30%_30%_15%_auto] border-b border-gray-400">
                        <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $loop->iteration }}</p>
                        <p class="border-r border-gray-400 px-2 py-2">{{ $ruangan->nama_ruangan }}</p>
                        <p class="border-r border-gray-400 px-2 py-2">{{ $ruangan->lokasi_ruangan }}</p>
                        <p class="border-r border-gray-400 px-2 py-2 text-center">{{ $ruangan->kapasitas }}
                            <span class="text-gray-500">(Orang)</span>
                        </p>
                        <div class="flex items-center justify-center gap-5">
                            <x-modal attributeTitle="Edit Ruangan" attributeButton="Edit">
                                <form action="{{ route('edit.ruangan', $ruangan->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex flex-col gap-6 rounded-lg border p-4">

                                        <div
                                            class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                            <label class="font-semibold" for="nama_ruangan">Nama Ruangan</label>
                                            <input type="text" name="nama_ruangan" id="nama_ruangan" required
                                                class="border-none p-0 capitalize focus:outline-none focus:ring-0"
                                                x-bind:value="'{{ $ruangan->nama_ruangan }}'">
                                        </div>
                                        <div
                                            class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                            <label class="font-semibold" for="lokasi_ruangan">Lokasi Ruangan</label>
                                            <input type="text" name="lokasi_ruangan" id="lokasi_ruangan" required
                                                class="border-none p-0 capitalize focus:outline-none focus:ring-0"
                                                x-bind:value="'{{ $ruangan->lokasi_ruangan }}'">
                                        </div>
                                        <div
                                            class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                                            <label class="font-semibold" for="kapasitas">Kapasista Ruangan</label>
                                            <input type="number" min="0" name="kapasitas" id="kapasitas"
                                                required class="border-none p-0 focus:outline-none focus:ring-0"
                                                x-bind:value="'{{ $ruangan->kapasitas }}'">
                                        </div>

                                    </div>
                                    <button type="submit"
                                        class="mt-2 w-full rounded bg-[#84AFA2] px-4 py-2 text-white">Simpan</button>
                                </form>
                            </x-modal>
                            <a href="" class="rounded bg-red-400 px-2 text-white">Delete</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
</x-layout>
