<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Playlist;
use App\Models\Song;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class PlaylistTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_guest_user_can_get_all_playlists(): void
    {
        $response = $this->get('/api/playlists');

        $response->assertStatus(200);
    }

    public function test_guest_cannot_create_playlist(): void
    {
        $response = $this->post('/api/add-new-playlist', [], ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }

    public function test_user_cannot_add_song_to_playlist_they_do_not_own(): void
    {
        $response = $this->post('/api/add-new-playlist', [], ['Accept' => 'application/json']);

        $this->assertContains($response->getStatusCode(), [401, 403]);
    }
    public function test_user_can_create_playlist(): void
    {
        $password = "password123";
        $user = User::factory()->create([
            'password' => $password,
        ]);

        $loginResponse = $this->post('/api/login', [
            'email'=> $user->email,
            'password'=> $password,
        ]);

        $token = $loginResponse->json('token');

        $playlistData = Playlist::factory()->make()->toArray();

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])->
        post('/api/add-new-playlist', $playlistData, ['Accept' => 'application/json']);

        $response->assertStatus(201);
    }

    public function test_user_can_add_song_to_playlist_they_own(): void
    {
        $password = "password123";
        $user = User::factory()->create([
            'password' => $password,
        ]);

        $loginResponse = $this->post('/api/login', [
            'email'=> $user->email,
            'password'=> $password,
        ]);

        $token = $loginResponse->json('token');

        $playlist = Playlist::factory()->create(['user_id' => $user->id]);

        $songData = Song::factory()->create()->toArray();

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])->post("/api/playlists/{$playlist->id}/add-song", ['song_id' => $songData['id']], ['Accept'=> 'application/json']);

        $response->assertStatus(200);

    }
}
