<?php

namespace Tests\Feature\Admin\Users;

use App\User;
use Tests\TestCase;
use App\Models\Area;
use App\Models\Role;
use App\Models\Profession;
use Illuminate\Foundation\Testing\WithFaker;

class UpdateUsersTest extends TestCase
{

    protected $defaultData = [
        'name' => 'FELIPE',
        'email' => 'felipe-guzman.c@hotmail.com',
        'password' => 'secret123',
        'address' => 'Callejon salsipuedes',
        'phone' =>'21-3456-7890',
    ];
    /** @var \App\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

    }
    /** @test */
    function it_updates_a_user()
    {
        $this->handleValidationExceptions();

        $user = User::factory()->create();

        $this->actingAs($this->user)
            ->putJson("/api/users/{$user->id}/update", $this->withData([
                'name' => 'TesT',
                'email' => 'test@test.app',
            ]))
            ->assertSuccessful()
            ->assertJson([
                'success' => true,
                'message' => 'Usuario actualizado con éxito.'
            ]);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Test',
            'email' => 'test@test.app',
        ]);

    }

    /** @test */
    function the_name_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->putJson("/api/users/{$this->user->id}/update", $this->withData([
                'name' => ''
            ]))
            ->assertJsonValidationErrors(['name']);

            $this->assertDatabaseMissing('users', [
                'name' => 'Felipe',
                'email' => 'felipe-guzman.c@hotmail.com',
                'password' => 'secret123',
            ]);

    }
    /** @test */
    function the_email_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->putJson("/api/users/{$this->user->id}/update", $this->withData([
                'email' => ''
            ]))
            ->assertJsonValidationErrors(['email']);

            $this->assertDatabaseMissing('users', [
                'name' => 'Felipe',
                'email' => 'felipe-guzman.c@hotmail.com',
                'password' => 'secret123',
            ]);

    }
    /** @test */
    function the_email_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->putJson("/api/users/{$this->user->id}/update", $this->withData([
                'email' => 'invalid-email'
            ]))
            ->assertJsonValidationErrors(['email']);

        $this->assertDatabaseMissing('users', [
            'name' => 'Felipe',
            'email' => 'felipe-guzman.c@hotmail.com',
            'password' => 'secret123',
        ]);
    }
    /** @test */
    function the_email_must_be_unique()
    {
        $this->handleValidationExceptions();

        User::factory()->create([
            'email' => 'felipe-guzman.c@hotmail.com'
        ]);

        $this->actingAs($this->user)
                ->putJson("/api/users/{$this->user->id}/update", $this->withData([
                    'email' => 'felipe-guzman.c@hotmail.com'
            ]))
            ->assertJsonValidationErrors(['email']);

        $this->assertDatabaseMissing('users', [
            'name' => 'Felipe',
            'email' => 'felipe-guzman.c@hotmail.com',
            'password' => 'secret123',
        ]);
    }
    
   
    /** @test */
    function the_phone_must_be_valid_when_update()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/users/store', $this->withData([
                'phone' => 'invalid-cel23'
            ]))
            ->assertJsonValidationErrors(['phone']);

        $this->assertDatabaseMissing('users', [
            'name' => 'Felipe',
            'email' => 'felipe-guzman.c@hotmail.com',
            'password' => 'secret123',
        ]);
    }
}
