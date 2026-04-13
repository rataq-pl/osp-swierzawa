<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsorzy', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa');
            $table->string('zdjecie')->nullable();
            $table->text('opis')->nullable();
            $table->string('www')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsorzy');
    }
};
