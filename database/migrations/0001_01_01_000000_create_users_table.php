<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('user_db')->create('companies', function (Blueprint $table) {
            $table->id(); // Primary key integer
            $table->uuid('uuid')->unique(); // Untuk public identifier
            $table->string('name');
            $table->string('tax_number')->nullable();
            $table->timestamps();
        });

        Schema::connection('user_db')->create('users', function (Blueprint $table) {
            $table->id(); // Primary key integer
            $table->uuid('uuid')->unique(); // Untuk model binding
            $table->foreignId('company_id')->constrained('companies');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::connection('user_db')->create('applications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name'); // accounting, inventory, pos
            $table->timestamps();
        });

        Schema::connection('user_db')->create('roles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('application_id')->constrained('applications');
            $table->string('name');
            $table->timestamps();
        });

        Schema::connection('user_db')->create('model_has_roles', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles');
            $table->unsignedBigInteger('model_id'); // Integer relation
            $table->string('model_type');
            $table->index(['model_id', 'model_type']);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::connection('user_db')->create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();

            // Foreign key ke users.id (integer)
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        // Tambahkan di user_db migration
        Schema::connection('user_db')->create('plans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name'); // Contoh: Free Bot, Pro AI
            $table->string('slug')->unique(); // Contoh: free-bot, pro-ai
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('billing_interval')->nullable(); // monthly, yearly
            $table->json('features')->nullable(); // Fitur spesifik paket
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::connection('user_db')->create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('plan_id')->constrained('plans');
            $table->string('status')->default('active'); // active, expired, canceled
            $table->dateTime('trial_ends_at')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->dateTime('canceled_at')->nullable();
            $table->string('payment_gateway')->nullable(); // stripe, paypal, etc
            $table->string('gateway_id')->nullable(); // ID dari payment gateway
            $table->text('gateway_payload')->nullable(); // Response raw dari gateway
            $table->timestamps();
        });

        Schema::connection('user_db')->create('subscription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('subscriptions');
            $table->foreignId('plan_id')->constrained('plans');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });

        Schema::connection('user_db')->create('subscription_usage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('subscriptions');
            $table->string('feature'); // Contoh: ai_credits, bot_count
            $table->integer('used')->default(0);
            $table->integer('limit')->nullable(); // Batas paket, null = unlimited
            $table->timestamps();

            $table->index(['subscription_id', 'feature']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
        Schema::dropIfExists('users');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('subscription_items');
        Schema::dropIfExists('subscription_usage');
    }
};
