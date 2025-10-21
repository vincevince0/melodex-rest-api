<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'vince',
            'email' => 'vince@gmail.com',
            'password' => 'admin',
        ]);

        $this->call([
            ArtistSeeder::class,
            AlbumSeeder::class,
            MemberSeeder::class,
            SongSeeder::class,
        ]);
    }
}
