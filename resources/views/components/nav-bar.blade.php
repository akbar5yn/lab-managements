<div x-bind:class="{ '': !isSidebarOpen, 'block ': isSidebarOpen }"
    class="absolute right-0 top-[62px] z-50 w-full rounded-md shadow transition-all xl:hidden">
    <div class="fixed inset-0 z-40 bg-[#0000003d]" x-show="isSidebarOpen"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="isSidebarOpen = false"></div>
    <div x-show="isSidebarOpen" x-transition:enter="transition transform ease-out duration-300"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform ease-in duration-300" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full" class="relative z-[1000] w-full rounded-xl bg-white p-4">
        <ul class="flex flex-col gap-1">
            <li>
                <a href="{{ route('mahasiswa') }}"
                    class="{{ request()->is('mahasiswa/dashboard') ? 'bg-[#d0f1e673]' : 'bg-white' }} flex items-center gap-3 rounded-sm border p-2">
                    <x-heroicon-s-home class="h-4 w-4" />
                    Beranda
                </a>
            </li>
            <li>
                <a href="{{ route('informasi.alat') }}"
                    class="{{ request()->is('mahasiswa/informasi-alat*') || request()->is('mahasiswa/peminjaman-alat*') ? 'bg-[#d0f1e673] rounded-sm' : 'bg-white' }} flex items-center gap-3 rounded-sm border p-2">
                    <x-heroicon-s-inbox-stack class="h-4 w-4" />
                    Peminjaman Alat
                </a>
            </li>
        </ul>
    </div>
</div>
