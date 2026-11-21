<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // liczba glosow jednostki przy ostatnim powiadomieniu e-mail (CRON harnas:konkurencja);
        // gdy aktualne glosy przekrocza ja o prog (HARNAS_ALERT_PROG), wysylane jest powiadomienie
        Schema::create('harnas_konkurencja_alert', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa')->unique();
            $table->unsignedInteger('glosy');
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harnas_konkurencja_alert');
    }
};
