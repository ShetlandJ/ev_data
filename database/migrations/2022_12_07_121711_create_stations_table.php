<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('external_id')->nullable();
            $table->string('site_id')->nullable();

            $table->float('tariff_amount')->nullable();
            $table->string('tariff_currency')->nullable();
            $table->float('tariff_connection_fee')->nullable();

            $table->string('address_sitename')->nullable();
            $table->string('address_streetnumber')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_area')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_postcode')->nullable();
            $table->string('address_country')->nullable();

            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();

            $table->string('allowed_vehicle_type')->nullable();

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
        Schema::dropIfExists('stations');
    }
}
