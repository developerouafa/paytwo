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
        Schema::create('paymentgateways', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('invoice_id')->nullable()->references('id')->on('invoices')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('paymentgateways');
    }
};
