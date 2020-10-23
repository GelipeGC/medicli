<?php

namespace Tests\Feature\Admin\Doctors;

use App\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateDoctorTest extends TestCase
{
   protected $defaultData = [
       'name' => 'Felipe Guzmán',
       'email' => 'felipe-guzman.c@hotmail.com',
       'cedula' => '234234324',
       'address' => 'Callejon salsipuedes',
       'phone' => '32-3322-3232'
   ];
    public function setUp(): void
    {
        parent::setUp();
        $this->role = factory(Role::class)->create(['name' => 'Super Admin', 'guard_name' => 'api']);
        $this->user = factory(User::class)->create();
        
        $this->user->assignRole($this->role);
    }
    /** @test */
    function a_user_can_create_a_new_doctor()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/doctors/store', $this->withData())
            ->assertSuccessful()
            ->assertJson([
                'success' => true,
                'message' => 'Médico creado con éxito.'
            ]);
        $this->assertDatabaseHas('users', [
            'name' => 'Felipe Guzmán',
            'email' => 'felipe-guzman.c@hotmail.com',        
        ]);
    }
    /** @test */
    function the_doctor_name_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/doctors/store', $this->withData([
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
            ->postJson('/api/doctors/store', $this->withData([
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
            ->postJson('/api/doctors/store', $this->withData([
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
            ->postJson('/api/doctors/store', $this->withData([
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
            ->postJson('/api/doctors/store', $this->withData([
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
        factory(User::class)->create([
            'email' => 'felipe-guzman.c@hotmail.com'
        ]);
        $this->actingAs($this->user)
            ->postJson('/api/doctors/store', $this->withData([
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
            ->postJson('/api/doctors/store', $this->withData([
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
            ->postJson('/api/doctors/store', $this->withData([
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
            ->postJson('/api/doctors/store', $this->withData([
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
            ->postJson('/api/doctors/store', $this->withData([
                'cedula' => '',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['cedula']);
        
            $this->assertDatabaseMissing('users', [
                'cedula' => '234234324'
            ]);

    }

}
