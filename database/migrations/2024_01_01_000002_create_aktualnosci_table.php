<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aktualnosci', function (Blueprint $table) {
            $table->id();
            $table->string('tytul');
            $table->string('url')->unique();
            $table->string('poprzedni_url')->nullable();
            $table->longText('tresc');
            $table->string('zdjecie')->nullable();
            $table->string('kategoria')->nullable();
            $table->unsignedBigInteger('autor');
            $table->text('zalaczniki')->nullable();
            $table->timestamps();
        });

        Schema::create('aktualnosci_zdjecia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aktualnosci_id');
            $table->string('zdjecie');
            $table->string('alt')->nullable();
            $table->timestamps();
        });

        Schema::create('aktualnosciGalerie', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('tytul')->nullable();
            $table->unsignedBigInteger('aktualnosciID');
            $table->timestamps();
        });

        Schema::create('aktualnosciWideo', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->unsignedBigInteger('aktualnosciID');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aktualnosci');
        Schema::dropIfExists('aktualnosci_zdjecia');
        Schema::dropIfExists('aktualnosciGalerie');
        Schema::dropIfExists('aktualnosciWideo');
    }
};
