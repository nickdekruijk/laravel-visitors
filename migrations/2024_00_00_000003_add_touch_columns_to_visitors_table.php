<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection(config('visitors.db_connection'))->table(config('visitors.table_prefix') . 'visitors', function (Blueprint $table) {
            $table->boolean('touch')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection(config('visitors.db_connection'))->table(config('visitors.table_prefix') . 'visitors', function (Blueprint $table) {
            $table->dropColumn([
                'touch',
            ]);
        });
    }
};
