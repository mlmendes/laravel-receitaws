<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('atividades', function (Blueprint $table) {
            $table->string('code', 7)->primary();
            $table->string('text');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atividades');
    }
};