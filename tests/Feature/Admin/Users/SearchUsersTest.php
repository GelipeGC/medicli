<?php

namespace Tests\Feature\Admin\Users;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class SearchUsersTest extends TestCase
{
     /** @var \App\User */
     protected $user;

     public function setUp(): void
     {
         parent::setUp();
         $this->user = User::factory()->create([
            'created_at' => now()->subWeek(2)
         ]);
 
     }
   /** @test */
   function search_users_by_name()
   {
       User::factory()->create([
           'name' => 'Felipe',
       ]);

       User::factory()->create([
           'name' => 'Deli',
       ]);
       $this->actingAs($this->user)
           ->get('/api/users?search=Felipe')
           ->assertSuccessful()
           ->assertJson([
               'data' => [
                   [ 'name' => 'Felipe'],
               ]
            ]) 
            ->assertJsonMissing([
                'data' => [
                    ['name' => 'Deli']
                ]
            ]);
   }
   /** @test */
   function show_results_with_a_partial_search_by_name()
   {
       User::factory()->create([
           'name' => 'Felipe',
       ]);

       User::factory()->create([
           'name' => 'Deli',
       ]);
       $this->actingAs($this->user)
           ->get('/api/users?search=Fel')
           ->assertSuccessful()
           
           ->assertJson([
               'data' => [
                   [ 'name' => 'Felipe'],
               ]
            ]) 
            ->assertJsonMissing([
                'data' => [
                    ['name' => 'Deli']
                ]
            ]);
   }
    /** @test */
   function search_users_by_email()
   {
       User::factory()->create([
           'email' => 'felipe@example.com',
       ]);

       User::factory()->create([
           'email' => 'deli@example.mx',
       ]);
       $this->actingAs($this->user)
           ->get('/api/users?search=deli@example.mx')
           ->assertSuccessful()
           
           ->assertJson([
               'data' => [
                   [ 'email' => 'deli@example.mx'],
               ]
            ]) 
            ->assertJsonMissing([
                'data' => [
                    ['email' => 'felipe@example.com']
                ]
            ]);
   }
    /** @test */
    function show_results_with_a_partial_sear_by_email()
    {
        User::factory()->create([
            'email' => 'felipe@example.com',
        ]);
 
        User::factory()->create([
            'email' => 'deli@example.mx',
        ]);
        $this->actingAs($this->user)
            ->get('/api/users?search=deli@example')
            ->assertSuccessful()
            
            ->assertJson([
                'data' => [
                    [ 'email' => 'deli@example.mx'],
                ]
             ]) 
             ->assertJsonMissing([
                 'data' => [
                     ['email' => 'felipe@example.com']
                 ]
             ]);
    }
}
