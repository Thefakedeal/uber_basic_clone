<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track_rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_id')->constrained();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->double('distance')->default(0);
            $table->double('rate')->nullable();
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
        Schema::dropIfExists('track_rides');
    }
}
