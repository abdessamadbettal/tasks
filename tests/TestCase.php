<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication , DatabaseMigrations;

    // public function setUp(): void
    // {
    //     parent::setUp();
    //     Artisan::call('db:seed');
    // }
}
