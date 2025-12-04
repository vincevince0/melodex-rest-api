<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use \App\Models\Song;
use \App\Models\Album;

class SongControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_index_returns_all_songs()
    {
        Song::factory()->create(['name' => '2turnt']);
        Song::factory()->create(['name' => 'staub']);

        $response = $this->getJson('/api/songs');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => '2turnt'])
            ->assertJsonFragment(['name' => 'staub']);
    }

    public function test_index_filters_by_needle()
    {
        Song::factory()->create(['name' => 'HI key']);
        Song::factory()->create(['name' => 'lowpass']);

        $response = $this->getJson('/api/songs?needle=bar');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'HI key'])  // HI key benne van a válaszban
            ->assertJsonMissing(['name' => 'highpass']);  // highpass nincs benne
    }

    public function test_store_creates_new_songs()
    {
        // Létrehozunk egy felhasználót
		$user = User::factory()->create();
		// Lekérjük a tokent
        $token = $user->createToken('TestToken')->plainTextToken;

        $album = Album::factory()->create();
        $song = Song::factory()->create();

		// A Header-ben elküldjük a tokent és meghívjuk a végpontot (postJson) a szükséges adatokkal
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/songs', [
            'name' => '2nite',
            'lyrics' => 'hajra zene',
            'songwriter' => 'ben franklin',
            'album_id' => 1,
            
        ]);

		// teszteljük, hogy 200-as kódot kapunk-e és a válaszban benne van-e az újonnan hozzáadott adat.
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => '2nite']);
		
		// teszteljük, hogy az adatbázisban is ott van-e at adat
        $this->assertDatabaseHas('songs', ['name' => '2nite']);
    }

    public function test_update_modifies_existing_songs()
    {
        $song = Song::factory()->create(['name' => 'haver']);

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patchJson("/api/songs/{$song->id}", [
            'name' => 'miiivan'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'miiivan']);

        $this->assertDatabaseHas('songs', ['id' => $song->id, 'name' => 'miiivan']);
    }

    public function test_update_returns_404_for_missing_song()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patchJson('/api/songs/999', [
            'name' => 'unknown'
        ]);

        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);

    }

    public function test_delete_removes_song()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $song = Song::factory()->create(['name' => 'Vas']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            ])->deleteJson("/api/songs/{$song->id}", [
            ]);

        $response->assertStatus(410)
            ->assertJsonFragment(['message' => 'Deleted']);

        $this->assertDatabaseMissing('songs', ['id' => $song->id]);
    }
}
