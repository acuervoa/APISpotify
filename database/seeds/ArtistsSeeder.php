<?php

use Illuminate\Database\Seeder;

class ArtistsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Artist::class, 50)->create();
    }
}
