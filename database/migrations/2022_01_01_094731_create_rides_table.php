<?php

use App\Models\Ride;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('driver_id')->constrained('users');
            $table->double('from_latitude');
            $table->double('from_longitude');
            $table->double('to_latitude');
            $table->double('to_longitude');
            $table->enum('status', Ride::STATUSES)->default(Ride::STATUS_PENDING);
            $table->boolean('is_completed')->default(true);
            $table->text('message')->nullable();
            $table->foreignId('track_ride_id')->nullable();
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
        Schema::dropIfExists('rides');
    }
}
