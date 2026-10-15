<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // dzienne odczyty pierwszych 20 jednostek rankingu osp-harnas.pl (CRON harnas:konkurencja);
        // jeden wiersz na jednostke i dzien - glosy_rano to pierwszy odczyt dnia, glosy ostatni
        Schema::create('harnas_konkurencja', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->string('nazwa');
            $table->unsignedInteger('pozycja');
            $table->unsignedInteger('glosy');
            $table->unsignedInteger('glosy_rano');
            $table->timestamp('updated_at')->nullable();
            $table->unique(['data', 'nazwa']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harnas_konkurencja');
    }
};
