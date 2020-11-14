<?php

namespace Tests\Feature\Admin\Specialties;

use App\User;
use Tests\TestCase;
use App\Models\Specialty;
use App\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateSpecialtiesTest extends TestCase
{
    protected $defaultData = [
        'name' => 'Oftamología',
        'description' => ''
    ];
    /** @var \App\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->role = Role::factory()->create(['name' => 'Super Admin', 'guard_name' => 'api']);
        $this->user = User::factory()->create();
        
        $this->user->assignRole($this->role);
    }
    /** @test */
    function it_update_a_specialty()
    {
        $this->handleValidationExceptions();

        $specialty = Specialty::factory()->create([
            'name' => 'Oftamologia'
        ]);

        $this->actingAs($this->user)
            ->putJson("/api/specialties/{$specialty->id}/update", $this->withData([
                'name' => 'Ginecología',
                'description' => 'Descripcion de la especialidad'
            ]))
            ->assertSuccessful()
            ->assertJson([
                'success' => true,
                'message' => 'Especialidad actualizada con éxito.'
            ]);
        $this->assertDatabaseHas('specialties', [
            'id' => $specialty->id,
            'name' => 'Ginecología'
        ]);
    }
    /** @test */
    function the_name_field_is_required()
    {
        $this->handleValidationExceptions();

        $specialty = Specialty::factory()->create([
            'name' => 'Oftamologia'
        ]);

        $this->actingAs($this->user)
            ->putJson("/api/specialties/{$specialty->id}/update", $this->withData([
                'name' => '',
                'description' => 'Descripcion de la especialidad'
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
        $this->assertDatabaseMissing('specialties', [
            'id' => $specialty->id,
            'name' => 'Ginecología'
        ]);
    }
    /** @test */
    function the_name_field_contain_min_three_characters()
    {
        $this->handleValidationExceptions();

        $specialty = Specialty::factory()->create([
            'name' => 'Oftamologia'
        ]);

        $this->actingAs($this->user)
            ->putJson("/api/specialties/{$specialty->id}/update", $this->withData([
                'name' => 'Of',
                'description' => 'Descripcion de la especialidad'
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
        $this->assertDatabaseMissing('specialties', [
            'id' => $specialty->id,
            'name' => 'Of'
        ]);
    }
    /** @test */
    function the_name_field_contain_max_characters()
    {
        $this->handleValidationExceptions();

        $specialty = Specialty::factory()->create([
            'name' => 'Oftamologia'
        ]);

        $this->actingAs($this->user)
            ->putJson("/api/specialties/{$specialty->id}/update", $this->withData([
                'name' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,',
                'description' => 'Descripcion de la especialidad'
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
        $this->assertDatabaseMissing('specialties', [
            'id' => $specialty->id,
            'name' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,',
        ]);
    }
    /** @test */
    function the_description_field_contain_min_three_characters()
    {
        $this->handleValidationExceptions();

        $specialty = Specialty::factory()->create([
            'name' => 'Oftamologia'
        ]);

        $this->actingAs($this->user)
            ->putJson("/api/specialties/{$specialty->id}/update", $this->withData([
                'description' => 'of'
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['description']);

        $this->assertDatabaseMissing('specialties', [
            'description' => 'of'
        ]);

    }
    /** @test */
    function the_description_field_contain_max_characters()
    {
        $this->handleValidationExceptions();

        $specialty = Specialty::factory()->create([
            'name' => 'Oftamologia'
        ]);

        $this->actingAs($this->user)
            ->putJson("/api/specialties/{$specialty->id}/update", $this->withData([
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['description']);
        
            $this->assertDatabaseMissing('specialties', [
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,'
            ]);

    }

}
