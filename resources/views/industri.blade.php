<x-layouts.app :title="__('industri')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-1">
            {{-- <livewire:fe.industri /> --}}
            @livewire('fe\industri.index')

        </div> 
    </div>
</x-layouts.app>