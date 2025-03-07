<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $user = User::create([
            'name' => $row['nama'],
            'username' => $row['username'] ?? Str::slug($row['nama']),
            'email' => $row['email'],
            'password' => Hash::make($row['password'] ?? 'password123'),
        ]);

        $user->assignRole('siswa');

        return $user;
    }
} 