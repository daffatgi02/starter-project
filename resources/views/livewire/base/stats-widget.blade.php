<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    @foreach($stats as $stat)
        <x-ui.stat-card
            :title="$stat['title']"
            :value="$stat['value']"
            :icon="$stat['icon']"
            :change="$stat['change'] ?? null"
            :changeType="$stat['changeType'] ?? 'neutral'"
            :color="$stat['color'] ?? 'primary'"
        />
    @endforeach
</div>
