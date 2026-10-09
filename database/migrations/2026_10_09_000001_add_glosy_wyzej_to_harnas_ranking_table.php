<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // liczba glosow jednostki o jedno miejsce wyzej (do wyliczenia, ile brakuje do awansu)
        Schema::table('harnas_ranking', function (Blueprint $table) {
            $table->unsignedInteger('glosy_wyzej')->nullable()->after('glosy');
        });
    }

    public function down(): void
    {
        Schema::table('harnas_ranking', function (Blueprint $table) {
            $table->dropColumn('glosy_wyzej');
        });
    }
};
