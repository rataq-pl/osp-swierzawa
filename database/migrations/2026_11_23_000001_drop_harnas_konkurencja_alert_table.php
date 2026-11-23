<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // powiadomienia e-mail o nowych glosach konkurencji zostaly wycofane
    public function up(): void
    {
        Schema::dropIfExists('harnas_konkurencja_alert');
    }

    public function down(): void
    {
        Schema::create('harnas_konkurencja_alert', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa')->unique();
            $table->unsignedInteger('glosy');
            $table->timestamp('updated_at')->nullable();
        });
    }
};
