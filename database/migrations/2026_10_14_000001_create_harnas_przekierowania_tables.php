<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // reguly: alias (np. "dominika" lub "harnas*") -> adres(y) docelowe
        Schema::create('harnas_przekierowania', function (Blueprint $table) {
            $table->id();
            $table->string('alias');
            $table->string('email', 500);
            $table->string('opis')->nullable();
            $table->boolean('aktywne')->default(true);
            $table->timestamps();
        });

        // historia obsluzonych wiadomosci ze skrzynki harnas@
        Schema::create('harnas_przekierowania_log', function (Blueprint $table) {
            $table->id();
            $table->string('message_id', 500)->index();
            $table->string('nadawca')->nullable();
            $table->string('temat', 500)->nullable();
            $table->string('alias')->nullable();
            $table->string('email', 500)->nullable();
            $table->string('status', 20);
            $table->string('blad', 500)->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harnas_przekierowania_log');
        Schema::dropIfExists('harnas_przekierowania');
    }
};
