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
        Schema::create('groupprodcuts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('notes')->nullable();
            $table->decimal('Total_before_discount',8,2);
            $table->decimal('discount_value',8,2);
            $table->decimal('Total_after_discount',8,2);
            $table->string('tax_rate');
            $table->decimal('Total_with_tax',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupprodcuts');
    }
};
