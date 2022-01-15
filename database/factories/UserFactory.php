<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $role = User::ROLES[array_rand(User::ROLES)];
        $is_driver = $role == User::ROLE_DRIVER;
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role'=> $role,
            'latitude'=> $is_driver?(float) 26.8189206 + (rand(-10,10)/1000):null,  //27.7142
            'longitude'=> $is_driver?(float) 87.2863398 + (rand(-10,10)/1000):null,  //85.3145
            'rate'=> $is_driver?rand(20,50):null,
            'location_updated_at'=> $is_driver?Carbon::now():null,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
