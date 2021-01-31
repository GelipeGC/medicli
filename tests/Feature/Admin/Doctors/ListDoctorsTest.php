<?php

namespace Tests\Feature\Admin\Doctors;

use App\Models\User;
use Tests\TestCase;
use App\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListDoctorsTest extends TestCase
{
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->role = Role::factory()->create(['name' => 'Super Admin', 'guard_name' => 'api']);
        $this->user = User::factory()->create();
        $this->roleDoctor = Role::factory()->create(['name' => 'Doctor', 'guard_name' => 'api']);

        $this->user->assignRole($this->role);
    }
    /** @test */
    function it_shows_the_doctors_lists()
    {
        $this->handleValidationExceptions();


        $doctorOne = User::factory()->create([
            'name' => 'Dr. Felipe',
            'created_at' => now()->subDays(2),
        ]);

        $doctorTwo = User::factory()->create([
            'name' => 'Dra. Delia',
            'created_at' => now()->subDays(1)
        ]);
        $doctorOne->assignRole($this->roleDoctor);
        $doctorTwo->assignRole($this->roleDoctor);

        $test = $this->actingAs($this->user)
                ->get('/api/doctors')
                ->assertSuccessful()
                ->assertJson([
                    'data' => [
                        ['name' => 'Dra. Delia'],
                        ['name' => 'Dr. Felipe']

                    ]
                ]);
    }
    /** @test */
    function it_paginates_the_doctors()
    {
         $doctor3 = User::factory()->create([
             'name' => 'Tercer Usuario',
             'created_at' => now()->subDays(4)
         ]);
         $doctor3->assignRole($this->roleDoctor);

         $doctor7 = User::factory()->times(7)->create([
             'created_at' => now()->subDays(5),
         ]);
         foreach ($doctor7 as $doctor) {
             $doctor->assignRole($this->roleDoctor);
         }
         $doctorD = User::factory()->create([
             'name' => 'Decimoséptimo Usuario',
             'created_at' => now()->subDays(2)

         ]);
         $doctorD->assignRole($this->roleDoctor);

         $doctor2 = User::factory()->create([
             'name' => 'Segundo Usuario',
             'created_at' => now()->subDays(6)

         ]);
         $doctor2->assignRole($this->roleDoctor);

         $doctor1 = User::factory()->create([
             'name' => 'Primer Usuario',
             'created_at' => now()->subWeek()
         ]);
         $doctor1->assignRole($this->roleDoctor);

         $doctor4 = User::factory()->create([
             'name' => 'Decimosexto Usuario',
             'created_at' => now()->subDays(3),
         ]);

         $doctor4->assignRole($this->roleDoctor);

        $this->actingAs($this->user)
            ->get('/api/doctors')
            ->assertJson([
                 'data' => [
                     [ 'name' => 'Decimoséptimo Usuario'],
                     [ 'name' => 'Decimosexto Usuario'],
                     [ 'name' => 'Tercer Usuario']

                 ]
            ])
             ->assertJsonMissing([
                 'data' => [
                     ['name' => 'Segundo Usuario'],
                     ['name' => 'Primer Usuario']
                 ]
             ]);
         $this->get('/api/doctors?page=2')
                ->assertJson([
                    'data' => [
                        ['name' => 'Segundo Usuario'],
                        [ 'name' => 'Primer Usuario'],
                    ]
                ])
             ->assertJsonMissing([
                 'data' => [
                        ['Tercer Usuario']
                    ]
                ]);
    }
    /** @test */
    function doctors_are_ordered_by_name()
    {
        $doctor1 = User::factory()->create(['name' => 'John Doe']);
        $doctor2 = User::factory()->create(['name' => 'Richard Roe']);
        $doctor3 = User::factory()->create(['name' => 'Jane Doe']);

        $doctor1->assignRole($this->roleDoctor);
        $doctor2->assignRole($this->roleDoctor);
        $doctor3->assignRole($this->roleDoctor);

        $this->actingAs($this->user)
            ->get('/api/doctors?sort=name|asc')
            ->assertJson([
                'data' => [
                    ['name' => 'Jane Doe'],
                    ['name' => 'John Doe'],
                    ['name' => 'Richard Roe']
                ]
            ]);

        $this->actingAs($this->user)
            ->get('/api/doctors?sort=name|desc')
            ->assertJson([
                'data' => [
                    ['name' => 'Richard Roe'],
                    ['name' => 'John Doe'],
                    ['name' => 'Jane Doe'],
                ]
            ]);

    }
    /** @test */
    function doctors_are_ordered_by_email()
    {
        $doctor1 = User::factory()->create(['email' => 'john.doe@example.com']);
        $doctor2 = User::factory()->create(['email' => 'richard.roe@example.com']);
        $doctor3 = User::factory()->create(['email' => 'jane.doe@example.com']);

        $doctor1->assignRole($this->roleDoctor);
        $doctor2->assignRole($this->roleDoctor);
        $doctor3->assignRole($this->roleDoctor);

        $this->actingAs($this->user)
         ->get('/api/doctors?sort=email|asc')
            ->assertJson([
                'data' => [
                    ['email' => 'jane.doe@example.com'],
                    ['email' => 'john.doe@example.com'],
                    ['email' => 'richard.roe@example.com']
                ]
            ]);

        $this->actingAs($this->user)
            ->get('/api/doctors?sort=email|desc')
            ->assertJson([
                'data' => [
                    ['email' => 'richard.roe@example.com'],
                    ['email' => 'john.doe@example.com'],
                    ['email' => 'jane.doe@example.com'],
                ]
            ]);

    }

    /** @test */
    function invalid_order_query_date_is_ignorad_and_default_order_is_used_instead()
    {
        $doctor1 = User::factory()->create(['name' => 'John Doe', 'created_at' => now()->subDays(1)]);
        $doctor2 = User::factory()->create(['name' => 'Richard Roe', 'created_at' => now()->subDays(2)]);
        $doctor3 = User::factory()->create(['name' => 'Jane Doe', 'created_at' => now()->subDays(3)]);

        $doctor1->assignRole($this->roleDoctor);
        $doctor2->assignRole($this->roleDoctor);
        $doctor3->assignRole($this->roleDoctor);

        $this->actingAs($this->user)
            ->get('/api/doctors?sort=id')
            ->assertJson([
                'data' => [
                    ['name' => 'John Doe'],
                    ['name' => 'Richard Roe'],
                    ['name' => 'Jane Doe'],
                ]
            ]);
        $this->actingAs($this->user)
            ->get('/api/doctors?sort=invalid|desc')
            ->assertJson([
                'data' => [
                    ['name' => 'John Doe'],
                    ['name' => 'Richard Roe'],
                    ['name' => 'Jane Doe'],
                ]
            ]);

    }

}
