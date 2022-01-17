<?php

use App\Model\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $city = new Area();
        $city->en = 'Area 1';
        $city->ar = 'Area 1';
        $city->city_id = 1;
        $city->save();

        $city = new Area();
        $city->en = 'Area 2';
        $city->ar = 'Area 2';
        $city->city_id = 1;
        $city->save();
    }
}