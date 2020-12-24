<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Property;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(50)->has(Property::factory(1)->has(Image::factory(5)))->create();
    }
}
