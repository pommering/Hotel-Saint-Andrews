<?php

namespace Database\Factories;

use App\Models\CleanRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

class CleanRoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CleanRoom::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_number' => $this->faker->word,
        'user_id' => $this->faker->word,
        'activitie_id' => $this->faker->word,
        'start_date' => $this->faker->word,
        'end_date' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
