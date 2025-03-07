<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $superadmin = User::create([
            'name'              => 'Superadmin',
            'username'          => 'superadmin',
            'email'             => 'superadmin@superadmin.com', 
            'password'          => bcrypt('superadmin'),
            'email_verified_at' => date('Y-m-d H:i')
        ]);
        $superadmin->assignRole('superadmin');

        $admin = User::create([
            'name'              => 'Admin',
            'username'          => 'admin',
            'email'             => 'admin@admin.com',
            'password'          => bcrypt('admin'),
            'email_verified_at' => date('Y-m-d H:i')
        ]);
        $admin->assignRole('admin');

        $operator = User::create([
            'name'              => 'Operator', 
            'username'          => 'operator',
            'email'             => 'operator@operator.com',
            'password'          => bcrypt('operator'),
            'email_verified_at' => date('Y-m-d H:i')
        ]);
        $operator->assignRole('operator');

        // Add sample siswa
        $student = User::create([
            'name'              => 'Student',
            'username'          => 'student',
            'email'             => 'student@student.com',
            'password'          => bcrypt('student'),
            'email_verified_at' => date('Y-m-d H:i')
        ]);
        $student->assignRole('student');
    }
}
