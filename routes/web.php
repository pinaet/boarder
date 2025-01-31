<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\BoarderController;
use App\Http\Controllers\SettingController;

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
    return redirect('/login');
    // dd('test');
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/Error', function () {
    return Inertia::render('Login/Error', [
        'title' => 'Login Error',
        'message' => 'Login Failed..',
        'url' => url('/'),
        'type' => 'warning'
    ]);
});

Route::get(  '/dashboard'               , [ BoarderController::class , 'dashboard'        ] )->middleware(['auth', 'verified'])->name('dashboard');
Route::post( '/boarder/update/profile'  , [ BoarderController::class , 'update_profile'   ] )->middleware(['auth', 'verified']);
Route::post( '/boarder/change/building' , [ BoarderController::class , 'change_building'  ] )->middleware(['auth', 'verified']);
Route::post( '/boarder/change/week'     , [ BoarderController::class , 'change_week'      ] )->middleware(['auth', 'verified']);
Route::post( '/boarder/store/attendance', [ BoarderController::class , 'store_attendance' ] )->middleware(['auth', 'verified']);

Route::get(  '/setting'                 , [ SettingController::class , 'index'            ] )->middleware(['auth', 'verified'])->name('setting');
Route::post( '/setting/sync'            , [ SettingController::class , 'sync'             ] )->middleware(['auth', 'verified']);
Route::get(  '/setting/staff'           , [ SettingController::class , 'staff'            ] )->middleware(['auth', 'verified'])->name('setting.staff');
Route::post( '/setting/staff/save'      , [ SettingController::class , 'staff_save'       ] )->middleware(['auth', 'verified']);
Route::post( '/setting/staff/delete'    , [ SettingController::class , 'staff_delete'     ] )->middleware(['auth', 'verified']);
Route::get(  '/setting/role'            , [ SettingController::class , 'role'             ] )->middleware(['auth', 'verified'])->name('setting.role');
Route::post( '/setting/role/save'       , [ RoleController::class    , 'role_save'        ] )->middleware(['auth', 'verified']);
Route::post( '/setting/role/delete'     , [ RoleController::class    , 'role_delete'      ] )->middleware(['auth', 'verified']);

Route::get(  '/setting/login-as'        , [ SettingController::class , 'login_as'         ] )->middleware(['auth', 'verified'])->name('login.as');
Route::post( '/setting/login-as/change' , [ SettingController::class , 'login_as_change'  ] )->middleware(['auth', 'verified'])->name('login.as.change');


Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::inertia('/about', 'AboutComponent');

Route::get('/test', [TestsController::class, 'index'] );

require __DIR__.'/auth.php';
