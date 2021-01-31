<?php

namespace Tests\Feature\Admin\Doctors;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class UpdateDoctorTest extends TestCase
{
    protected $defaultData = [
        'name' => 'Felipe Guzmán',
        'email' => 'felipe-guzman.c@hotmail.com',
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
        $this->user->assignRole($this->role);

        $this->doctor = User::factory()->create();
        $this->roleDoctor = Role::factory()->create(['name' => 'Doctor', 'guard_name' => 'api']);
        $this->doctor->assignRole($this->roleDoctor);
    }
     /** @test */
    function it_updates_a_doctor()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->putJson("/api/doctors/{$this->doctor->id}/update", $this->withData([
                'name' => 'update doctor',
                'email' => 'test@test.app',
                'role_id' => $this->roleDoctor->id
            ]))
            ->assertSuccessful()
            ->assertJson([
                'success' => true,
                'message' => 'Médico actualizado con éxito.'
            ]);
        $this->assertDatabaseHas('users', [
            'id' => $this->doctor->id,
            'name' => 'update doctor',
            'email' => 'test@test.app',
        ]);

    }
    /** @test */
    function the_doctor_name_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->putJson("/api/doctors/{$this->doctor->id}/update", $this->withData([
                'name' => ''
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

        $this->assertDatabaseMissing('users', [
            'name' => 'Felipe Guzman'
        ]);
    }
    /** @test */
    function the_doctor_name_field_contain_min_three_characters()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->putJson("/api/doctors/{$this->doctor->id}/update", $this->withData([
                'name' => 'of'
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

       $this->assertDatabaseMissing('users', [
            'name' => 'Felipe Guzman'
        ]);

    }
    /** @test */
    function the_doctor_name_field_contain_max_characters()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->putJson("/api/doctors/{$this->doctor->id}/update", $this->withData([
                'name' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

            $this->assertDatabaseMissing('users', [
                'name' => 'Felipe Guzman'
            ]);

    }
    /** @test */
    function the_doctor_email_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->putJson("/api/doctors/{$this->doctor->id}/update", $this->withData([
                'email' => '',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);

            $this->assertDatabaseMissing('users', [
                'email' => 'felipe-guzman.c@hotmail.com'
            ]);

    }
    /** @test */
    function the_doctor_email_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->putJson("/api/doctors/{$this->doctor->id}/update", $this->withData([
                'email' => 'invalid-email',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);

            $this->assertDatabaseMissing('users', [
                'email' => 'felipe-guzman.c@hotmail.com'
            ]);

    }
    /** @test */
    function the_doctor_email_must_be_unique()
    {
        $this->handleValidationExceptions();
        User::factory()->create([
            'email' => 'felipe-guzman.c@hotmail.com'
        ]);
        $this->actingAs($this->user)
            ->putJson("/api/doctors/{$this->doctor->id}/update", $this->withData([
                'name' => 'Felipe dos',
                'email' => 'felipe-guzman.c@hotmail.com',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);

            $this->assertDatabaseMissing('users', [
                'name' =>'Felipe dos',
                'email' => 'felipe-guzman.c@hotmail.com'
            ]);

    }
    /** @test */
    function the_doctor_phone_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->putJson("/api/doctors/{$this->doctor->id}/update", $this->withData([
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
            ->putJson("/api/doctors/{$this->doctor->id}/update", $this->withData([
                'phone' => 'invalid-cel23'
            ]))
            ->assertJsonValidationErrors(['phone']);

        $this->assertDatabaseMissing('users', [
            'name' => 'Felipe Guzmán',
            'email' => 'felipe-guzman.c@hotmail.com',
            'password' => 'secret123',
        ]);
    }
    /** @test */
    function the_phone_must_be_format_valid()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->putJson("/api/doctors/{$this->doctor->id}/update", $this->withData([
                'phone' => '2233-2343'//format valid 32-3322-3232
            ]))
            ->assertJsonValidationErrors(['phone']);

        $this->assertDatabaseMissing('users', [
            'name' => 'Felipe Guzmán',
            'email' => 'felipe-guzman.c@hotmail.com',
            'password' => 'secret123',
        ]);
    }
    /** @test */
    function the_doctor_cedula_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->putJson("/api/doctors/{$this->doctor->id}/update", $this->withData([
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
            ->putJson("/api/doctors/{$this->doctor->id}/update", $this->withData([
                'role_id' => ''
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['role_id']);

        $this->assertDatabaseMissing('users', [
            'name' => 'Felipe Guzman'
        ]);
    }
    /** @test */
    function the_role_id_field_exists_in_database()
    {
        $this->handleValidationExceptions();

        $test = $this->actingAs($this->user)
            ->putJson("/api/doctors/{$this->doctor->id}/update", $this->withData([
                'role_id' => '100'
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['role_id']);

        $this->assertDatabaseMissing('users', [
            'name' => 'Felipe Guzman'
        ]);
    }
}
