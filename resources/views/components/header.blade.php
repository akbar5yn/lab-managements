<header class="sticky top-0 z-50">
    <div
        class="header sticky top-0 z-[100] flex h-[60px] items-center justify-between rounded-xl bg-[#FFFFFF] px-4 py-5 shadow-md">

        <div class="flex items-center gap-2">
            @if (isset($subtitle) && isset($subtitle))
                <h1 class="text-xl font-medium">{{ $title }}</h1>
                <x-heroicon-m-chevron-right class="w-5" />
                <h2 class="text-xl font-normal">{{ $subtitle }}</h2>
            @else
                <h1 class="text-base font-medium xl:text-xl">{{ $title }}</h1>
            @endif
        </div>
        <h4 class="hidden xl:block xl:text-xl">Hi, {{ $name }}</h4>
        <x-heroicon-s-bars-3 class="block size-5 xl:hidden" @click="isSidebarOpen = !isSidebarOpen" />
    </div>
    <x-nav-bar class="top-5" />
</header>
