<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocaleTest extends TestCase
{
   /** @test */
   public function set_locale_from_header()
   {
       $this->withHeaders(['Accept-Language' => 'es'])
           ->postJson('/api/login');

       $this->assertEquals('es', $this->app->getLocale());
   }

   public function set_locale_from_header_short()
   {
       $this->withHeaders(['Accept-Language' => 'en-US'])
           ->postJson('/api/login');

       $this->assertEquals('en', $this->app->getLocale());
   }
}
