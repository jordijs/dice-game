<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RankingTest extends TestCase
{
    use WithoutMiddleware;

    public function test_get_players_ranking(): void
    {
        $response = $this->get('/api/players/ranking');

        $response->assertStatus(200);
    }

    public function test_get_players_ranking_loser(): void
    {
        $response = $this->get('/api/players/ranking/loser');

        $response->assertStatus(200);
    }

    public function test_get_players_ranking_winner(): void
    {
        $response = $this->get('/api/players/ranking/winner');

        $response->assertStatus(200);
    }

}
