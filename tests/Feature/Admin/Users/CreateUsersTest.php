<?php

namespace Tests\Feature\Admin\Users;

use App\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUsersTest extends TestCase
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
        $this->role = factory(Role::class)->create(['name' => 'Super Admin', 'guard_name' => 'api']);
        $this->user = factory(User::class)->create();
        
        $this->user->assignRole($this->role);
    }
    /** @test */
    function a_user_can_create_a_new_user()
    {
        $role = factory(Role::class)->create(['name' => 'User Manager', 'guard_name' => 'api']);

        $this->actingAs($this->user)
                ->postJson('/api/users/store', $this->withData([
                    'role' => $role,
                ]))
                ->assertSuccessful()
                ->assertJson([
                    'created' => true,
                    'message' => 'Usuario creado con éxito.'
                ]);
        $user = User::findByEmail('felipe-guzman.c@hotmail.com');

        $this->assertDatabaseHas('users', [
            'email' => 'felipe-guzman.c@hotmail.com',
        ]);
        
    }
    /** @test */
    function the_name_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/users/store', $this->withData([
                'name' => ''
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

            $this->assertDatabaseMissing('users', [
                'name' => 'Felipe',
                'email' => 'felipe-guzman.c@hotmail.com',
                'password' => 'secret123',
            ]);

    }
    
    /** @test */
    function the_name_field_contain_min_three_characters()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/users/store', $this->withData([
                'name' => 'ab'
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

        $this->assertDatabaseMissing('users', [
                'name' => 'Felipe',
                'email' => 'felipe-guzman.c@hotmail.com',
            ]);

    }
    /** @test */
    function the_name_field_contain_max_characters()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/users/store', $this->withData([
                'name' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,',
                'professions_name_unique' => 'Faker profession'
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
        
            $this->assertDatabaseMissing('users', [
                'name' => 'Felipe',
                'email' => 'felipe-guzman.c@hotmail.com',
            ]);

    }
    /** @test */
    function the_email_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/users/store', $this->withData([
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
            ->postJson('/api/users/store', $this->withData([
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

        factory(User::class)->create([
            'email' => 'felipe-guzman.c@hotmail.com'
        ]);

        $this->actingAs($this->user)
            ->postJson('/api/users/store', $this->withData([
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
    function the_phone_must_be_valid()
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
