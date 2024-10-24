<header class="header flex h-[60px] items-center justify-between rounded-xl bg-[#FFFFFF] px-4 py-5 shadow-md">
    <div class="flex items-center gap-2">
        @if (isset($subtitle) && isset($subtitle))
            <h1 class="text-xl font-medium">{{ $title }}</h1>
            <x-heroicon-m-chevron-right class="w-5" />
            <h2 class="text-xl font-normal">{{ $subtitle }}</h2>
        @else
            <h1 class="text-xl font-medium">{{ $title }}</h1>
        @endif
    </div>
    <h4>Hi, {{ $name }}</h4>
</header>
