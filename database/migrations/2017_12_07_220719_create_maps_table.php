<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lot');
            $table->string('watering_type');
            $table->string('soil_type');
            $table->string('municipality');
            $table->string('barangay');
            $table->decimal('area', 10, 2);
            $table->text('coordinates');
            $table->decimal('lot_lat', 10, 7);
            $table->decimal('lot_lng', 10, 7);
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
        Schema::dropIfExists('maps');
    }
}
