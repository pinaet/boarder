<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\BoarderController;

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

Route::get( '/dashboard', [BoarderController::class, 'dashboard'] )->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::inertia('/about', 'AboutComponent');

Route::get('/test', [TestsController::class, 'index'] );

require __DIR__.'/auth.php';
