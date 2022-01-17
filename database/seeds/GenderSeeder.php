<?php

use App\Model\Gender;

use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gender = new Gender();
        $gender->en = 'Male';
        $gender->ar = 'ذكر';
        $gender->save();

        $gender = new Gender();
        $gender->en = 'Female';
        $gender->ar = 'انثى';
        $gender->save();

    }
}
