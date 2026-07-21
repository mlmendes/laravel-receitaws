<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('simei_historico', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('simei_id')
                ->constrained('simei', 'uuid')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->date('inicio');
            $table->date('fim')->nullable();
            $table->string('detalhamento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('simei_historico');
    }
};