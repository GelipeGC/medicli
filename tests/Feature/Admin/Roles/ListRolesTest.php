<?php

namespace Tests\Feature\Admin\Roles;

use App\User;
use Tests\TestCase;
use App\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListRolesTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        $this->role = factory(Role::class)->create([
            'created_at' => now()->subWeek(2),
        ]);

        $this->user = factory(User::class)->create();
        
        $this->user->assignRole($this->role);
    }
    /** @test */
    function it_shows_the_roles_list()
    {
        $this->handleValidationExceptions();

        factory(Role::class)->create([
            'name' => 'Administrador',
            'created_at' => now()->subDays(2)
        ]);
        factory(Role::class)->create([
            'name' => 'Gerente',
            'created_at' => now()->subDays(1)
        ]);

        $this->actingAs($this->user)
            ->get('/api/roles')
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    ['name' => 'Gerente'],
                    ['name' => 'Administrador']
                ]
            ]);

    }
    /** @test */
    function it_paginates_the_specialties()
    {
         factory(Role::class)->create([
             'name' => 'Tercer role',
             'created_at' => now()->subDays(4),
         ]);
 
         factory(Role::class)->times(7)->create([
             'created_at' => now()->subDays(5),
         ]);
 
         factory(Role::class)->create([
             'name' => 'Decimoséptimo role',
             'created_at' => now()->subDays(2),

         ]);
 
         factory(Role::class)->create([
             'name' => 'Segundo role',
             'created_at' => now()->subDays(6),

         ]);
 
         factory(Role::class)->create([
             'name' => 'Primer role',
             'created_at' => now()->subWeek(),

         ]);
 
         factory(Role::class)->create([
             'name' => 'Decimosexto role',
             'created_at' => now()->subDays(3),

         ]);
         

        $this->actingAs($this->user)
            ->get('/api/roles')
            ->assertJson([
                 'data' => [
                     [ 'name' => 'Decimoséptimo role'],
                     [ 'name' => 'Decimosexto role'],
                     [ 'name' => 'Tercer role']

                 ]
            ]) 
             ->assertJsonMissing([
                 'data' => [
                     ['name' => 'Segundo role'],
                     ['name' => 'Primer role']
                 ]
             ]);
         $this->get('/api/roles?page=2')
                ->assertJson([
                    'data' => [
                        ['name' => 'Segundo role'],
                        [ 'name' => 'Primer role'],
                    ]
                ])
             ->assertJsonMissing([
                 'data' => [
                        ['Tercer role']
                    ]
                ]);
    }
    /** @test */
    function the_roles_are_ordered_by_name()
    {
         factory(Role::class)->create(['name' => 'Autor']);
         factory(Role::class)->create(['name' => 'Editor']);
         factory(Role::class)->create(['name' => 'Manager']);
        $this->actingAs($this->user)
            ->get('/api/roles?sort=name|asc')
            ->assertJson([
                'data' => [
                    ['name' => 'Autor'],
                    ['name' => 'Editor'],
                    ['name' => 'Manager']
                ]
            ]);

        $this->actingAs($this->user)
            ->get('/api/roles?sort=name|desc')
            ->assertJson([
                'data' => [
                    ['name' => 'Super Admin'],
                    ['name' => 'Manager'],
                    ['name' => 'Editor'],
                    ['name' => 'Autor']
                    
                ]
            ]);
            
    }
    /** @test */
    function invalid_order_query_is_ignorad_and_default_order_is_used_instead()
    {
        factory(Role::class)->create(['name' => 'Admin', 'created_at' => now()->subDays(1)]);
        factory(Role::class)->create(['name' => 'Editor', 'created_at' => now()->subDays(3)]);
        factory(Role::class)->create(['name' => 'Manager', 'created_at' => now()->subDays(2)]);
        
        $this->actingAs($this->user)
            ->get('/api/roles?sort=id')
            ->assertJson([
                'data' => [
                    ['name' => 'Admin'],
                    ['name' => 'Manager'],
                    ['name' => 'Editor'],
                ]
            ]);
        $this->actingAs($this->user)
            ->get('/api/roles?sort=invalid|desc')
            ->assertJson([
                'data' => [
                    ['name' => 'Admin'],
                    ['name' => 'Manager'],
                    ['name' => 'Editor'],
                ]
            ]);
        
    }
}