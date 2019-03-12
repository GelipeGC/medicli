<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Login;
use Tests\Browser\Pages\HomePage;

class LoginTest extends DuskTestCase
{
    
    /** @test */
    function login_with_valid_credentials()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use($user) {
            $browser->visit(new Login)
                    ->type('email', $user->email)
                    ->type('password', 'secret')
                    ->press('Log In')
                    ->pause(350)
                    ->assertPathIs('/home');
        });
    }
    /** @test */
    function login_with_invalid_credentials()
    {
        $this->browse(function (Browser $browser)  {
            $browser->visit('/login')
                    ->type('email', 'test@test.com')
                    ->type('password', 'secret')
                    ->press('Log In')
                    ->assertSee('These credentials do not match our records.');
                });
    }
    
    function logout_the_user()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use($user) {
            $browser->visit(new Login)
                    ->submit($user->email, 'secret')
                    ->on(new HomePage)
                    ->clickLogout()
                    ->assertPageIs(Login::class);
                });
    }
    
}
