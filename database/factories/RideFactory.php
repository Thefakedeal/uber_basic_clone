<?php

namespace Database\Factories;

use App\Models\Ride;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::users()->inRandomOrder()->first();
        $driver = User::drivers()->inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'driver_id' => $driver->id,
            'from_latitude'=>  26.6661+ (rand(-10,10)/100),
            'from_longitude'=>  87.2878 + (rand(-10,10)/100),
            'to_latitude'=>  26.6661+ (rand(-10,10)/100),
            'to_longitude'=>  87.2878 + (rand(-10,10)/100),
            'status' => Ride::STATUSES[array_rand(Ride::STATUSES)],
            'is_completed' => $this->faker->boolean()
        ];
    }
}
