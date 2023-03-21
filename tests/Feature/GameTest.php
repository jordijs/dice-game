<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class GameTest extends TestCase
{
    use WithoutMiddleware;

    /** @test  */
    public function test_post_game(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/api/players/{id}/games');

        $response->assertStatus(200);
    }

    /** @test  */
    public function test_delete_games(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->delete('/api/players/{id}/games');

        $response->assertStatus(200);
    }

    /** @test  */
    public function test_get_games(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/api/players/{id}/games');

        $response->assertStatus(200);
    }
}
