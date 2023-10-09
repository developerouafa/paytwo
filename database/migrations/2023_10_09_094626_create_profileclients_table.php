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
        Schema::create('profileclients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->string('clienType')->nullable();
            $table->string('nationalIdNumber')->nullable();
            $table->string('commercialRegistrationNumber')->nullable();
            $table->string('taxNumber')->nullable();
            $table->string('adderss')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profileclients');
    }
};
