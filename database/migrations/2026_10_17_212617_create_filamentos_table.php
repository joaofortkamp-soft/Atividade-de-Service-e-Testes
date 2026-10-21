<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('filamentos', function (Blueprint $table) {
            $table->id();
            $table->string('material');
            $table->string('cor');
            $table->string('marca')->nullable();
            $table->integer('peso_gramas')->default(1000);
            $table->decimal('preco', 10, 2);
            $table->integer('estoque')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filamentos');
    }
};