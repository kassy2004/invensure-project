@props(['label', 'url', 'icon'])

<li onclick="window.location='{{ url($url) }}'"
    class="flex items-center px-5 py-3 cursor-pointer hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700
    {{ Request::is(trim($url, '/')) ? 'bg-orange-500 text-white' : '' }}">
    <x-dynamic-component :component="'lucide-'.$icon" class="h-5 w-5 shrink-0" />
    <span class="ml-3">{{ $label }}</span>
</li>
