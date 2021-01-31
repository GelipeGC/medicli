<?php

namespace Tests\Feature\Admin\Specialties;

use App\Models\User;
use Tests\TestCase;
use App\Models\Role;
use App\Models\Specialty;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteSpecialtiesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->role = Role::factory()->create(['name' => 'Super Admin', 'guard_name' => 'api']);
        $this->user = User::factory()->create();

        $this->user->assignRole($this->role);
    }
    /** @test */
    function it_sends_a_specialty_to_the_trash()
    {
        $this->handleValidationExceptions();

        $specialty = Specialty::factory()->create([
            'name' => 'Oftamologia'
        ]);

        $this->actingAs($this->user)
                ->deleteJson("/api/specialties/{$specialty->id}/delete")
                ->assertSuccessful()
                ->assertJson([
                    'success' => true,
                    'message' => "Especialidad eliminada con éxito."
                ]);
        $this->assertSoftDeleted('specialties', [
            'id' => $specialty->id
        ]);

    }
}
