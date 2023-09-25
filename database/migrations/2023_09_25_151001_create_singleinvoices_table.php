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
        Schema::create('singleinvoices', function (Blueprint $table) {
            $table->id();
            $table->double('price', 8, 2)->default(0);
            $table->double('discount_value', 8, 2)->default(0);
            $table->string('tax_rate');
            $table->string('tax_value');
            $table->double('total_with_tax', 8, 2)->default(0);
            $table->integer('Payment_type');
            $table->date('Payment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('singleinvoices');
    }
};
