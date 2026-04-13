<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumenty', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa');
            $table->text('opis')->nullable();
            $table->text('dokumenty');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumenty');
    }
};
