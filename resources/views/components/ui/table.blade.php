<div {{ $attributes->merge(['class' => 'overflow-x-auto rounded-xl border border-slate-200 bg-white']) }}>
    <table class="min-w-full divide-y divide-slate-200">
        {{ $slot }}
    </table>
</div>
