<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class CreatePKLPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create PKL Permissions
        $permissions = [
            'create pkl',
            'read pkl',
            'update pkl',
            'delete pkl',
            'approve pkl',
            'reject pkl'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
} 