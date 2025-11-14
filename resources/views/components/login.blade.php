<?php

use App\Services\ApiClientService;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Native\Mobile\Facades\SecureStorage;

new class extends Component {
    public string $email = '';
    public string $password = '';

    public function login(ApiClientService $service)
    {
        $response = $service->login($this->email, $this->password);

        // Try SecureStorage first, fallback to session if it fails
        $tokenStored = SecureStorage::set('api_token', $response['token']);
        $userStored = SecureStorage::set('user', json_encode($response['user'], JSON_THROW_ON_ERROR));

        if (!$tokenStored) {
            // Fallback to session storage for development/web context
            session(['api_token' => $response['token']]);
            session(['user' => $response['user']]);
        }

        // Redirect to dashboard
        return redirect('/');
    }
};
?>

<form wire:submit.prevent="login" class="space-y-6">
    <flux:input wire:model="email" label="Email" type="email" placeholder="Your email address"/>

    <flux:field>
        <div class="mb-3 flex justify-between">
            <flux:label>Password</flux:label>

            <flux:link href="#" variant="subtle" class="text-sm">Forgot password?</flux:link>
        </div>

        <flux:input wire:model="password" type="password" placeholder="Your password"/>

        <flux:error name="password"/>
    </flux:field>

    <div class="space-y-2">
        <flux:button type="submit" variant="primary" class="w-full">Log in</flux:button>
    </div>
</form>
