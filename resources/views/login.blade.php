<x-layout>
    <div class="flex flex-col items-center justify-center max-w-md min-h-screen">
        <img class="size-24" src="{{ asset('icon.png') }}" alt="">
        <flux:card class="w-full space-y-6">
            <livewire:login />
        </flux:card>
    </div>
</x-layout>
