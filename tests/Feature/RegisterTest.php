<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class RegisterTest extends TestCase
{
    protected $defaultData = [
        'name' => 'Felipe Guzman',
        'email' => 'felipe@test.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ];
    /** @test */
    public function a_user_can_register()
    {
        $this->postJson('/api/register', $this->defaultData())
        ->assertSuccessful()
        ->assertJsonStructure(['id', 'name', 'email']);

        $this->assertCredentials([
            'name' => 'Felipe Guzman',
            'email' => 'felipe@test.com',
            'password' => '12345678',
        ]);
    }

    /** @test */
    function a_user_can_not_register_with_existing_email()
    {
        factory(User::class)->create([
            'email' => 'felipe@test.com'
        ]);

        $this->postJson('/api/register', $this->defaultData())
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
    }
    /** @test */
    function the_name_is_required()
    {
        $this->handleValidationExceptions();

        $this->postJson('/api/register', $this->withData([
            'name' => '',
            
        ]))
        ->assertJsonValidationErrors(['name']);

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_email_is_required()
    {
        $this->handleValidationExceptions();

        $this->postJson('/api/register', $this->withData([
            'email' => '',
            
        ]))
        ->assertJsonValidationErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_email_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->postJson('/api/register', $this->withData([
            'email' => 'invalid-email',
            
        ]))
            ->assertJsonValidationErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_password_is_required()
    {
        $this->handleValidationExceptions();

        $this->postJson('/api/register', $this->withData([
            'password' => '',
            
        ]))
        ->assertJsonValidationErrors(['password']);

        $this->assertDatabaseEmpty('users');
    }
}
