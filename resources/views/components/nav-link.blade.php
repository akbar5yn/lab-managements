@props([
    'active' => false,
    'src' => false,
])
<a {{ $attributes }}
    class="{{ $active ? 'active-dashboard bg-[#F7F9FC] text-[#265166] rounded-l-full shadow-lg' : '' }} relative flex items-center gap-3 p-2 text-sm"
    aria-current="{{ $active ? 'page' : false }}">

    {{ $slot }}

</a>
