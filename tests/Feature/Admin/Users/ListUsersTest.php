<?php

namespace Tests\Feature\Admin\Users;

use App\User;
use Tests\TestCase;
use App\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;

class ListUsersTest extends TestCase
{
     /** @var \App\User */
     protected $user;

     public function setUp(): void
     {
         parent::setUp();
         
         $this->user = User::factory()->create([
            'name' => 'Felipe',
            'email' => 'felipe-guzman.c@hotmail.com',
            'created_at' => now()->subWeek(2),
         ]);
 
     }
    /** @test */
    function it_shows_the_users_list()
    {
        $this->handleValidationExceptions();

        User::factory()->create([
            'name' => 'Felipe',
            'created_at' => now()->subDays(2),
        ]);

        User::factory()->create([
            'name' => 'Deli',
            'created_at' => now()->subDays(1),
        ]);
        $this->actingAs($this->user)
            ->get('/api/users')
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    [ 'name' => 'Deli'],
                    [ 'name' => 'Felipe'],
                ]
           ]);
    }
    /** @test */
    function it_paginates_the_users()
    {
         User::factory()->create([
             'name' => 'Tercer Usuario',
             'created_at' => now()->subDays(4)
         ]);
 
         User::factory()->times(7)->create([
             'created_at' => now()->subDays(5),
         ]);
 
         User::factory()->create([
             'name' => 'Decimoséptimo Usuario',
             'created_at' => now()->subDays(2)

         ]);
 
         User::factory()->create([
             'name' => 'Segundo Usuario',
             'created_at' => now()->subDays(6)

         ]);
 
         User::factory()->create([
             'name' => 'Primer Usuario',
             'created_at' => now()->subWeek()
         ]);
 
         User::factory()->create([
             'name' => 'Decimosexto Usuario',
             'created_at' => now()->subDays(3),
         ]);
         

        $this->actingAs($this->user)
            ->get('/api/users')
            ->assertJson([
                 'data' => [
                     [ 'name' => 'Decimoséptimo Usuario'],
                     [ 'name' => 'Decimosexto Usuario'],
                     [ 'name' => 'Tercer Usuario']

                 ]
            ]) 
             ->assertJsonMissing([
                 'data' => [
                     ['name' => 'Segundo Usuario'],
                     ['name' => 'Primer Usuario']
                 ]
             ]);
         $this->get('/api/users?page=2')
                ->assertJson([
                    'data' => [
                        ['name' => 'Segundo Usuario'],
                        [ 'name' => 'Primer Usuario'],
                    ]
                ])
             ->assertJsonMissing([
                 'data' => [
                        ['Tercer Usuario']
                    ]
                ]);
    }

    /** @test */
    function users_are_ordered_by_name()
    {
         User::factory()->create(['name' => 'John Doe']);
         User::factory()->create(['name' => 'Richard Roe']);
         User::factory()->create(['name' => 'Jane Doe']);
        $this->actingAs($this->user)
            ->get('/api/users?sort=name|asc')
            ->assertJson([
                'data' => [
                    ['name' => 'Felipe'],
                    ['name' => 'Jane Doe'],
                    ['name' => 'John Doe'],
                    ['name' => 'Richard Roe']
                ]
            ]);

        $this->actingAs($this->user)
            ->get('/api/users?sort=name|desc')
            ->assertJson([
                'data' => [
                    ['name' => 'Richard Roe'],
                    ['name' => 'John Doe'],
                    ['name' => 'Jane Doe'],
                    ['name' => 'Felipe']
                ]
            ]);
            
    }
    /** @test */
    function users_are_ordered_by_email()
    {
        User::factory()->create(['email' => 'john.doe@example.com']);
        User::factory()->create(['email' => 'richard.roe@example.com']);
        User::factory()->create(['email' => 'jane.doe@example.com']);

        $this->actingAs($this->user)
         ->get('/api/users?sort=email|asc')
            ->assertJson([
                'data' => [
                    ['email' => 'felipe-guzman.c@hotmail.com'],
                    ['email' => 'jane.doe@example.com'],
                    ['email' => 'john.doe@example.com'],
                    ['email' => 'richard.roe@example.com']
                ]
            ]);

        $this->actingAs($this->user)
            ->get('/api/users?sort=email|desc')
            ->assertJson([
                'data' => [
                    ['email' => 'richard.roe@example.com'],    
                    ['email' => 'john.doe@example.com'],
                    ['email' => 'jane.doe@example.com'],
                    ['email' => 'felipe-guzman.c@hotmail.com'],
                ]
            ]);
            
    }
    
    /** @test */
    function invalid_order_query_date_is_ignorad_and_default_order_is_used_instead()
    {
        User::factory()->create(['name' => 'John Doe', 'created_at' => now()->subDays(1)]);
        User::factory()->create(['name' => 'Richard Roe', 'created_at' => now()->subDays(2)]);
        User::factory()->create(['name' => 'Jane Doe', 'created_at' => now()->subDays(3)]);


        $this->actingAs($this->user)
            ->get('/api/users?sort=id')
            ->assertJson([
                'data' => [
                    ['name' => 'John Doe'],
                    ['name' => 'Richard Roe'],
                    ['name' => 'Jane Doe'],
                ]
            ]);
        $this->actingAs($this->user)
            ->get('/api/users?sort=invalid|desc')
            ->assertJson([
                'data' => [
                    ['name' => 'John Doe'],
                    ['name' => 'Richard Roe'],
                    ['name' => 'Jane Doe'],
                ]
            ]);
        
    }

}
