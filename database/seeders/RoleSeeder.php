<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $superadmin = Role::create([
            'name'          => 'superadmin'
        ]);
        $superadmin->givePermissionTo([
            'delete user',
            'update user',
            'read user',
            'create user',
            'delete role',
            'update role',
            'read role',
            'create role',
            'delete permission',
            'update permission',
            'read permission',
            'create permission',
            'create pkl',
            'read pkl',
            'update pkl',
            'delete pkl',
            'approve pkl',
            'reject pkl'
        ]);
        $admin = Role::create([
            'name'          => 'admin'
        ]);
        $admin->givePermissionTo([
            'delete user',
            'update user',
            'read user',
            'create user',
            'read role',
            'read permission',
            'read pkl',
            'approve pkl',
            'reject pkl'
        ]);
        $operator = Role::create([
            'name'          => 'operator'
        ]);
        
        $operator->givePermissionTo([
            'read user',
            'create user',
            'read role',
            'read permission',
            'create pkl',
            'read pkl',
            'update pkl'
        ]);

        // Add student role
        $student = Role::create([
            'name'          => 'student'
        ]);
        
        $student->givePermissionTo([
            'create pkl',
            'read pkl',
            'update pkl'
        ]);
    }
}
