<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory()->create()->id,
            'start_at' => $startAt = fake()->dateTime(),
            'end_at' => Carbon::parse($startAt)->addDays(180)->format('Y-m-d'),
            'sunday_start_at' => '09:00:00',
            'sunday_end_at' => '17:00:00',
            'monday_start_at' => '09:00:00',
            'monday_end_at' => '17:00:00',
            'tuesday_start_at' => '09:00:00',
            'tuesday_end_at' => '17:00:00',
            'wednesday_start_at' => '09:00:00',
            'wednesday_end_at' => '17:00:00',
            'thursday_start_at' => '09:00:00',
            'thursday_end_at' => '17:00:00',
            'friday_start_at' => '09:00:00',
            'friday_end_at' => '17:00:00',
            'saturday_start_at' => '09:00:00',
            'saturday_end_at' => '17:00:00',
        ];
    }
}
