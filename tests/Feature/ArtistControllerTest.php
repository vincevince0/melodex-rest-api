<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

//use App\Models\Album;
use App\Models\User;
use \App\Models\Artist;

class ArtistControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_index_returns_all_artists()
    {
        Artist::factory()->create(['name' => 'Lil Yeat']);
        Artist::factory()->create(['name' => 's1rena']);

        $response = $this->getJson('/api/artists');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Lil Yeat'])
            ->assertJsonFragment(['name' => 's1rena']);
    }

    public function test_index_filters_by_needle()
    {
        Artist::factory()->create(['name' => 'Yeat']);
        Artist::factory()->create(['name' => 'Sheriff']);

        $response = $this->getJson('/api/artists?needle=bar');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Yeat'])  // Yeat benne van a válaszban
            ->assertJsonMissing(['name' => 'FrankSierra']);  // Franksierra nincs benne
    }

    public function test_store_creates_new_artist()
    {
        // Létrehozunk egy felhasználót
		$user = User::factory()->create();
		// Lekérjük a tokent
        $token = $user->createToken('TestToken')->plainTextToken;

        $artist = Artist::factory()->create();

		// A Header-ben elküldjük a tokent és meghívjuk a végpontot (postJson) a szükséges adatokkal
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/artists', [
            'name' => 'TesztArtist',
            'nationality' => 'Hungarian',
            'description' => 'nincs',
            'image' => 'teszt.png',
            'is_band' => 'no',
        ]);

		// teszteljük, hogy 200-as kódot kapunk-e és a válaszban benne van-e az újonnan hozzáadott adat.
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'TesztArtist']);
		
		// teszteljük, hogy az adatbázisban is ott van-e at adat
        $this->assertDatabaseHas('artists', ['name' => 'TesztArtist']);
    }

    public function test_update_modifies_existing_artist()
    {
        $artist = Artist::factory()->create(['name' => 'Howly']);

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patchJson("/api/artists/{$artist->id}", [
            'name' => 'NewWave'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'NewWave']);

        $this->assertDatabaseHas('artists', ['id' => $artist->id, 'name' => 'NewWave']);
    }

    public function test_update_returns_404_for_missing_artist()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patchJson('/api/artists/999', [
            'name' => 'Tolna'
        ]);

        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);

    }

    public function test_delete_removes_artist()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $artist = Artist::factory()->create(['name' => 'Vas']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            ])->deleteJson("/api/artists/{$artist->id}", [
            ]);

        $response->assertStatus(410)
            ->assertJsonFragment(['message' => 'Deleted']);

        $this->assertDatabaseMissing('artists', ['id' => $artist->id]);
    }
}
