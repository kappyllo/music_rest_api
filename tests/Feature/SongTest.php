<?php

namespace Tests\Feature;

use App\Models\Song;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SongTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_guest_user_can_get_all_songs(): void
    {
        $response = $this->get('/api/songs');

        $response->assertStatus(200);
    }

    public function test_guest_user_can_create_new_song(): void
    {

        $song = Song::factory()->make()->toArray();

        $response = $this->post('/api/add-song', $song);

        $response->assertStatus(201);
    }

    public function test_guest_user_can_get_song_by_id(): void
    {
        $song = Song::factory()->create();

        $response = $this->get("/api/songs/{$song->id}");

        $response->assertStatus(200);
    }

    public function test_guest_user_can_delete_song(): void
    {
        $song = Song::factory()->create();

        $response = $this->delete("/api/songs/{$song->id}");

        $response->assertStatus(200);
    }


}
