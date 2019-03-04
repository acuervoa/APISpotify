<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    /* @test */
    public function test_BasicTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
