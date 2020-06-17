<?php

namespace Tests;

use Tests\TestHelpers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase, TestHelpers, CreatesApplication;
    protected function setUp(): void
    {
        parent::setUp();
    }
    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
