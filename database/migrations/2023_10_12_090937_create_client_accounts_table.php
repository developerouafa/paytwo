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
        Schema::create('client_accounts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('invoice_id')->nullable()->references('id')->on('invoices')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('receipt_id')->nullable()->references('id')->on('receipt_accounts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('Payment_id')->nullable()->references('id')->on('paymentaccounts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('bank_id')->nullable()->references('id')->on('banktransfers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('Gateway_id')->nullable()->references('id')->on('paymentgateways')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('Debit',8,2)->nullable();
            $table->decimal('credit',8,2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_accounts');
    }
};
