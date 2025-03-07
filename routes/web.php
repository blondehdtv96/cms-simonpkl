<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\KaprogController;
use App\Http\Controllers\HubinController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JurusanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->user()->roles->first()->name === 'siswa') {
        return redirect()->route('student.dashboard');
    }
    return Inertia::render('Dashboard', [
        'users'         => (int) User::count(),
        'roles'         => (int) Role::count(),
        'permissions'   => (int) Permission::count(),
        'jurusan'       => (int) \App\Models\Jurusan::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/setLang/{locale}', function ($locale) {
    Session::put('locale', $locale); 
    return back();
})->name('setlang');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Student Routes
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])
        ->middleware(['auth', 'role:siswa'])
        ->name('student.dashboard');

    // Admin Routes
    Route::middleware(['auth', 'role:superadmin|admin'])->group(function () {
        // Data Management Routes
        Route::resource('/walikelas', WaliKelasController::class)->except('create', 'show', 'edit');
        Route::post('/walikelas/destroy-bulk', [WaliKelasController::class, 'destroyBulk'])->name('walikelas.destroy-bulk');

        Route::resource('/kaprog', KaprogController::class)->except('create', 'show', 'edit');
        Route::post('/kaprog/destroy-bulk', [KaprogController::class, 'destroyBulk'])->name('kaprog.destroy-bulk');

        Route::resource('/hubin', HubinController::class)->except('create', 'show', 'edit');
        Route::post('/hubin/destroy-bulk', [HubinController::class, 'destroyBulk'])->name('hubin.destroy-bulk');

        Route::resource('/siswa', SiswaController::class)->except('create', 'show', 'edit');
        Route::post('/siswa/destroy-bulk', [SiswaController::class, 'destroyBulk'])->name('siswa.destroy-bulk');
        Route::get('/siswa/export', [SiswaController::class, 'export'])->name('siswa.export');
        Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');

        // Jurusan Routes
        Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
        Route::get('/jurusan/create', [JurusanController::class, 'create'])->name('jurusan.create');
        Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
        Route::get('/jurusan/{jurusan}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
        Route::put('/jurusan/{jurusan}', [JurusanController::class, 'update'])->name('jurusan.update');
        Route::delete('/jurusan/{jurusan}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');
        Route::post('/jurusan/destroy-bulk', [JurusanController::class, 'destroyBulk'])->name('jurusan.destroy-bulk');

        // Original Routes
        Route::resource('/user', UserController::class)->except('create', 'show', 'edit');
        Route::post('/user/destroy-bulk', [UserController::class, 'destroyBulk'])->name('user.destroy-bulk');
        
        Route::resource('/role', RoleController::class)->except('create', 'show', 'edit');
        Route::post('/role/destroy-bulk', [RoleController::class, 'destroyBulk'])->name('role.destroy-bulk');

        Route::resource('/permission', PermissionController::class)->except('create', 'show', 'edit');
        Route::post('/permission/destroy-bulk', [PermissionController::class, 'destroyBulk'])->name('permission.destroy-bulk');
    });
});

require __DIR__.'/auth.php';
