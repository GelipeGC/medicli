<?php

namespace Tests\Feature\Admin\Roles;

use App\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateRoleTest extends TestCase
{
    protected $defaultData = [
        'name' => 'users_manage',
        'guard_name' => 'api'
    ];
    public function setUp(): void
    {
        parent::setUp();
        //factory(Permission::class)->create();

        $this->role = factory(Role::class)->create();
        //$this->role->givePermissionTo('Create Role');

        $this->user = factory(User::class)->create();
        
        $this->user->assignRole($this->role);
    }
    /** @test */
    function a_user_with_permission_can_create_a_new_role()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/roles/store', $this->withData())
            ->assertSuccessful()
            ->assertJson([
                'success' => true,
                'message' => 'Role creado con éxito.'
            ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'users_manage'
        ]);
    }
    /** @test */
    function the_name_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/roles/store', $this->withData([
                'name' => ''
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
        
        $this->assertDatabaseMissing('roles', [
            'name' => 'users_manage'
        ]);

    }
    /** @test */
    function the_name_field_contain_min_three_characters()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/roles/store', $this->withData([
                'name' => 'ab'
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

        $this->assertDatabaseMissing('roles', [
                'name' => 'users_manage',
            ]);

    }
    /** @test */
    function the_name_field_contain_max_characters()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/roles/store', $this->withData([
                'name' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
        
            $this->assertDatabaseMissing('roles', [
                'name' => 'users_manage',
            ]);

    }
    /** @test */
    function the_name_field_is_unique()
    {
        $this->handleValidationExceptions();

        factory(Role::class)->create(['name' => 'users_manage', 'guard_name' => 'api']);

        $this->actingAs($this->user)
            ->postJson('/api/roles/store', $this->withData([
                'name' => 'users_manage'
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
    /** @test */
    function a_user_without_permission_can_not_create_a_new_role()
    {
        $this->handleValidationExceptions();

        $role = factory(Role::class)->create(['name' => 'user_auditor', 'guard_name' => 'api']);
        $role->revokePermissionTo('Create Role');

        $user = factory(User::class)->create();
        
        $user->assignRole($role);
        

        $this->actingAs($user)
            ->postJson('/api/roles/store', $this->withData([
                'name' => 'users_manage'
            ]))
            ->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'El usuario no tiene permisos para realizar esta acción.'
            ]);
    }
}
