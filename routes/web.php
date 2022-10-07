<?php

use App\Http\Controllers\TaskController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('projects', \App\Http\Controllers\ProjectController::class)->middleware('auth');
    Route::resource('projects.tasks', TaskController::class)->shallow();
    Route::post('projects/{project}/invite', [\App\Http\Controllers\ProjectInvitationController::class, 'invite'])->name('projects.invite');
});

require __DIR__.'/auth.php';
