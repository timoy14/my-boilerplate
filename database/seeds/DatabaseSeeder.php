<?php

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
        $this->call(AreaSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(SettingSeeder::class);

        $this->call(UserSeeder::class);

    }
}