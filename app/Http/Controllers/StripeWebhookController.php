<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Log::info('Webhook received', [
            'headers' => $request->headers->all(),
            'content' => $request->getContent()
        ]);

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $webhook_secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $webhook_secret);
            Log::info('Webhook event constructed', ['type' => $event->type]);
        } catch (SignatureVerificationException $e) {
            Log::error('Webhook signature verification failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            Log::error('Webhook processing failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }

        Log::info('Webhook processed', ['type' => $event->type]);

        switch ($event->type) {
            case 'customer.subscription.created':
            case 'customer.subscription.updated':
                $this->handleSubscriptionCreatedOrUpdated($event->data->object);
                break;
            case 'customer.subscription.deleted':
                $this->handleSubscriptionDeleted($event->data->object);
                break;
            case 'checkout.session.completed':
                $this->handleSuccessfulPayment($event->data->object);
                break;
            default:
                Log::info('Unhandled event type', ['type' => $event->type]);
        }

        return response()->json(['success' => true]);
    }

    private function handleSubscriptionCreatedOrUpdated($subscription)
    {
        $user = User::where('stripe_id', $subscription->customer)->first();
        if ($user) {
            $user->subscribed = true;
            $user->subscription_ends_at = Carbon::createFromTimestamp($subscription->current_period_end);
            $user->save();
        }
    }

    private function handleSubscriptionDeleted($subscription)
    {
        $user = User::where('stripe_id', $subscription->customer)->first();
        if ($user) {
            $user->subscribed = false;
            $user->subscription_ends_at = null;
            $user->save();
        }
    }

    private function handleSuccessfulPayment($session)
    {
        $user = User::where('email', $session->customer_details->email)->first();
        if ($user) {
            $user->subscribed = true;
            $user->stripe_id = $session->customer;
            $user->subscription_ends_at = now()->addYear(); // Adjust based on your subscription length
            $user->save();
        }
    }
}
