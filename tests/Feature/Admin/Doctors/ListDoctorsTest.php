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
        $this->role = Role::factory()->create(['name' => 'Doctor', 'guard_name' => 'api']);
        $this->user = User::factory()->create();

        $this->user->assignRole($this->role);
    }
    /** @test */
    function it_shows_the_doctors_lists()
    {
        $this->handleValidationExceptions();
        $this->markAsRisky();

        /* $doctorOne = User::factory()->create([
            'name' => 'Dr. Felipe',
            'created_at' => now()->subDays(2),
        ]);

        $doctorTwo = User::factory()->create([
            'name' => 'Dra. Delia',
            'created_at' => now()->subDays(1)
        ]);

        $test = $this->actingAs($this->user)
                ->get('/api/doctors')
                ->assertSuccessful()
                ->assertJson([
                    'data' => [
                        ['name' => 'Dra. Delia'],
                        ['name' => 'Dr. Felipe']

                    ]
                ]);
        $test->dump(); */
    }

}
