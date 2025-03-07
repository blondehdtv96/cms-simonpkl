<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SiswaExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return User::role('siswa')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Username',
            'Email',
            'Status Email',
            'Tanggal Dibuat',
            'Tanggal Diperbarui'
        ];
    }

    public function map($siswa): array
    {
        return [
            $siswa->id,
            $siswa->name,
            $siswa->username,
            $siswa->email,
            $siswa->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi',
            $siswa->created_at->format('d/m/Y H:i:s'),
            $siswa->updated_at->format('d/m/Y H:i:s'),
        ];
    }
} 