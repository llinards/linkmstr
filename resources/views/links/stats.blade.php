<x-layouts.app :title="__('Link Statistics')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl py-4">
        <livewire:links.link-stats :link="$link" />
        <livewire:links.geo-stats :link="$link" />
    </div>
</x-layouts.app>
