<header class="sticky top-0 z-50">
    <div
        class="header sticky top-0 z-[100] flex h-[60px] items-center justify-between rounded-xl bg-[#FFFFFF] px-4 py-5 shadow-md">

        <div class="flex flex-col gap-2 xl:flex xl:flex-row xl:items-center">
            @if (isset($subtitle) && isset($subtitle))
                <h1 class="text-base font-medium xl:text-xl">{{ $title }}</h1>
                <x-heroicon-m-chevron-right class="hidden w-5 xl:block" />
                <h2 class="hidden text-xl font-normal xl:block">{{ $subtitle }}</h2>
            @else
                <h1 class="text-base font-medium xl:text-xl">{{ $title }}</h1>
            @endif
        </div>
        <h4 class="hidden xl:block xl:text-xl">Hi, {{ $name }}</h4>
        <x-heroicon-s-bars-3 class="block size-5 xl:hidden" @click="isSidebarOpen = !isSidebarOpen" />
    </div>
    <x-nav-bar class="top-5" />
</header>
