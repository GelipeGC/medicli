<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class Login extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/login';
    }

    

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }

    /**
     * Submit the form with the given credentials.
     *
     * @param  \Laravel\Dusk\Browser $browser
     * @param  string $email
     * @param  string $password
     * @return void
     */
    public function submit($browser, $email, $password)
    {
        $browser->type('email', $email)
                ->type('password', $password)
                ->press('Log In')
                ->pause(350);
    }
}
