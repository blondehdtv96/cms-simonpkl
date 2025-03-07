<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class JurusanController extends Controller
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
        $query = Jurusan::query();

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has(['field', 'order'])) {
            $query->orderBy($request->field, $request->order);
        } else {
            $query->latest();
        }

        $perPage = $request->has('perPage') ? $request->perPage : 10;

        return Inertia::render('Jurusan/Index', [
            'title' => 'Jurusan',
            'filters' => $request->all(['search', 'field', 'order']),
            'perPage' => (int) $perPage,
            'jurusan' => $query->paginate($perPage),
            'breadcrumbs' => [['label' => 'Jurusan', 'href' => route('jurusan.index')]],
        ]);
    }

    public function create()
    {
        return Inertia::render('Jurusan/Form', [
            'title' => 'Tambah Jurusan',
            'mode' => 'create',
            'breadcrumbs' => [
                ['label' => 'Jurusan', 'href' => route('jurusan.index')],
                ['label' => 'Tambah', 'href' => route('jurusan.create')],
            ],
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate(Jurusan::rules());

            DB::beginTransaction();
            
            Jurusan::create($validated);
            
            DB::commit();
            
            return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function edit(Jurusan $jurusan)
    {
        return Inertia::render('Jurusan/Form', [
            'title' => 'Edit Jurusan',
            'mode' => 'edit',
            'jurusan' => $jurusan,
            'breadcrumbs' => [
                ['label' => 'Jurusan', 'href' => route('jurusan.index')],
                ['label' => 'Edit', 'href' => route('jurusan.edit', $jurusan->id)],
            ],
        ]);
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        try {
            $validated = $request->validate(Jurusan::rules($jurusan->id));

            DB::beginTransaction();
            
            $jurusan->update($validated);
            
            DB::commit();
            
            return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function destroy(Jurusan $jurusan)
    {
        try {
            DB::beginTransaction();
            
            $jurusan->delete();
            
            DB::commit();
            
            return back()->with('success', 'Jurusan berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function destroyBulk(Request $request)
    {
        try {
            DB::beginTransaction();
            
            Jurusan::whereIn('id', $request->ids)->delete();
            
            DB::commit();
            
            return back()->with('success', 'Jurusan berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }
} 