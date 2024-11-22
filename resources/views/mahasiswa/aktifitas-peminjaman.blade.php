<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>
    <main class="h-full flex-col gap-4 overflow-y-scroll">
        <!-- SECTION Show Alat-->
        <section>
            <!-- ANCHOR Button Navigation-->
            <div class="flex gap-2">
                <a href="{{ route('informasi.alat') }}"
                    class="{{ request()->is('mahasiswa/peminjaman-alat/informasi') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} w-fit rounded-lg px-2 py-1 text-lg font-medium shadow-sm">
                    Informasi Alat
                </a>
                <a href="{{ route('aktivitas.peminjaman') }}"
                    class="{{ request()->is('mahasiswa/peminjaman-alat/aktifitas') ? 'bg-[#2D3648] text-white' : 'border-[2px] border-[#2D3648] text-[#2D3648]' }} w-fit rounded-lg px-2 py-1 text-lg font-medium shadow-sm">
                    Aktivitas Peminjaman
                </a>
            </div>
        </section>
        <section class="flex max-w-full flex-col rounded-xl bg-[#FFFFFF] p-4 shadow-md">
            <div
                class="sticky top-0 z-10 mt-4 grid grid-cols-[15%_15%_30.3%_20.3%_auto] items-center border-b border-gray-400 bg-[#F6F8FB] text-center shadow">
                <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                    ID Transaksi</p>
                <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                    Jumlah Alat</p>
                <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                    Keperluan</p>
                <p class="h-full border-r border-gray-400 px-2 py-2 font-medium">
                    Status Peminjaman</p>
                <p class="h-full border-gray-400 px-2 py-2 font-medium">
                    Detail</p>
            </div>
            <div class="grid grid-cols-[15%_15%_30.3%_20.3%_auto_auto] rounded-md border-b border-gray-400">
                <p class="border-r border-gray-400 px-2 py-2">NE-20244901</p>
                <p class="border-r border-gray-400 px-2 py-2">5 Unit</p>
                <p class="border-r border-gray-400 px-2 py-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Possimus quisquam
                    perspiciatis distinctio repellat unde exercitationem nisi sed dolorem nostrum voluptatibus?</p>
                <p class="border-r border-gray-400 px-2 py-2 text-center">Pending</p>

            </div>
        </section>
</x-layout>
