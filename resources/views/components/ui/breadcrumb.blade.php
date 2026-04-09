@props(['items' => []])

<nav class="flex items-center gap-1 text-sm" aria-label="Breadcrumb">
    <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-slate-600">
        <x-ui.icon name="home" size="sm" />
    </a>
    @foreach($items as $item)
        <x-ui.icon name="chevron-right" size="xs" style="solid" class="text-slate-300" />
        @if(isset($item['route']) && !$loop->last)
            <a href="{{ $item['route'] }}" class="text-slate-500 hover:text-slate-700 font-medium">{{ $item['label'] }}</a>
        @else
            <span class="text-slate-700 font-medium">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
