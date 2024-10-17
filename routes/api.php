<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/stripe/webhook', function (Request $request) {
    \Log::info('Stripe webhook received at: ' . now());
    \Log::info('Headers: ' . json_encode($request->headers->all()));
    \Log::info('Body: ' . $request->getContent());
    return response()->json(['message' => 'Webhook received']);
});

// Add a catch-all route for debugging
Route::any('{any}', function (Request $request) {
    \Log::info('Catch-all route hit: ' . $request->fullUrl());
    \Log::info('Method: ' . $request->method());
    \Log::info('Headers: ' . json_encode($request->headers->all()));
    \Log::info('Body: ' . $request->getContent());
    return response()->json(['message' => 'Request received'], 200);
})->where('any', '.*');
