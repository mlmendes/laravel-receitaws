<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receitaws', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('name')->unique();
            $table->string('token')->unique();
            $table->string('cnpj_recurrence')->nullable();
            $table->string('ccc_recurrence')->nullable();
            $table->string('simples_recurrence')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receitaws');
    }
};
