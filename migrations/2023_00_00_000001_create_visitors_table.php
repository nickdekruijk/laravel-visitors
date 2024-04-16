<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('visitors.db_connection'))->create(config('visitors.table_prefix') . 'visitors', function (Blueprint $table) {
            $table->id();

            // UUID, used to check for repeated visits
            $table->uuid('uuid')->unique();

            // IP address
            $table->string('ip')->nullable();
            $table->string('ipv6')->nullable();

            // User Agent and Accept Language headers
            $table->string('user_agent')->nullable();
            $table->string('accept_language')->nullable();

            // GeoIP data
            $table->string('country_iso')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('state_name')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->string('timezone')->nullable();
            $table->string('continent')->nullable();
            $table->string('currency')->nullable();

            // User Agent parsing
            $table->string('languages')->nullable();
            $table->string('device')->nullable();
            $table->string('platform')->nullable();
            $table->string('platform_version')->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->boolean('desktop')->nullable();
            $table->boolean('phone')->nullable();
            $table->string('robot')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('visits')->dropIfExists('visitors');
    }
};
