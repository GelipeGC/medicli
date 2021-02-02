<?php

namespace Tests\Feature\Admin\Patients;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePatientTest extends TestCase
{
    protected $defaultData = [
        'name' => 'Deli',
        'email' => 'deli@hotmail.com',
        'cedula' => '234234324',
        'address' => 'Callejon salsipuedes',
        'phone' => '32-3322-3232',
        'role_id' => ''
    ];
    public function setUp(): void
    {
        parent::setUp();
        $this->role = Role::factory()->create(['name' => 'Super Admin', 'guard_name' => 'api']);
        $this->user = User::factory()->create();

        $this->rolePatient = Role::factory()->create(['name' => 'Patient', 'guard_name' => 'api']);
    }
    /** @test */
    function it_create_a_new_patient_user()
    {
        $this->handleValidationExceptions();

        $createUser = $this->actingAs($this->user)
            ->postJson('/api/patients/store', $this->withData([
                'role_id' => $this->rolePatient->id
            ]))
            ->assertSuccessful()
            ->assertJson([
                'success' => true,
                'message' => 'Paciente creado con éxito.'
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $createUser['data']['id'],
            'name' => 'Deli',
            'email' => 'deli@hotmail.com',
        ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'Patient'
        ]);
        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => $this->rolePatient->id,
            'model_id' => $createUser['data']['id']
        ]);

    }
     /** @test */
    function the_patient_name_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/patients/store', $this->withData([
                'name' => ''
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

        $this->assertDatabaseMissing('users', [
            'name' => 'Deli'
        ]);
    }
    /** @test */
    function the_patient_name_field_contain_min_three_characters()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/patients/store', $this->withData([
                'name' => 'of'
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

       $this->assertDatabaseMissing('users', [
            'name' => 'Deli'
        ]);

    }
    /** @test */
    function the_patient_name_field_contain_max_characters()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/patients/store', $this->withData([
                'name' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

            $this->assertDatabaseMissing('users', [
                'name' => 'Deli'
            ]);

    }
    /** @test */
    function the_patient_email_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/patients/store', $this->withData([
                'email' => '',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);

            $this->assertDatabaseMissing('users', [
                'email' => 'deli@hotmail.com'
            ]);

    }
    /** @test */
    function the_patient_email_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/patients/store', $this->withData([
                'email' => 'invalid-email',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);

            $this->assertDatabaseMissing('users', [
                'email' => 'deli@hotmail.com'
            ]);

    }
    /** @test */
    function the_patient_email_must_be_unique()
    {
        $this->handleValidationExceptions();
        User::factory()->create([
            'email' => 'deli@hotmail.com'
        ]);
        $this->actingAs($this->user)
            ->postJson('/api/patients/store', $this->withData([
                'name' => 'Deli hope',
                'email' => 'deli@hotmail.com',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);

            $this->assertDatabaseMissing('users', [
                'name' =>'Deli hope',
                'email' => 'deli@hotmail.com'
            ]);

    }
    /** @test */
    function the_patient_phone_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/patients/store', $this->withData([
                'phone' => '',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);

            $this->assertDatabaseMissing('users', [
                'phone' => '223-23223'
            ]);

    }
    /** @test */
    function the_phone_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/patients/store', $this->withData([
                'phone' => 'invalid-cel23'
            ]))
            ->assertJsonValidationErrors(['phone']);

        $this->assertDatabaseMissing('users', [
            'name' => 'Deli',
            'email' => 'deli@hotmail.com',
            'password' => 'secret123',
        ]);
    }
    /** @test */
    function the_phone_must_be_format_valid()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/patients/store', $this->withData([
                'phone' => '2233-2343'//format valid 32-3322-3232
            ]))
            ->assertJsonValidationErrors(['phone']);

        $this->assertDatabaseMissing('users', [
            'name' => 'Deli',
            'email' => 'deli@hotmail.com',
            'password' => 'secret123',
        ]);
    }
    /** @test */
    function the_patient_cedula_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/patients/store', $this->withData([
                'cedula' => '',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['cedula']);

            $this->assertDatabaseMissing('users', [
                'cedula' => '234234324'
            ]);

    }
    /** @test */
    function the_role_id_field_is_required()
    {
        $this->handleValidationExceptions();

        $test = $this->actingAs($this->user)
            ->postJson('/api/patients/store', $this->withData([
                'role_id' => ''
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['role_id']);

        $this->assertDatabaseMissing('users', [
            'name' => 'Deli'
        ]);
    }
    /** @test */
    function the_role_id_field_exists_in_database()
    {
        $this->handleValidationExceptions();

        $test = $this->actingAs($this->user)
            ->postJson('/api/patients/store', $this->withData([
                'role_id' => '100'
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['role_id']);

        $this->assertDatabaseMissing('users', [
            'name' => 'Deli'
        ]);
    }
}
