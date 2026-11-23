<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // kazdy godzinny odczyt rankingu osp-harnas.pl (CRON harnas:konkurencja) - przyrost od ostatniego
        // pomiaru i wykres w /admin/przekierowania; harnas_konkurencja trzyma tylko podsumowanie dnia
        Schema::create('harnas_konkurencja_odczyty', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa');
            $table->unsignedInteger('pozycja');
            $table->unsignedInteger('glosy');
            $table->timestamp('created_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harnas_konkurencja_odczyty');
    }
};
