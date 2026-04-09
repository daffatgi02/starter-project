@props(['tabs' => []])

<div x-data="{ activeTab: '{{ $tabs[0] ?? '' }}' }" {{ $attributes }}>
    <div class="border-b border-slate-200">
        <nav class="-mb-px flex gap-6" aria-label="Tabs">
            @foreach($tabs as $tab)
                <button
                    @click="activeTab = '{{ $tab }}'"
                    :class="activeTab === '{{ $tab }}'
                        ? 'border-primary-500 text-primary-600'
                        : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                    class="whitespace-nowrap border-b-2 py-3 px-1 text-sm font-medium transition-colors duration-150"
                    type="button"
                >
                    {{ $tab }}
                </button>
            @endforeach
        </nav>
    </div>
    <div class="mt-4">
        {{ $slot }}
    </div>
</div>
