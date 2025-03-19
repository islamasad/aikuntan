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
        Schema::connection('accounting_db')->create('accounts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('company_id'); // Tanpa foreign key
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('code');
            $table->enum('type', ['asset', 'liability', 'equity', 'revenue', 'expense']);
            $table->string('name'); // Tambahkan
            $table->string('currency', 3)->default('IDR');
            $table->enum('subtype', ['current', 'non_current'])->nullable(); // Untuk neraca
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->date('balance_date'); // Tanggal opening balance
            $table->boolean('is_locked')->default(false);
            $table->timestamps();

            // Foreign key lokal (parent_id)
            $table->foreign('parent_id')->references('id')->on('accounts');
        });

        Schema::connection('accounting_db')->create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('company_id'); // Tanpa foreign key
            $table->unsignedBigInteger('user_id');    // Tanpa foreign key
            $table->date('transaction_date');
            $table->decimal('total_amount', 15, 2);
            $table->string('reference_number')->nullable(); // No invoice/PO
            $table->text('description')->nullable();
            $table->date('due_date')->nullable(); // Untuk utang/piutang
            $table->enum('status', ['draft', 'posted', 'void'])->default('draft');
            $table->timestamps();
        });

        Schema::connection('accounting_db')->create('taxes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name'); // PPN 11%, PPh 23%, dll
            $table->decimal('rate', 5, 2); // 11.00
            $table->timestamps();
        });

        Schema::connection('accounting_db')->create('transaction_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions'); // Lokal di accounting_db
            $table->foreignId('account_id')->constrained('accounts');         // Lokal di accounting_db
            $table->enum('type', ['debit', 'credit']);
            $table->decimal('amount', 15, 2);
            $table->foreignId('tax_id')->nullable()->constrained('taxes');
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->timestamps();

            $table->index(['account_id', 'transaction_id']);
        });

        Schema::connection('accounting_db')->create('reconciliations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('accounts'); // Akun bank
            $table->date('statement_date');
            $table->decimal('ending_balance', 15, 2);
            $table->json('matched_transactions'); // ID transaksi yang match
            $table->json('unmatched_transactions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('taxes');
        Schema::dropIfExists('transaction_entries');
        Schema::dropIfExists('reconciliations');
    }
};
