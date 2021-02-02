<?php

namespace Tests\Feature\Admin\Patients;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletePatientTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->role = Role::factory()->create(['name' => 'Super Admin', 'guard_name' => 'api']);
        $this->user = User::factory()->create();
        $this->user->assignRole($this->role);

        $this->patient = User::factory(['status' => 0])->create();
        $this->rolePatient = Role::factory()->create(['name' => 'Patient', 'guard_name' => 'api']);
        $this->patient->assignRole($this->rolePatient);
    }
    /** @test */
    function it_sends_a_patient_to_the_trash()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
                ->deleteJson("/api/patients/{$this->patient->id}/delete")
                ->assertSuccessful()
                ->assertJson([
                    'success' => true,
                    'message' => "Paciente eliminado con éxito."
                ]);
        $this->assertSoftDeleted('users', [
            'id' => $this->patient->id
        ]);

    }
    /** @test */
    function it_cannot_delete_a_patient_user_that_is_not_inactive_status()
    {
        $this->handleValidationExceptions();

        $patient = User::factory()->create();

        $this->actingAs($this->user)
                ->deleteJson("/api/patients/{$patient->id}/delete")
                ->assertStatus(403);

        $this->assertDatabaseHas('users', [
            'id' => $this->patient->id,
            'deleted_at' => null
        ]);
    }
}
