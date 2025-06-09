<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Album;

class AlbumTest extends TestCase
{
    public function test_guest_user_can_get_all_albums(): void
    {
        $response = $this->get('/api/albums');

        $response->assertStatus(200);
    }

    public function test_guest_user_can_add_new_album(): void
    {
        $albumData = Album::factory()->make()->toArray();

        $response = $this->post('/api/add-album', $albumData);

        $response->assertStatus(201);

    }

    public function test_guest_user_can_get_album_by_id(): void
    {
        $album = Album::factory()->create();

        $response = $this->get("/api/albums/{$album->id}");

        $response->assertStatus(200);
    }
}
