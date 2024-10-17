<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStripeColumnsToUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('stripe_id')->nullable()->after('password');
            $table->boolean('subscribed')->default(false)->after('stripe_id');
            $table->timestamp('subscription_ends_at')->nullable()->after('subscribed');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['stripe_id', 'subscribed', 'subscription_ends_at']);
        });
    }
}
    