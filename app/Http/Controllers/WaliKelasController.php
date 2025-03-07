<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WaliKelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create user', ['only' => ['create', 'store']]);
        $this->middleware('permission:read user', ['only' => ['index', 'show']]);
        $this->middleware('permission:update user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete user', ['only' => ['destroy', 'destroyBulk']]);
    }

    public function index(Request $request)
    {
        $waliKelas = User::role('wali_kelas');

        if ($request->has('search')) {
            $waliKelas->where('name', 'LIKE', "%" . $request->search . "%")
                    ->orWhere('email', 'LIKE', "%" . $request->search . "%");
        }

        if ($request->has(['field', 'order'])) {
            $waliKelas->orderBy($request->field, $request->order);
        }

        $perPage = $request->has('perPage') ? $request->perPage : 10;

        return Inertia::render('WaliKelas/Index', [
            'title' => 'Wali Kelas',
            'filters' => $request->all(['search', 'field', 'order']),
            'perPage' => (int) $perPage,
            'waliKelas' => $waliKelas->paginate($perPage),
            'breadcrumbs' => [['label' => 'Wali Kelas', 'href' => route('walikelas.index')]],
        ]);
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
            $user->assignRole('wali_kelas');
            DB::commit();
            return back()->with('success', 'Wali Kelas berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function update(Request $request, User $waliKelas)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $waliKelas->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $waliKelas->id,
            'password' => ['nullable', 'confirmed'],
        ]);

        DB::beginTransaction();
        try {
            $waliKelas->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ]);

            if ($request->password) {
                $waliKelas->update(['password' => bcrypt($request->password)]);
            }

            DB::commit();
            return back()->with('success', 'Wali Kelas berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function destroy(User $waliKelas)
    {
        DB::beginTransaction();
        try {
            $waliKelas->delete();
            DB::commit();
            return back()->with('success', 'Wali Kelas berhasil dihapus.');
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
            return back()->with('success', 'Wali Kelas berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }
} 