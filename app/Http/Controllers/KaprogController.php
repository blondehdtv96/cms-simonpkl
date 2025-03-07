<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class KaprogController extends Controller
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
        $kaprog = User::role('kaprog');

        if ($request->has('search')) {
            $kaprog->where('name', 'LIKE', "%" . $request->search . "%")
                    ->orWhere('email', 'LIKE', "%" . $request->search . "%");
        }

        if ($request->has(['field', 'order'])) {
            $kaprog->orderBy($request->field, $request->order);
        }

        $perPage = $request->has('perPage') ? $request->perPage : 10;

        return Inertia::render('Kaprog/Index', [
            'title' => 'Kepala Program',
            'filters' => $request->all(['search', 'field', 'order']),
            'perPage' => (int) $perPage,
            'kaprog' => $kaprog->paginate($perPage),
            'breadcrumbs' => [['label' => 'Kepala Program', 'href' => route('kaprog.index')]],
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
            $user->assignRole('kaprog');
            DB::commit();
            return back()->with('success', 'Kepala Program berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function update(Request $request, User $kaprog)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $kaprog->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $kaprog->id,
            'password' => ['nullable', 'confirmed'],
        ]);

        DB::beginTransaction();
        try {
            $kaprog->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ]);

            if ($request->password) {
                $kaprog->update(['password' => bcrypt($request->password)]);
            }

            DB::commit();
            return back()->with('success', 'Kepala Program berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function destroy(User $kaprog)
    {
        DB::beginTransaction();
        try {
            $kaprog->delete();
            DB::commit();
            return back()->with('success', 'Kepala Program berhasil dihapus.');
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
            return back()->with('success', 'Kepala Program berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }
} 