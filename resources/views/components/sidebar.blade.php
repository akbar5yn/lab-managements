@php
    use Illuminate\Support\Str;
    // Ambil kata pertama dari kalimat ketiga (jika ada)
    $thirdSentence = isset($matches[0][2]) ? Str::words($matches[0][2], 1, '') : '';
    // Batasi teks hingga 20 kata
    $limitedName = Str::words($name, 2, ' S');

    $finalName = $limitedName . ' ' . $thirdSentence;
@endphp
<main class="relative hidden flex-col items-center rounded-xl bg-[#2D3648] lg:flex lg:w-[250px]">
    <!-- ANCHOR PROFILE -->
    <section class="flex h-[300px] flex-col items-center justify-center gap-4 px-10 py-4 font-poppins text-white">
        <div class="rounded-full border-2 border-white p-1">
            <img src="/img/avatar.png" alt="avatar" class="w-20 rounded-full bg-white p-1">
        </div>
        <div class="text-center">
            <h1 class="text-base">{{ $finalName }}</h1>
            <p class="text-sm font-light">{{ $role }}</p>
        </div>
    </section>

    <!-- ANCHOR Menu -->
    <section class="sidebar shadow-menu-inset h-[80%] w-full overflow-y-scroll py-5 pl-5">
        <ul class="relative w-full space-y-4 font-poppins text-white">
            <li class="relative">
                <x-nav-link href="/laboran/dashboard" :active="request()->is('laboran/dashboard')" :src="'img/dashboard-icon.svg'">
                    <x-heroicon-s-home
                        class="{{ request()->is('dashboard') ? 'text-[#265166]' : 'text-white' }} h-4 w-4" />
                    Beranda
                </x-nav-link>
            </li>
            <li x-data="{ isOpen: window.location.pathname.includes('laboran/inventaris-alat') || window.location.pathname.includes('inventaris-ruangan') }">

                <button @click="isOpen = !isOpen" type="button" class="flex w-full gap-3 p-2 text-sm">
                    <x-heroicon-s-archive-box
                        class="{{ request()->is('laboran/inventaris') ? 'text-[#265166]' : 'text-white' }} h-4 w-4" />
                    Inventaris
                    <x-heroicon-c-chevron-down
                        class="absolute right-10 h-4 w-4 transform transition-transform duration-300"
                        x-bind:class="isOpen ? '' : '-rotate-90'" />
                </button>
                <div x-show="isOpen" x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75 transform"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                    <x-nav-link href="/laboran/inventaris-alat" :active="request()->is('laboran/inventaris-alat*')">
                        <span class="w-6"></span>
                        Alat & Barang</x-nav-link>
                    <x-nav-link href="{{ route('inventaris-ruangan') }}" :active="request()->is('laboran/inventaris-ruangan*')">
                        <span class="w-6"></span>
                        Ruangan</x-nav-link>
                </div>

            </li>
            <li x-data="{ isOpen: window.location.pathname.includes('peminjaman-alat/') || window.location.pathname.includes('peminjaman-ruangan') }">
                <button @click="isOpen = !isOpen" type="button" class="flex w-full gap-3 p-2 text-sm">
                    <x-heroicon-c-pencil-square class="h-4 w-4" />
                    Peminjaman
                    <x-heroicon-c-chevron-down
                        class="absolute right-10 h-4 w-4 transform transition-transform duration-300"
                        x-bind:class="isOpen ? '' : '-rotate-90'" />
                </button>
                <div x-show="isOpen" x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75 transform"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                    <x-nav-link href="/peminjaman-alat/pengajuan" :active="request()->is('peminjaman-alat*')"> <span class="w-6"></span> Alat &
                        Barang</x-nav-link>
                    <x-nav-link href="/peminjaman-ruangan" :active="request()->is('peminjaman-ruangan')"> <span class="w-6"></span>
                        Ruangan</x-nav-link>
                </div>
            </li>
            <li>
                <x-nav-link href="/jadwal-ruangan" :active="request()->is('jadwal-ruangan')">
                    <x-heroicon-c-calendar-date-range
                        class="{{ request()->is('jadwal-ruangan') ? 'text-[#265166]' : 'text-white' }} h-4 w-4" />
                    Jadwal Ruangan</x-nav-link>
            </li>
            <li>
                <x-nav-link href="/laporan" :active="request()->is('laporan')">
                    <x-heroicon-m-clipboard-document-list
                        class="{{ request()->is('laporan') ? 'text-[#265166]' : 'text-white' }} h-4 w-4" />
                    Laporan</x-nav-link>
            </li>
            <li>
                <x-nav-link href="/pendaftaran-pratikum" :active="request()->is('pendaftaran-pratikum')">
                    <x-heroicon-s-document-arrow-up
                        class="{{ request()->is('pendaftaran-pratikum') ? 'text-[#265166]' : 'text-white' }} h-4 w-4" />
                    Pendaftaran Praktikum</x-nav-link>
            </li>
        </ul>

    </section>
    <section class="flex h-[20%] w-full items-center justify-center">
        <button class="flex items-center gap-3 font-poppins text-sm text-white">
            <x-heroicon-m-arrow-left-start-on-rectangle class="h-4 w-4 text-white" />
            Logout</button>
    </section>
</main>
