<?php

use Illuminate\Database\Seeder;

class TracksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Track::class, 100)->create();
    }
}
