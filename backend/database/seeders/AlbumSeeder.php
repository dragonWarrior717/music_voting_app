<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $albums = [
            [
                'song_name' => 'Bohemian Rhapsody',
                'artist_name' => 'Queen',
                'cover_image' => null,
            ],
            [
                'song_name' => 'Hotel California',
                'artist_name' => 'Eagles',
                'cover_image' => null,
            ],
            [
                'song_name' => 'Sweet Caroline',
                'artist_name' => 'Neil Diamond',
                'cover_image' => null,
            ],
            [
                'song_name' => 'Don\'t Stop Believin\'',
                'artist_name' => 'Journey',
                'cover_image' => null,
            ],
            [
                'song_name' => 'Livin\' on a Prayer',
                'artist_name' => 'Bon Jovi',
                'cover_image' => null,
            ],
        ];

        foreach ($albums as $album) {
            Album::create($album);
        }

        // Create some random votes
        $users = User::all();
        $albums = Album::all();

        foreach ($users as $user) {
            foreach ($albums as $album) {
                if (rand(0, 1)) { // 50% chance to create a vote
                    Vote::create([
                        'user_id' => $user->id,
                        'album_id' => $album->id,
                        'vote_type' => rand(0, 1) ? 'up' : 'down',
                    ]);
                }
            }
        }
    }
} 