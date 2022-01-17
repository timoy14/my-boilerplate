<?php

use App\Model\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->en = 'Admin';
        $role->ar = 'مدير النطام';
        $role->save();

        $role = new Role();
        $role->en = 'Admin Staff ';
        $role->ar = ' Admin Staff';
        $role->save();

        $role = new Role();
        $role->en = 'Customer';
        $role->ar = 'Customer';
        $role->save();
    }
}