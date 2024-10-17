<?php

namespace App\Http\Livewire;

use App\Models\PremiumContent;
use App\Models\LimitedContent;
use Livewire\Component;

class PremiumContent extends Component
{
    public function render()
    {
        if (auth()->user()->hasActiveSubscription()) {
            // Load premium content
            $content = PremiumContent::all();
        } else {
            // Load limited content or set a flag
            $content = LimitedContent::all();
            $needsSubscription = true;
        }

        return view('livewire.premium-content', [
            'content' => $content,
            'needsSubscription' => $needsSubscription ?? false,
        ]);
    }
}

