<?php

use App\Services\ApiClientService;
use Livewire\Component;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Native\Mobile\Facades\SecureStorage;

new class extends Component {
    public string $email = '';
    public string $password = '';

    public function login(ApiClientService $service): Redirector|RedirectResponse|null
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $response = $service->login($this->email, $this->password);

            // Store in both SecureStorage (for native) and session (for web)
            SecureStorage::set('api_token', $response['token']);
            SecureStorage::set('user', json_encode($response['user'], JSON_THROW_ON_ERROR));

            session([
                'api_token' => $response['token'],
                'user' => $response['user'],
            ]);

            return redirect('/');
        } catch (Exception $e) {
            $this->addError('login', 'Invalid email or password: ' . $e->getMessage());
            return null;
        }
    }
};
?>

<div class="flex flex-col items-center justify-center max-w-md min-h-screen">
    <img class="size-24" src="{{ asset('icon.png') }}" alt="">
    <flux:card class="w-full space-y-6">
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

            <flux:error name="login"/>

            <div class="space-y-2">
                <flux:button type="submit" variant="primary" class="w-full">Log in</flux:button>
            </div>
        </form>
    </flux:card>
</div>
