<?php

namespace Tests\Unit;

use App\Http\Controllers\GameController;
use PHPUnit\Framework\TestCase;

class GameControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_game_returns_false_result_when_lost(): void
    {
        //Only works when gameLogic is set to public
        //1. Set values
        $dice1_value = 5;
        $dice2Value = 4;

        //2. Action performed
        $gameController = new GameController;
        $response = $gameController->gameLogic($dice1_value, $dice2Value);


        //3. Verify
        $this->assertFalse($response);
    }

    public function test_game_returns_true_result_when_won(): void
    {
        //NOTE: Only works when gameLogic is set to public

        //1. Set values
        $dice1_value = 1;
        $dice2Value = 6;

        //2. Action performed
        $gameController = new GameController;
        $response = $gameController->gameLogic($dice1_value, $dice2Value);


        //3. Verify
        $this->assertTrue($response);
    }
}
