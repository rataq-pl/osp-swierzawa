<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // kiedy link "Potwierdz" z wiadomosci zostal klikniety z panelu /admin/przekierowania
    public function up(): void
    {
        Schema::table('harnas_przekierowania_log', function (Blueprint $table) {
            $table->timestamp('potwierdzono_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('harnas_przekierowania_log', function (Blueprint $table) {
            $table->dropColumn('potwierdzono_at');
        });
    }
};
