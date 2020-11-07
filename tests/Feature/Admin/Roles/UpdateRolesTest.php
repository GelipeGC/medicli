<?php

namespace Tests\Feature\Admin\Roles;

use App\User;
use Tests\TestCase;
use App\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateRolesTest extends TestCase
{
    protected $defaultData = [
        'name' => 'Manager',
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
    function it_update_a_role()
    {
        $this->handleValidationExceptions();

        $role = factory(Role::class)->create([
            'name' => 'Editor'
        ]);

        $this->actingAs($this->user)
            ->putJson("/api/roles/{$role->id}/update", $this->withData([
                'name' => 'Manager-user',
            ]))
            ->assertSuccessful()
            ->assertJson([
                'success' => true,
                'message' => 'Role actualizado con éxito.'
            ]);
        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'Manager-user'
        ]);
    }
    /** @test */
    function the_name_field_is_required()
    {
        $this->handleValidationExceptions();

        $role = factory(Role::class)->create([
            'name' => 'Manager-test'
        ]);

        $this->actingAs($this->user)
            ->putJson("/api/roles/{$role->id}/update", $this->withData([
                'name' => '',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

        $this->assertDatabaseMissing('roles', [
            'id' => $role->id,
            'name' => 'Manager-user'
        ]);
    }
    /** @test */
    function the_name_field_contain_min_three_characters()
    {
        $this->handleValidationExceptions();

        $role = factory(Role::class)->create([
            'name' => 'Manager-user'
        ]);

        $this->actingAs($this->user)
            ->putJson("/api/roles/{$role->id}/update", $this->withData([
                'name' => 'ma',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

        $this->assertDatabaseMissing('roles', [
            'id' => $role->id,
            'name' => 'ma'
        ]);
    }
    /** @test */
    function the_name_field_contain_max_fifty_characters()
    {
        $this->handleValidationExceptions();

        $role = factory(Role::class)->create([
            'name' => 'Manager-user'
        ]);

        $this->actingAs($this->user)
            ->putJson("/api/roles/{$role->id}/update", $this->withData([
                'name' => 'Lorem Ipsum is simply dummy text of the printing and typesetting',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

        $this->assertDatabaseMissing('roles', [
            'id' => $role->id,
            'name' => 'Lorem Ipsum is simply dummy text of the printing and typesetting'
        ]);
    }
    /** @test */
    function the_id_role_exists_in_database()
    {
        $this->handleValidationExceptions();
        factory(Role::class)->create();

        $this->actingAs($this->user)
            ->putJson("/api/roles/999/update", $this->withData())
            ->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'El role no fue encontrado.'
            ]);;

        $this->assertDatabaseMissing('roles', [
            'id' => 999,
            'name' => 'Nuevo role'
        ]);
    }
}
