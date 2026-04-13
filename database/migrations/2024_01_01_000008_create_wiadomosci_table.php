<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wiadomosci', function (Blueprint $table) {
            $table->id();
            $table->string('imie');
            $table->string('email');
            $table->string('telefon')->nullable();
            $table->text('tresc');
            $table->datetime('kiedy');
            $table->string('ip')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wiadomosci');
    }
};
