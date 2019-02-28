<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestDatabaseConnection extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }


    public function TestDataBaseConnection() {
        try{
            $database_host = Config::get('config.database_host');
            $database_name = Config::get('config.database_name');
            $database_user = Config::get('config.database_user');
            $database_password = Config::get('config.database_password');

            $connection = mysqli_connect($database_host, $database_user, $database_password, $database_name);

            if(mysqli_connect_errorno()) {
                return false;
            }else{
                return true;
            }
        } catch(Exception $e) {
            return false;
        }
    }

}
