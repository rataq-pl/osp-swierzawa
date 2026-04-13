<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testy', function (Blueprint $table) {
            $table->id();
            $table->string('tytul');
            $table->string('url')->unique();
            $table->text('opis')->nullable();
            $table->string('zdjecie')->nullable();
            $table->timestamps();
        });

        Schema::create('testy_pytania', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('testy_id');
            $table->text('pytanie');
            $table->text('wyjasnienie')->nullable();
            $table->text('odpowiedzi');
            $table->integer('prawidlowa');
            $table->timestamps();
        });

        Schema::create('testy_wyniki', function (Blueprint $table) {
            $table->id();
            $table->string('mail')->nullable();
            $table->text('nowePytania')->nullable();
            $table->text('noweDzialania')->nullable();
            $table->text('noweWydarzenia')->nullable();
            $table->text('pytania_zadane')->nullable();
            $table->text('odpowiedzi_udzielone')->nullable();
            $table->text('mozliwosci_wyboru')->nullable();
            $table->text('wlasciwe_odpowiedzi')->nullable();
            $table->string('wynikKoncowy')->nullable();
            $table->string('ip')->nullable();
            $table->timestamps();
        });

        Schema::create('testy_wysylka_wynikow', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('testy_id');
            $table->datetime('dodano');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testy');
        Schema::dropIfExists('testy_pytania');
        Schema::dropIfExists('testy_wyniki');
        Schema::dropIfExists('testy_wysylka_wynikow');
    }
};
