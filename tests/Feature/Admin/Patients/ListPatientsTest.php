<?php

namespace Tests\Feature\Admin\Patients;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListPatientsTest extends TestCase
{
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->role = Role::factory()->create(['name' => 'Super Admin', 'guard_name' => 'api']);
        $this->user = User::factory()->create();
        $this->user->assignRole($this->role);

        $this->rolePatient = Role::factory()->create(['name' => 'Patient', 'guard_name' => 'api']);
    }
    /** @test */
    function it_shows_the_patients_lists()
    {
        $this->handleValidationExceptions();


        $patientOne = User::factory()->create([
            'name' => 'Paciente Felipe',
            'created_at' => now()->subDays(2),
        ]);

        $patientTwo = User::factory()->create([
            'name' => 'Paciente Delia',
            'created_at' => now()->subDays(1)
        ]);
        $patientOne->assignRole($this->rolePatient);
        $patientTwo->assignRole($this->rolePatient);

        $test = $this->actingAs($this->user)
                ->get('/api/patients')
                ->assertSuccessful()
                ->assertJson([
                    'data' => [
                        ['name' => 'Paciente Delia'],
                        ['name' => 'Paciente Felipe']

                    ]
                ]);
    }
    /** @test */
    function it_paginates_the_patients_users()
    {
         $patient3 = User::factory()->create([
             'name' => 'Tercer Usuario',
             'created_at' => now()->subDays(4)
         ]);
         $patient3->assignRole($this->rolePatient);

         $patient7 = User::factory()->times(7)->create([
             'created_at' => now()->subDays(5),
         ]);
         foreach ($patient7 as $patient) {
             $patient->assignRole($this->rolePatient);
         }
         $patientD = User::factory()->create([
             'name' => 'Decimoséptimo Usuario',
             'created_at' => now()->subDays(2)

         ]);
         $patientD->assignRole($this->rolePatient);

         $patient2 = User::factory()->create([
             'name' => 'Segundo Usuario',
             'created_at' => now()->subDays(6)

         ]);
         $patient2->assignRole($this->rolePatient);

         $patient1 = User::factory()->create([
             'name' => 'Primer Usuario',
             'created_at' => now()->subWeek()
         ]);
         $patient1->assignRole($this->rolePatient);

         $patient4 = User::factory()->create([
             'name' => 'Decimosexto Usuario',
             'created_at' => now()->subDays(3),
         ]);

         $patient4->assignRole($this->rolePatient);

        $this->actingAs($this->user)
            ->get('/api/patients')
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
         $this->get('/api/patients?page=2')
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
    function the_patients_are_ordered_by_name()
    {
        $patient1 = User::factory()->create(['name' => 'John Doe']);
        $patient2 = User::factory()->create(['name' => 'Richard Roe']);
        $patient3 = User::factory()->create(['name' => 'Jane Doe']);

        $patient1->assignRole($this->rolePatient);
        $patient2->assignRole($this->rolePatient);
        $patient3->assignRole($this->rolePatient);

        $this->actingAs($this->user)
            ->get('/api/patients?sort=name|asc')
            ->assertJson([
                'data' => [
                    ['name' => 'Jane Doe'],
                    ['name' => 'John Doe'],
                    ['name' => 'Richard Roe']
                ]
            ]);

        $this->actingAs($this->user)
            ->get('/api/patients?sort=name|desc')
            ->assertJson([
                'data' => [
                    ['name' => 'Richard Roe'],
                    ['name' => 'John Doe'],
                    ['name' => 'Jane Doe'],
                ]
            ]);

    }
    /** @test */
    function patients_are_ordered_by_email()
    {
        $patient1 = User::factory()->create(['email' => 'john.doe@example.com']);
        $patient2 = User::factory()->create(['email' => 'richard.roe@example.com']);
        $patient3 = User::factory()->create(['email' => 'jane.doe@example.com']);

        $patient1->assignRole($this->rolePatient);
        $patient2->assignRole($this->rolePatient);
        $patient3->assignRole($this->rolePatient);

        $this->actingAs($this->user)
         ->get('/api/patients?sort=email|asc')
            ->assertJson([
                'data' => [
                    ['email' => 'jane.doe@example.com'],
                    ['email' => 'john.doe@example.com'],
                    ['email' => 'richard.roe@example.com']
                ]
            ]);

        $this->actingAs($this->user)
            ->get('/api/patients?sort=email|desc')
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
        $patient1 = User::factory()->create(['name' => 'John Doe', 'created_at' => now()->subDays(1)]);
        $patient2 = User::factory()->create(['name' => 'Richard Roe', 'created_at' => now()->subDays(2)]);
        $patient3 = User::factory()->create(['name' => 'Jane Doe', 'created_at' => now()->subDays(3)]);

        $patient1->assignRole($this->rolePatient);
        $patient2->assignRole($this->rolePatient);
        $patient3->assignRole($this->rolePatient);

        $this->actingAs($this->user)
            ->get('/api/patients?sort=id')
            ->assertJson([
                'data' => [
                    ['name' => 'John Doe'],
                    ['name' => 'Richard Roe'],
                    ['name' => 'Jane Doe'],
                ]
            ]);
        $this->actingAs($this->user)
            ->get('/api/patients?sort=invalid|desc')
            ->assertJson([
                'data' => [
                    ['name' => 'John Doe'],
                    ['name' => 'Richard Roe'],
                    ['name' => 'Jane Doe'],
                ]
            ]);

    }
}
