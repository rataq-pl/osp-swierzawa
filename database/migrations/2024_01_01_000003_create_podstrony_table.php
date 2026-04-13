<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('podstrony', function (Blueprint $table) {
            $table->id();
            $table->string('url')->unique();
            $table->string('tytul');
            $table->longText('tresc');
            $table->string('zdjecie')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('podstrony');
    }
};
