<?php

namespace Tests\Feature\Admin\Specialties;

use App\User;
use Tests\TestCase;
use App\Models\Specialty;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListSpecialtiesTest extends TestCase
{
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
    function it_shows_the_specialties_list()
    {
        $this->handleValidationExceptions();

        factory(Specialty::class)->create([
            'name' => 'Anestesiología',
            'created_at' => now()->subDays(2),
        ]);
        factory(Specialty::class)->create([
            'name' => 'Nutriología',
            'created_at' => now()->subDays(1),
        ]);

        $this->actingAs($this->user)
            ->get('/api/specialties')
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    ['name' => 'Nutriología'],
                    ['name' => 'Anestesiología']
                ]
            ]);

    }
    /** @test */
    function it_paginates_the_specialties()
    {
         factory(Specialty::class)->create([
             'name' => 'Tercer especialidad',
             'created_at' => now()->subDays(4),
         ]);
 
         factory(Specialty::class)->times(7)->create([
             'created_at' => now()->subDays(5),
         ]);
 
         factory(Specialty::class)->create([
             'name' => 'Decimoséptimo especialidad',
             'created_at' => now()->subDays(2),

         ]);
 
         factory(Specialty::class)->create([
             'name' => 'Segundo especialidad',
             'created_at' => now()->subDays(6),

         ]);
 
         factory(Specialty::class)->create([
             'name' => 'Primer especialidad',
             'created_at' => now()->subWeek(),

         ]);
 
         factory(Specialty::class)->create([
             'name' => 'Decimosexto especialidad',
             'created_at' => now()->subDays(3),

         ]);
         

        $this->actingAs($this->user)
            ->get('/api/specialties')
            ->assertJson([
                 'data' => [
                     [ 'name' => 'Decimoséptimo especialidad'],
                     [ 'name' => 'Decimosexto especialidad'],
                     [ 'name' => 'Tercer especialidad']

                 ]
            ]) 
             ->assertJsonMissing([
                 'data' => [
                     ['name' => 'Segundo especialidad'],
                     ['name' => 'Primer especialidad']
                 ]
             ]);
         $this->get('/api/specialties?page=2')
                ->assertJson([
                    'data' => [
                        ['name' => 'Segundo especialidad'],
                        [ 'name' => 'Primer especialidad'],
                    ]
                ])
             ->assertJsonMissing([
                 'data' => [
                        ['Tercer especialidad']
                    ]
                ]);
    }
    /** @test */
    function specialties_are_ordered_by_name()
    {
         factory(Specialty::class)->create(['name' => 'Anestesiología']);
         factory(Specialty::class)->create(['name' => 'Odontologia']);
         factory(Specialty::class)->create(['name' => 'Medicina general']);
        $this->actingAs($this->user)
            ->get('/api/specialties?sort=name|asc')
            ->assertJson([
                'data' => [
                    ['name' => 'Anestesiología'],
                    ['name' => 'Medicina general'],
                    ['name' => 'Odontologia']
                ]
            ]);

        $this->actingAs($this->user)
            ->get('/api/specialties?sort=name|desc')
            ->assertJson([
                'data' => [
                    ['name' => 'Odontologia'],
                    ['name' => 'Medicina general'],
                    ['name' => 'Anestesiología']
                    
                ]
            ]);
            
    }
    /** @test */
    function invalid_order_query_date_is_ignorad_and_default_order_is_used_instead()
    {
        factory(Specialty::class)->create(['name' => 'Anestesiología', 'created_at' => now()->subDays(1)]);
        factory(Specialty::class)->create(['name' => 'Odontologia', 'created_at' => now()->subDays(3)]);
        factory(Specialty::class)->create(['name' => 'Medicina general', 'created_at' => now()->subDays(2)]);
        
        $this->actingAs($this->user)
            ->get('/api/specialties?sort=id')
            ->assertJson([
                'data' => [
                    ['name' => 'Anestesiología'],
                    ['name' => 'Medicina general'],
                    ['name' => 'Odontologia']
                ]
            ]);
        $this->actingAs($this->user)
            ->get('/api/specialties?sort=invalid|desc')
            ->assertJson([
                'data' => [
                    ['name' => 'Anestesiología'],
                    ['name' => 'Medicina general'],
                    ['name' => 'Odontologia']
                ]
            ]);
        
    }
}