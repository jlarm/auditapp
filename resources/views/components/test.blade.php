<?php

use Livewire\Attributes\On;
use Livewire\Component;
use Native\Mobile\Events\Gallery\MediaSelected;
use Native\Mobile\Facades\Camera;
use Native\Mobile\Facades\Device;
use Native\Mobile\Facades\Dialog;

new class extends Component
{
    public function toast(): void
    {
        Dialog::toast('Image has been selected');
    }

    public function openCamera(): void
    {
        Camera::pickImages('images');
    }

    #[On('native:' . MediaSelected::class)]
    public function triggerToast()
    {
        $this->toast();
    }

};
?>

<div class="h-[400px] flex items-center justify-center bg-blue-500">
    <flux:button wire:click="toast">Alert</flux:button>
    <flux:button wire:click="openCamera">Select Photo</flux:button>
</div>
