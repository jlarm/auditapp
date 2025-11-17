<?php

use App\Concerns\HasApiToken;
use App\Services\ApiClientService;
use Livewire\Component;

new class extends Component {
    use HasApiToken;

    public string $dealershipId;
    public array $stores = [];

    public function mount(string $dealership, ApiClientService $service): void
    {
        $this->dealershipId = $dealership;
        $token = $this->requireApiToken();

        $this->stores = $service
            ->setToken($token)
            ->getStores($this->dealershipId);
    }
};
?>

<div>
    <div class="space-y-4">
        @foreach($stores as $store)
            <flux:button
                wire:navigate
                href="{{ route('store', [$this->dealershipId, $store['id']]) }}"
                class="w-full"
                variant="primary"
            >{{ $store['name'] }}</flux:button>
        @endforeach
    </div>

    <flux:button
        wire:navigate
        icon="arrow-left"
        href="{{ route('dashboard') }}"
        class="w-full mt-4"
    >Back</flux:button>
</div>
