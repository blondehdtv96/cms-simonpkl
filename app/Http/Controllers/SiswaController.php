<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create user', ['only' => ['create', 'store', 'import']]);
        $this->middleware('permission:read user', ['only' => ['index', 'show', 'export']]);
        $this->middleware('permission:update user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete user', ['only' => ['destroy', 'destroyBulk']]);
    }

    public function index(Request $request)
    {
        $siswa = User::role('siswa');

        if ($request->has('search')) {
            $siswa->where('name', 'LIKE', "%" . $request->search . "%")
                    ->orWhere('email', 'LIKE', "%" . $request->search . "%");
        }

        if ($request->has(['field', 'order'])) {
            $siswa->orderBy($request->field, $request->order);
        }

        $perPage = $request->has('perPage') ? $request->perPage : 10;

        return Inertia::render('Siswa/Index', [
            'title' => 'Siswa',
            'filters' => $request->all(['search', 'field', 'order']),
            'perPage' => (int) $perPage,
            'siswa' => $siswa->paginate($perPage),
            'breadcrumbs' => [['label' => 'Siswa', 'href' => route('siswa.index')]],
        ]);
    }

    public function export()
    {
        return Excel::download(new SiswaExport, 'siswa.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        DB::beginTransaction();
        try {
            Excel::import(new SiswaImport, $request->file('file'));
            
            DB::commit();
            return back()->with('success', 'Data siswa berhasil diimport.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed'],
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $user->assignRole('siswa');
            DB::commit();
            return back()->with('success', 'Siswa berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function update(Request $request, User $siswa)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $siswa->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $siswa->id,
            'password' => ['nullable', 'confirmed'],
        ]);

        DB::beginTransaction();
        try {
            $siswa->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ]);

            if ($request->password) {
                $siswa->update(['password' => bcrypt($request->password)]);
            }

            DB::commit();
            return back()->with('success', 'Siswa berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function destroy(User $siswa)
    {
        DB::beginTransaction();
        try {
            $siswa->delete();
            DB::commit();
            return back()->with('success', 'Siswa berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function destroyBulk(Request $request)
    {
        DB::beginTransaction();
        try {
            User::whereIn('id', $request->ids)->delete();
            DB::commit();
            return back()->with('success', 'Siswa berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }
} 