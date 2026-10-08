<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // jeden wiersz (id = 1) z ostatnim wynikiem OSP Swierzawa w rankingu osp-harnas.pl
        Schema::create('harnas_ranking', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pozycja')->nullable();
            $table->unsignedInteger('glosy')->nullable();
            $table->unsignedInteger('strona')->nullable();
            $table->unsignedInteger('wszystkich')->nullable();
            $table->unsignedInteger('start')->nullable();
            $table->timestamp('aktualizacja')->nullable();
            $table->timestamp('proba')->nullable();
            $table->string('blad')->nullable();
        });

        DB::table('harnas_ranking')->insert(['id' => 1]);
    }

    public function down(): void
    {
        Schema::dropIfExists('harnas_ranking');
    }
};
