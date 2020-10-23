<?php

namespace Tests\Feature\Admin\Doctors;

use App\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListDoctorsTest extends TestCase
{
    /** @var \App\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->role = factory(Role::class)->create(['name' => 'Doctor', 'guard_name' => 'api']);
        $this->user = factory(User::class)->create();
        
        $this->user->assignRole($this->role);
    }
    /** @test */
    function it_shows_the_doctors_lists()
    {
        $this->handleValidationExceptions();
        $this->markAsRisky();

        /* $doctorOne = factory(User::class)->create([
            'name' => 'Dr. Felipe',
            'created_at' => now()->subDays(2),
        ]);

        $doctorTwo = factory(User::class)->create([
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
