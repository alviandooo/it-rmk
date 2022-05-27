<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPerbaikanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_perbaikan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_item');
            $table->string('nip');
            $table->string('jenis_perbaikan');
            $table->date('tanggal_perbaikan');
            $table->date('tanggal_selesai')->nullable();
            $table->string('status_perbaikan');
            $table->text('deskripsi')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('hasil_perbaikan')->nullable();
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
        Schema::dropIfExists('item_perbaikan');
    }
}
