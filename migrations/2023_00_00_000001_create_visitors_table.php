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

            // IP address
            $table->string('ip')->nullable();
            $table->string('ipv6')->nullable();

            // User Agent and Accept Language headers
            $table->string('user_agent')->nullable();
            $table->string('accept_language')->nullable();

            // GeoIP data https://ip-api.com/docs/api:json#test
            $table->string('continent')->nullable();
            $table->string('continentCode')->nullable()->index();
            $table->string('country')->nullable();
            $table->string('countryCode')->nullable()->index();
            $table->string('region')->nullable();
            $table->string('regionName')->nullable();
            $table->string('city')->nullable()->index();
            $table->string('district')->nullable();
            $table->string('zip')->nullable();
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->string('timezone')->nullable()->index();
            $table->string('offset')->nullable();
            $table->string('currency')->nullable();
            $table->string('isp')->nullable();
            $table->string('org')->nullable();
            $table->string('as')->nullable();
            $table->string('asname')->nullable();
            $table->string('reverse')->nullable();
            $table->boolean('mobile')->nullable();
            $table->boolean('proxy')->nullable();
            $table->boolean('hosting')->nullable();

            // User Agent parsing
            $table->string('languages')->nullable();
            $table->string('device')->nullable()->index();
            $table->string('platform')->nullable()->index();
            $table->string('platform_version')->nullable();
            $table->string('browser')->nullable()->index();
            $table->string('browser_version')->nullable();
            $table->boolean('desktop')->nullable()->index();
            $table->boolean('phone')->nullable()->index();
            $table->string('robot')->nullable()->index();
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
        Schema::connection(config('visitors.db_connection'))->dropIfExists(config('visitors.table_prefix') . 'visitors');
    }
};
