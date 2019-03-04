<?php

namespace Tests\Feature;

use Exception;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TestDatabaseConnection extends TestCase
{
    use DatabaseMigrations;


    /* @test */
    public function test_DataBaseConnection() {

        $database_host = Config::get('config.database_host');
        $database_name = Config::get('config.database_name');
        $database_user = Config::get('config.database_user');
        $database_password = Config::get('config.database_password');

        $connection = mysqli_connect($database_host, $database_user, $database_password, $database_name);

        $this->assertTrue(mysqli_errno($connection) ? false : true);
    }

}
