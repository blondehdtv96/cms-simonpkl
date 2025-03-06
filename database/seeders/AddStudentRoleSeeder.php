<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class AddStudentRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create student role if it doesn't exist
        $student = Role::firstOrCreate(['name' => 'student']);
        
        // Give permissions to student role
        $student->givePermissionTo([
            'create pkl',
            'read pkl',
            'update pkl'
        ]);
    }
} 