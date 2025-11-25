<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Album;
use App\Models\User;  


class AlbumControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_index_returns_all_albums()
    {
        Album::factory()->create(['name' => '2Alive']);
        Album::factory()->create(['name' => '3Alive']);

        $response = $this->getJson('/api/albums');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => '2Alive'])
            ->assertJsonFragment(['name' => '3Alive']);
    } 

    
    public function test_index_filters_by_needle()
    {
        Album::factory()->create(['name' => 'Yeat']);
        Album::factory()->create(['name' => 'Sheriff']);

        $response = $this->getJson('/api/albums?needle=bar');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Yeat'])  // Yeat benne van a válaszban
            ->assertJsonMissing(['name' => 'FrankSierra']);  // Franksierra nincs benne
    } 
	
}
