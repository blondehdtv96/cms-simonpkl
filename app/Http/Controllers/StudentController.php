<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:siswa']);
    }

    public function dashboard()
    {
        return Inertia::render('Student/Dashboard', [
            'title' => 'Dashboard Siswa',
            'breadcrumbs' => [['label' => 'Dashboard', 'href' => route('student.dashboard')]],
        ]);
    }
} 