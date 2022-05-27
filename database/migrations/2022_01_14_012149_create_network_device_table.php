<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetworkDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('network_device', function (Blueprint $table) {
            $table->id();
            $table->string('kode_item');
            $table->string('device_no');
            $table->string('ip');
            $table->string('username');
            $table->string('password');
            $table->string('ssid');
            $table->unsignedBigInteger('lokasi_network_device_id');
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
        Schema::dropIfExists('network_device');
    }
}
