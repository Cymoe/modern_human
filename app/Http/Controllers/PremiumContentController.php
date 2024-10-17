<?php

namespace App\Http\Controllers;

use App\Models\PremiumContent;
use Illuminate\Http\Request;

class PremiumContentController extends Controller
{
    public function show($id)
    {
        if (auth()->user()->hasActiveSubscription()) {
            // Fetch and return premium content
            $content = PremiumContent::findOrFail($id);
            return view('premium.show', compact('content'));
        } else {
            // Redirect to subscription page or show limited content
            return redirect()->route('subscription.index');
        }
    }
}

