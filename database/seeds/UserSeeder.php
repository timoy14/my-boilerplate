<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = new User();
        $user->name = 'Admin Admin';
        $user->email = 'admin@admin.com';
        $user->phone = 9999999999;
        $user->password = bcrypt('adminadmin');
        $user->role_id = 1;
        $user->city_id = 1;
        $user->gender_id = 1;
        $user->activation_code = md5(12345);
        $user->is_verified = true;

        $user->save();

        $user = new User();
        $user->name = 'Owner   first';
        $user->email = 'owner@first.com';
        $user->phone = 33333333331;
        $user->password = bcrypt('adminadmin');
        $user->role_id = 3;

        $user->activation_code = md5(12345);
        $user->is_verified = true;

        $user->save();

        $user = new User();
        $user->name = 'Owner second';
        $user->email = 'owner@second.com';
        $user->phone = 33333333332;
        $user->password = bcrypt('adminadmin');
        $user->role_id = 3;

        $user->activation_code = md5(12345);
        $user->is_verified = true;

        $user->save();

        $user = new User();
        $user->name = 'Owner third';
        $user->email = 'owner@third.com';
        $user->phone = 33333333333;
        $user->password = bcrypt('adminadmin');
        $user->role_id = 3;

        $user->activation_code = md5(12345);
        $user->is_verified = true;

        $user->save();

        $user = new User();
        $user->name = 'Owner forth';
        $user->email = 'owner@forth.com';
        $user->phone = 33333333334;
        $user->password = bcrypt('adminadmin');
        $user->role_id = 3;

        $user->activation_code = md5(12345);
        $user->is_verified = true;

        $user->save();

        $user = new User();
        $user->name = 'driver first';
        $user->email = 'driver@first.com';
        $user->phone = 4444444441;
        $user->password = bcrypt('adminadmin');
        $user->role_id = 4;
        $user->city_id = 1;
        $user->gender_id = 1;
        $user->activation_code = md5(12345);
        $user->is_verified = true;
        $user->save();

      

        $user = new User();
        $user->name = 'customer first';
        $user->email = 'customer@first.com';
        $user->phone = 5555555551;

        $user->role_id = 5;
        $user->city_id = 1;
        $user->gender_id = 1;
        $user->activation_code = md5(12345);
        $user->is_verified = true;
        $user->save();

        $user = new User();
        $user->name = 'customer second';
        $user->email = 'customer@second.com';
        $user->phone = 5555555552;

        $user->role_id = 5;
        $user->city_id = 1;
        $user->gender_id = 1;
        $user->activation_code = md5(12345);
        $user->is_verified = true;
        $user->save();

    }
}