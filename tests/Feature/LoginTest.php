<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }
    /** @test */
    function authenticate()
    {
        $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'secret',
        ])
        ->assertSuccessful()
        ->assertJsonStructure(['token', 'expires_in'])
        ->assertJson(['token_type' => 'bearer']);
    }

    /** @test */
    public function fetch_the_current_user()
    {
        $this->actingAs($this->user)
            ->getJson('/api/user')
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => ['id', 'name', 'email']
                ]   
            );
    }
    
    /** @test */
    function the_email_is_required()
    {
        $this->handleValidationExceptions();

        $this->postJson('/api/login', [
            'email' => ''
        ])
        ->assertJsonValidationErrors(['email']);

    }
    /** @test */
    function the_password_is_required()
    {
        $this->handleValidationExceptions();

        $this->postJson('/api/login', [
            'password' => ''
        ])
        ->assertJsonValidationErrors(['email']);

    }
    /** @test */
    function the_email_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->postJson('/api/login',[
            'email' => 'invalid-email',
            'password' => 'secret'
        ])
        ->assertJsonValidationErrors(['email']);

    }
    /** @test */
    function the_password_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->postJson('/api/login',[
            'email' => $this->user->email,
            'password' => 'invalid'
        ])
        ->assertJsonValidationErrors(['email']);

    }

    /** @test */
    public function log_out()
    {
        $token = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'secret',
        ])->json()['token'];

        $this->postJson("/api/logout?token=$token")
            ->assertSuccessful();

        $this->getJson("/api/user?token=$token")
            ->assertStatus(401);
    }
}
