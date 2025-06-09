<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Artist;

class ArtistTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_guest_user_can_get_artists(): void
    {
        $response = $this->get('/api/artists');

        $response->assertStatus(200);
    }

    public function test_guest_user_can_create_artist(): void
    {

        $artistData = Artist::factory()->make()->toArray();

        $response = $this->post('/api/add-artist', $artistData, );

        $response->assertStatus(201);
    }
}
