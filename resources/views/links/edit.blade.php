<x-layouts.app :title="__('Edit Link')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl py-4">
        <livewire:links.link-editor :link="$link" />
    </div>
</x-layouts.app>
