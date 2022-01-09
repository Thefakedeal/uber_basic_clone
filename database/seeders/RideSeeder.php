<?php

namespace Database\Seeders;

use App\Models\Ride;
use App\Models\User;
use Illuminate\Database\Seeder;

class RideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ride::factory()->count(50)->create();
        $user = User::where('email','driver@driver.com')->first();
        Ride::factory()->count(20)->state([
            'driver_id' => $user->id,
        ])->create();
    }
}
