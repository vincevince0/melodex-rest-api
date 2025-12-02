<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Album;  
use Illuminate\Database\Eloquent\Factories\HasFactory;// ne felejtse el importálni

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{

    use HasFactory;
    protected $model = Album::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    
    public function definition(): array
    {
        return [
            'name'      => $this->faker->unique()->word(),
            'cover'     => null,
            'year'      => $this->faker->year(),
            'genre'     => $this->faker->randomElement(['rap', 'hip-hop', 'trap', 'rock']),
        ];
    }

    
}
