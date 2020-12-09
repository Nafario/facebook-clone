<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    // public function setup(): void
    // {
    //     $this->withHeaders([
    //         'Accept' => 'application/json',
    //         'X-Requested-With' => 'XMLHttpRequest',
    //     ]);
    // }
}
