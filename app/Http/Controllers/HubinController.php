<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HubinController extends Controller
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
        $hubin = User::role('hubin');

        if ($request->has('search')) {
            $hubin->where('name', 'LIKE', "%" . $request->search . "%")
                    ->orWhere('email', 'LIKE', "%" . $request->search . "%");
        }

        if ($request->has(['field', 'order'])) {
            $hubin->orderBy($request->field, $request->order);
        }

        $perPage = $request->has('perPage') ? $request->perPage : 10;

        return Inertia::render('Hubin/Index', [
            'title' => 'Hubin',
            'filters' => $request->all(['search', 'field', 'order']),
            'perPage' => (int) $perPage,
            'hubin' => $hubin->paginate($perPage),
            'breadcrumbs' => [['label' => 'Hubin', 'href' => route('hubin.index')]],
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
            $user->assignRole('hubin');
            DB::commit();
            return back()->with('success', 'Hubin berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function update(Request $request, User $hubin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $hubin->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $hubin->id,
            'password' => ['nullable', 'confirmed'],
        ]);

        DB::beginTransaction();
        try {
            $hubin->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ]);

            if ($request->password) {
                $hubin->update(['password' => bcrypt($request->password)]);
            }

            DB::commit();
            return back()->with('success', 'Hubin berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function destroy(User $hubin)
    {
        DB::beginTransaction();
        try {
            $hubin->delete();
            DB::commit();
            return back()->with('success', 'Hubin berhasil dihapus.');
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
            return back()->with('success', 'Hubin berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }
} 