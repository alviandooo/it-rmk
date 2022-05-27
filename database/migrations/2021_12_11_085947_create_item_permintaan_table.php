<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPermintaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_permintaan', function (Blueprint $table) {
            $table->id();
            $table->string('ro_no');
            $table->string('part_name');
            $table->string('part_number');
            $table->string('sap_item_number')->nullable();
            $table->string('component')->nullable();
            $table->string('stock_on_hold')->default(0);
            $table->string('qty_request')->default(0);
            $table->string('qty_request_mr')->default(0);
            $table->string('uom');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('item_permintaan');
    }
}
