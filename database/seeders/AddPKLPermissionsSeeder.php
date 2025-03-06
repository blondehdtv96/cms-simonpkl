<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class AddPKLPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add PKL permissions to superadmin
        $superadmin = Role::where('name', 'superadmin')->first();
        if ($superadmin) {
            $superadmin->givePermissionTo([
                'create pkl',
                'read pkl',
                'update pkl',
                'delete pkl',
                'approve pkl',
                'reject pkl'
            ]);
        }

        // Add PKL permissions to admin
        $admin = Role::where('name', 'admin')->first();
        if ($admin) {
            $admin->givePermissionTo([
                'read pkl',
                'approve pkl',
                'reject pkl'
            ]);
        }

        // Add PKL permissions to operator
        $operator = Role::where('name', 'operator')->first();
        if ($operator) {
            $operator->givePermissionTo([
                'create pkl',
                'read pkl',
                'update pkl'
            ]);
        }
    }
} 