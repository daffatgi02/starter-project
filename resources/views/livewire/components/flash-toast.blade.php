<div>
    <div
        class="fixed top-4 right-4 z-[60] space-y-3 w-96"
        x-data="{
            scheduleRemoval(id) {
                setTimeout(() => { @this.call('removeToast', id) }, 4000);
            }
        }"
        @toast-added.window="scheduleRemoval($event.detail.id)"
    >
        @foreach($toasts as $toast)
            <div
                wire:key="toast-{{ $toast['id'] }}"
                x-data="{ show: false }"
                x-init="$nextTick(() => show = true)"
                x-show="show"
                x-transition:enter="transform transition ease-out duration-300"
                x-transition:enter-start="translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transform transition ease-in duration-200"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="translate-x-full opacity-0"
                class="relative"
            >
                <x-ui.toast :type="$toast['type']" :message="$toast['message']">
                    <button
                        wire:click="removeToast('{{ $toast['id'] }}')"
                        type="button"
                        class="ml-auto -mr-1 flex-shrink-0 rounded-lg p-1 text-current opacity-60 hover:opacity-100"
                    >
                        <x-ui.icon name="x-mark" size="xs" />
                    </button>
                </x-ui.toast>
            </div>
        @endforeach
    </div>
</div>
