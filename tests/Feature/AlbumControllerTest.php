<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Album;
use App\Models\User;
use \App\Models\Artist;


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

    public function test_store_creates_new_album()
    {
        // Létrehozunk egy felhasználót
		$user = User::factory()->create();
		// Lekérjük a tokent
        $token = $user->createToken('TestToken')->plainTextToken;

        $artist = Artist::factory()->create();

		// A Header-ben elküldjük a tokent és meghívjuk a végpontot (postJson) a szükséges adatokkal
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/albums', [
            'name' => 'TesztAlbum',
            'cover' => 'test.jpg',
            'year' => 2024,
            'genre' => 'Rap',
            'artist_id' => 1,
        ]);

		// teszteljük, hogy 200-as kódot kapunk-e és a válaszban benne van-e az újonnan hozzáadott adat.
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'TesztAlbum']);
		
		// teszteljük, hogy az adatbázisban is ott van-e at adat
        $this->assertDatabaseHas('albums', ['name' => 'TesztAlbum']);
    }

    public function test_update_modifies_existing_album()
    {
        $album = Album::factory()->create(['name' => 'Heves']);

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patchJson("/api/albums/{$album->id}", [
            'name' => 'Nógrád'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Nógrád']);

        $this->assertDatabaseHas('albums', ['id' => $album->id, 'name' => 'Nógrád']);
    }

    public function test_update_returns_404_for_missing_album()
    {
        $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->patchJson('/api/albums/999', [
        'name' => 'Tolna'
    ]);

    $response->assertStatus(404);
    $response->assertJsonStructure(['message']);

    } 

    public function test_delete_removes_album()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $album = Album::factory()->create(['name' => 'Vas']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            ])->deleteJson("/api/albums/{$album->id}", [
            ]);

        $response->assertStatus(410)
            ->assertJsonFragment(['message' => 'Deleted']);

        $this->assertDatabaseMissing('albums', ['id' => $album->id]);
    } 
	
}
