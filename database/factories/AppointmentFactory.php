<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'service_id' => Service::inRandomOrder()->first()->id,
            'start_at' => fake()->timeString('now'),
            'end_at' => fake()->dateTimeBetween('now', '+1 year'),
            'cancelled_at' => null,
            'name' => fake()->name(),
            'email' => fake()->email(),
        ];
    }
}
