<div>
    @if($isOpen)
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[70] overflow-y-auto"
    >
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" wire:click="cancel"></div>

            <div
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative w-full max-w-md transform rounded-xl bg-white shadow-xl"
            >
                <div class="p-6 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-100 mb-4">
                        <x-ui.icon name="exclamation-triangle" size="lg" class="text-red-600" />
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">{{ $title }}</h3>
                    <p class="mt-2 text-sm text-slate-500">{{ $message }}</p>
                </div>
                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200 bg-slate-50 rounded-b-xl">
                    <x-ui.button variant="secondary" wire:click="cancel">
                        Cancel
                    </x-ui.button>
                    <x-ui.button variant="danger" wire:click="confirm" icon="trash">
                        {{ $confirmText }}
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
