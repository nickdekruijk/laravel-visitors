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
            $table->boolean('pixel')->default(0);
            $table->boolean('javascript')->default(0);
            $table->unsignedInteger('screen_width')->nullable();
            $table->unsignedInteger('screen_height')->nullable();
            $table->unsignedInteger('screen_color_depth')->nullable();
            $table->unsignedInteger('screen_pixel_ratio')->nullable();
            $table->unsignedInteger('viewport_width')->nullable();
            $table->unsignedInteger('viewport_height')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection(config('visitors.db_connection'))->table(config('visitors.table_prefix') . 'visitors', function (Blueprint $table) {
            $table->dropColumn([
                'pixel',
                'javascript',
                'screen_width',
                'screen_height',
                'screen_color_depth',
                'screen_pixel_ratio',
                'viewport_width',
                'viewport_height',
            ]);
        });
    }
};
