<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationConnectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station_connectors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('station_id');
            $table->string('status')->nullable();

            $table->string('connector_id')->nullable();
            $table->string('connector_type')->nullable();
            $table->string('connector_plug_type')->nullable();
            $table->string('connector_plug_type_name')->nullable();
            $table->string('connector_max_charge_rate')->nullable();

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
        Schema::dropIfExists('station_connectors');
    }
}
