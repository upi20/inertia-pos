<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ([
            [
                'name'      => 'Administrator',
                'email'     => 'admin@gmail.com',
            ],
            [
                'name'      => 'Isep Lutpi Nur',
                'email'     => 'iseplutpinur7@gmail.com',
            ],
        ] as $v) {
            //create user
            $user = User::create([
                'name'      => $v['name'],
                'email'      => $v['email'],
                'password'  => bcrypt('password'),
            ]);

            //get all permissions
            $permissions = Permission::all();

            //get role admin
            $role = Role::find(1);

            //assign permission to role
            $role->syncPermissions($permissions);

            //assign role to user
            $user->assignRole($role);
        }
    }
}
