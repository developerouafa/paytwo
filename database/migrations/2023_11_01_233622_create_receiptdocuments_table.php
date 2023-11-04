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
        Schema::create('receiptdocuments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_number')->references('invoice_number')->on('invoices')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->string('invoice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receiptdocuments');
    }
};
