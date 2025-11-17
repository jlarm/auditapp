<?php

use App\Concerns\HasApiToken;
use App\Services\ApiClientService;
use Livewire\Component;

new class extends Component {
    use HasApiToken;

    public $store;
    public string $dealershipId;

    public function mount(string $dealership, string $store, ApiClientService $service): void
    {
        $token = $this->requireApiToken();
        $this->dealershipId = $dealership;
        $storeId = $store;

        $this->store = $service
            ->setToken($token)
            ->getStore($this->dealershipId, $storeId);
    }
};
?>

<div>
    <flux:heading size="xl" class="mb-10">{{ $store['name'] }}</flux:heading>
    <div class="space-y-4">
        <flux:button class="w-full" variant="primary">OSHA</flux:button>
        <flux:button class="w-full" variant="primary">Body Shop</flux:button>
        <flux:button class="w-full" variant="primary">Body Shop</flux:button>
        <flux:button class="w-full" variant="primary">GLBA Walkthrough</flux:button>
        <flux:button class="w-full" variant="primary">Deal Jackets</flux:button>
    </div>
    <flux:button
        wire:navigate
        icon="arrow-left"
        href="{{ route('dealership', $dealershipId) }}"
        class="w-full mt-4"
    >Back</flux:button>
</div>
