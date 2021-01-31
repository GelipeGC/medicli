<?php

namespace Tests\Feature\Admin\Doctors;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteDoctorTest extends TestCase
{
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
    function it_sends_a_doctor_to_the_trash()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->user)
                ->deleteJson("/api/doctors/{$this->doctor->id}/delete")
                ->assertSuccessful()
                ->assertJson([
                    'success' => true,
                    'message' => "Médico eliminado con éxito."
                ]);
        $this->assertSoftDeleted('users', [
            'id' => $this->doctor->id
        ]);

    }
}
