<?php

use App\Services\ApiClientService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;
use Native\Mobile\Facades\SecureStorage;

new class extends Component {
    public function logout(ApiClientService $service): Redirector|RedirectResponse
    {
        try {
            // Get token before clearing
            $token = SecureStorage::get('api_token') ?? session('api_token');

            // Call API logout if token exists
            if ($token) {
                $service->setToken($token)->logout();
            }
        } catch (\Exception $e) {
            // Continue with local cleanup even if API call fails
            logger()->warning('Logout API call failed', ['error' => $e->getMessage()]);
        }

        // Clear both SecureStorage and session
        SecureStorage::delete('api_token');
        SecureStorage::delete('user');

        session()->forget(['api_token', 'user']);
        session()->flush();

        return redirect()->route('login');
    }
};
?>

<div>
    <flux:button wire:click="logout" variant="danger" size="sm" class="w-full">Logout</flux:button>
</div>
