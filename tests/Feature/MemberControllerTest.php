<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use \App\Models\Member;
use \App\Models\Artist;

class MemberControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_index_returns_all_members()
    {
        Member::factory()->create(['name' => 'Lil Yeat']);
        Member::factory()->create(['name' => 's1rena']);

        $response = $this->getJson('/api/members');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Lil Yeat'])
            ->assertJsonFragment(['name' => 's1rena']);
    }

    public function test_index_filters_by_needle()
    {
        Member::factory()->create(['name' => 'Adkt']);
        Member::factory()->create(['name' => 'Lowkey']);

        $response = $this->getJson('/api/members?needle=bar');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Adkt'])  // Adkt benne van a válaszban
            ->assertJsonMissing(['name' => 'FrankSierra']);  // Franksierra nincs benne
    }

    public function test_store_creates_new_members()
    {
        // Létrehozunk egy felhasználót
		$user = User::factory()->create();
		// Lekérjük a tokent
        $token = $user->createToken('TestToken')->plainTextToken;

        $artist = Artist::factory()->create();
        $member = Member::factory()->create();

		// A Header-ben elküldjük a tokent és meghívjuk a végpontot (postJson) a szükséges adatokkal
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/members', [
            'name' => 'ATag',
            'instrument' => 'piano',
            'year' => 2093,
            'artist_id' => 1,
            'image' => 'teszt.png',
        ]);

		// teszteljük, hogy 200-as kódot kapunk-e és a válaszban benne van-e az újonnan hozzáadott adat.
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'ATag']);
		
		// teszteljük, hogy az adatbázisban is ott van-e at adat
        $this->assertDatabaseHas('members', ['name' => 'ATag']);
    }

    public function test_update_modifies_existing_members()
    {
        $member = Member::factory()->create(['name' => 'Lousy']);

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patchJson("/api/members/{$member->id}", [
            'name' => 'BestWave'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'BestWave']);

        $this->assertDatabaseHas('members', ['id' => $member->id, 'name' => 'BestWave']);
    }

    public function test_update_returns_404_for_missing_member()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patchJson('/api/members/999', [
            'name' => 'unnamed'
        ]);

        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);

    }

    public function test_delete_removes_member()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $member = Member::factory()->create(['name' => 'Vas']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            ])->deleteJson("/api/members/{$member->id}", [
            ]);

        $response->assertStatus(410)
            ->assertJsonFragment(['message' => 'Deleted']);

        $this->assertDatabaseMissing('members', ['id' => $member->id]);
    }
}
