<?php

namespace Tests\Feature\Admin\Specialties;

use App\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateSpecialtiesTest extends TestCase
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
        $this->role = factory(Role::class)->create(['name' => 'Super Admin', 'guard_name' => 'api']);
        $this->user = factory(User::class)->create();
        
        $this->user->assignRole($this->role);
    }
    /** @test */
    function a_user_can_create_a_new_specialty()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/specialties/store', $this->withData([
                'description' => 'Description'
            ]))
            ->assertSuccessful()
            ->assertJson([
                'success' => true,
                'message' => 'Especialidad creada con éxito.'
            ]);
        $this->assertDatabaseHas('specialties', [
            'name' => 'Oftamología'
        ]);
    }
    /** @test */
    function the_name_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/specialties/store', $this->withData([
                'name' => ''
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
        
        $this->assertDatabaseMissing('specialties', [
            'name' => 'Oftamología'
        ]);
    }
    /** @test */
    function the_name_field_contain_min_three_characters()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/specialties/store', $this->withData([
                'name' => 'of'
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

        $this->assertDatabaseMissing('specialties', [
            'name' => 'Oftamología'
        ]);

    }
    /** @test */
    function the_name_field_contain_max_characters()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/specialties/store', $this->withData([
                'name' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
        
            $this->assertDatabaseMissing('specialties', [
                'name' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,'
            ]);

    }
    /** @test */
    function the_description_field_contain_min_three_characters()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
            ->postJson('/api/specialties/store', $this->withData([
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

        $this->actingAs($this->user)
            ->postJson('/api/specialties/store', $this->withData([
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['description']);
        
            $this->assertDatabaseMissing('specialties', [
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,'
            ]);

    }
    
}
