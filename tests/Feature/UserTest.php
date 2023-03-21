<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithoutMiddleWare;

    /** @test Note: only works when testing for the first time with this data. 
     * Following times only the next test will pass 
     * */
    public function a_user_can_be_created()
    {

        $response = $this->post('/api/players', [
            'name' => 'Mister Player',
            'email' => 'player@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('users', [
            'name' => 'Mister Player',
            'email' => 'player@test.com'
        ]);
    }

    /** @test  */
    public function creating_user_with_existing_name_and_email_displays_validation_errors()
    {
        $response = $this->post('/api/players', [
            'name' => 'Mister Player',
            'email' => 'player@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email', 'name');
    }

    /** @test */
    public function login_displays_validation_errors()
    {
        $response = $this->post('/api/login', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    /** @test NOTE: Only works when testing for the first time with this data*/
    public function test_put_players_id_modifies_name()
    {


        $response = $this->put('/api/players/5', [
            'name' => 'Changed new Name'
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'name' => 'Changed new Name',
        ]);
    }

    /** @test */
    public function test_get_players()
    {
        $response = $this->get('/api/players/');

        $response->assertOk();
    }
}
