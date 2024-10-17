<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CourseShow;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\PremiumContentController;
use App\Http\Controllers\StripeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('courses/{course}', CourseShow::class)->name('courses.show');
Route::resource('videos', VideoController::class);

Route::middleware(['auth', 'subscription'])->group(function () {
    // Premium content routes
});

Route::post('/stripe/webhook', function(Request $request) {
    Log::info('Stripe webhook route accessed');
    return app()->make(\App\Http\Controllers\StripeWebhookController::class)->handleWebhook($request);
})->middleware('api');

Route::get('/test', function () {
    Log::info('Test route hit');
    return response()->json(['message' => 'Test route working']);
});

Route::get('/subscribe', [StripeController::class, 'showSubscriptionPage'])->name('subscribe');
Route::post('/create-checkout-session', [StripeController::class, 'createCheckoutSession'])->name('checkout.session');
Route::get('/checkout/success', [StripeController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [StripeController::class, 'cancel'])->name('checkout.cancel');

require __DIR__.'/auth.php';

// Move the catch-all route to the end
Route::any('{any}', function (Request $request) {
    Log::info('Catch-all route hit', [
        'url' => $request->fullUrl(),
        'method' => $request->method(),
        'content' => $request->getContent()
    ]);
    return response()->json(['message' => 'Catch-all route']);
})->where('any', '.*');
