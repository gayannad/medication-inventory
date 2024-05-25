<?php

namespace Database\Factories;

use App\Models\Medication;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medication>
 */
class MedicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Medication::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'qty' => $this->faker->numberBetween(100, 1000),
            'manufactured_date' => Carbon::now(),
            'expired_date' => Carbon::now()->addYears(5),
        ];
    }
}
