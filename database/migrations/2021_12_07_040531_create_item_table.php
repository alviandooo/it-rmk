<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->string('nama_item');
            $table->string('tanggal');
            $table->string('merk');
            $table->string('serie_item');
            $table->string('kode_item');
            $table->string('gambar')->nullable();
            $table->string('status_fisik'); //baru atau bekas
            $table->string('status_item'); //ready atau tidak ready atau request
            $table->string('sap_item_number')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('satuan_id');
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
        Schema::dropIfExists('item');
    }
}
