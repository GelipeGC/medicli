<?php

namespace Tests\Feature\Admin\Specialties;

use App\Models\User;
use Tests\TestCase;
use App\Models\Specialty;
use App\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListSpecialtiesTest extends TestCase
{
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->role = Role::factory()->create(['name' => 'Super Admin', 'guard_name' => 'api']);
        $this->user = User::factory()->create();

        $this->user->assignRole($this->role);
    }

    /** @test */
    function it_shows_the_specialties_list()
    {
        $this->handleValidationExceptions();

        Specialty::factory()->create([
            'name' => 'Anestesiología',
            'created_at' => now()->subDays(2),
        ]);
        Specialty::factory()->create([
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
         Specialty::factory()->create([
             'name' => 'Tercer especialidad',
             'created_at' => now()->subDays(4),
         ]);

         Specialty::factory()->times(7)->create([
             'created_at' => now()->subDays(5),
         ]);

         Specialty::factory()->create([
             'name' => 'Decimoséptimo especialidad',
             'created_at' => now()->subDays(2),

         ]);

         Specialty::factory()->create([
             'name' => 'Segundo especialidad',
             'created_at' => now()->subDays(6),

         ]);

         Specialty::factory()->create([
             'name' => 'Primer especialidad',
             'created_at' => now()->subWeek(),

         ]);

         Specialty::factory()->create([
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
         Specialty::factory()->create(['name' => 'Anestesiología']);
         Specialty::factory()->create(['name' => 'Odontologia']);
         Specialty::factory()->create(['name' => 'Medicina general']);
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
        Specialty::factory()->create(['name' => 'Anestesiología', 'created_at' => now()->subDays(1)]);
        Specialty::factory()->create(['name' => 'Odontologia', 'created_at' => now()->subDays(3)]);
        Specialty::factory()->create(['name' => 'Medicina general', 'created_at' => now()->subDays(2)]);

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
