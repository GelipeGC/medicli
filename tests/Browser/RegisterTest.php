<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\Register;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;


    /** @test */
    public function register_with_valid_data()
    {
        // $this->browse(function ($browser) {
        //     $browser->visitRoute('register')
        //             ->type('name', 'Test user')
        //             ->type('email', 'test@test.com')
        //             ->type('password', '12345678')
        //             ->type('password_confirmation', '12345678')
        //             ->press('register')
        //             ->assertPathIs('/home');
        // });
        $this->browse(function ($browser) {
            $browser->visit(new Register)
                ->submit([
                    'name' => 'Test User',
                    'email' => 'test@test.app',
                    'password' => 'secret',
                    'password_confirmation' => 'secret',
                ])
                ->assertPathIs('/home');;
        });
    }


    /** @test */
    function the_name_is_required()
    {
        $this->browse(function ($browser) {
            $browser->visit(new Register)
                ->submit([
                    'name' => '',
                    'email' => 'test@test.app',
                    'password' => 'secret',
                    'password_confirmation' => 'secret',
                ])
                ->assertSee('The name field is required.');
        });

    }
    /** @test */
    function the_email_is_required()
    {
        $this->browse(function ($browser) {
            $browser->visit(new Register)
                ->submit([
                    'name' => 'Test User',
                    'email' => '',
                    'password' => 'secret',
                    'password_confirmation' => 'secret',
                ])
                ->assertSee('The email field is required.');
        });

    }
    /** @test */
    function the_email_must_be_valid()
    {
        $this->browse(function ($browser) {
            $browser->visit(new Register)
                ->submit([
                    'name' => 'Test User',
                    'email' => 'invalid-email@test',
                    'password' => 'secret',
                    'password_confirmation' => 'secret',
                ])
                ->assertSee('The email must be a valid email address.');
        });

    }
    /** @test */
    function the_password_is_required()
    {
        $this->browse(function ($browser) {
            $browser->visit(new Register)
                ->submit([
                    'name' => 'Test User',
                    'email' => 'test@test.app',
                    'password' => '',
                    'password_confirmation' => '',
                ])
                ->assertSee('The password field is required.');
        });

    }
    /** @test */
    function can_not_register_with_the_same_twice()
    {
        $user = User::factory()->create();

        $this->browse(function ($browser) use ($user){
            $browser->visit(new Register)
                    ->submit([
                        'name' => 'Test User',
                        'email' => $user->email,
                        'password' => 'secret',
                        'password_confirmation' => 'secret',
                    ])
                    ->assertSee('The email has already been taken.');
        });
    }
}
