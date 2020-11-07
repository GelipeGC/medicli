<?php

namespace Tests\Feature\Admin\Roles;

use App\User;
use Tests\TestCase;
use App\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteRolesTest extends TestCase
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
    function it_sends_a_role_to_the_trash()
    {
        $this->handleValidationExceptions();

        $role = factory(Role::class)->create([
            'name' => 'Manager'
        ]);

        $this->actingAs($this->user)
                ->deleteJson("/api/roles/{$role->id}/delete")
                ->assertSuccessful()
                ->assertJson([
                    'success' => true,
                    'message' => "Role eliminado con éxito."
                ]);
        $this->assertSoftDeleted('roles', [
            'id' => $role->id
        ]);

    }
    /** @test */
    function the_id_role_exists_in_database()
    {
        $this->handleValidationExceptions();
        factory(Role::class)->create();

        $this->actingAs($this->user)
            ->deleteJson("/api/roles/999/delete", $this->withData())
            ->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'El role no fue encontrado.'
            ]);
    }
    /** @test */
    function cannot_delete_role_with_relationships_users()
    {
        $this->handleValidationExceptions();

        $admin = factory(Role::class)->create();
        $userOne = factory(User::class)->create();
        $userOne->assignRole($admin);
        $userTwo = factory(User::class)->create();
        $userTwo->assignRole($admin);

        $this->actingAs($this->user)
            ->deleteJson("/api/roles/{$admin->id}/delete", $this->withData())
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => '¡Vaya! Este registro tiene información relacionada, no es posible realizar esta acción.'
            ]);
    }
}
