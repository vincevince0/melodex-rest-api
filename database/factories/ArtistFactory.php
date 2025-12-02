<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


use App\Models\Artist;  
use Illuminate\Database\Eloquent\Factories\HasFactory;// ne felejtse el importálni
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artist>
 */
class ArtistFactory extends Factory
{
    use HasFactory;
    protected $model = Artist::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'      => $this->faker->unique()->word(),
            'nationality'     => $this->faker->randomElement(['Hungarian','Belgian','Russian','American','Romanian']),
            'image' => null,
            'description' => null,
            'is_band' => $this->faker->randomElement(['yes','no']),
        ];
    }
}
