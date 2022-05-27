<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermintaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permintaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->date('tanggal_butuh');
            $table->date('tanggal');
            $table->string('lokasi_kerja');
            $table->string('unit')->nullable();
            $table->string('hm')->nullable();
            $table->string('ro_no');
            $table->string('status_urgent');
            $table->string('status_approval');

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
        Schema::dropIfExists('permintaan');
    }
}
