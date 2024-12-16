<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public $apiKey;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        // dd(Auth::user()->tokens->first()->token);
        $this->apiKey = Auth::user()->tokens->first() ? Auth::user()->tokens->first()->token : '';
    }

    public function generateApiKey()
    {
        Auth::user()->tokens->each(function ($token) {
            $token->delete();
        });

        $token = Auth::user()->createToken('API Key', ['*'])->plainTextToken;

        $this->apiKey = $token;
    }

    public function deleteApiKey()
    {
        Auth::user()->tokens->each(function ($token) {
            $token->delete();
        });

        $this->apiKey = '';
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('API Key') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Generate a new API key when you need to make requests to the API.') }}
        </p>
    </header>

    <div class="p-5 mt-5 bg-slate-6/50 rounded-lg border border-slate-500 text-white">
        @if ($apiKey)
            <p class="mb-6">Your API Key: <code class="text-sm italic bg-slate-600 p-1">{{ $apiKey }}</code></p>
            <button wire:click="deleteApiKey" class="px-4 py-2 bg-red-500 text-white">Delete API Key</button>
        @else
            <p class="mb-6">No API Key generated yet.</p>
            <button wire:click="generateApiKey" class="px-4 py-2 bg-green-500 text-white rounded">Generate API Key</button>
        @endif
    </div>
</section>
