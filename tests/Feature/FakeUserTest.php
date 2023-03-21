<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class FakeUserTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function a_fake_user_can_be_created()
    {

        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $password = $this->faker->password(8);

        $response = $this->post('/api/players', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertOk();


        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email
        ]);
    }
}
