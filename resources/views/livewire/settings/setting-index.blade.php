<div>
    <x-ui.page-header title="Settings" description="Manage application settings." />

    <div class="mt-6 max-w-2xl">
        <x-ui.card>
            <form wire:submit="save" class="space-y-5">
                <x-form.input wire:model="formData.site_name" id="site_name" label="Site Name" placeholder="My Application" />
                <x-form.textarea wire:model="formData.site_description" id="site_description" label="Site Description" rows="3" placeholder="A brief description of the application." />

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-ui.button variant="primary" type="submit" icon="check">Save Settings</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</div>
