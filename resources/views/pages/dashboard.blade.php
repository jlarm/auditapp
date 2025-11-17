<?php

use App\Concerns\HasApiToken;
use App\Services\ApiClientService;
use Livewire\Component;

new class extends Component {
    use HasApiToken;

    public array $dealerships = [];

    public function mount(ApiClientService $service): void
    {
        $token = $this->requireApiToken();

        $this->dealerships = $service
            ->setToken($token)
            ->getDealerships();
    }
};
?>

<div class="space-y-4">
    @foreach($dealerships as $dealership)
        <flux:button
            wire:navigate
            href="{{ route('dealership', $dealership['id']) }}"
            class="w-full"
            variant="primary"
        >{{ $dealership['name'] }}</flux:button>
    @endforeach
</div>
