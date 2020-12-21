<?php

use App\Http\Controllers\Backend\BackupController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
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

Route::get('/dashboard', DashboardController::class)->name('dashboard');

// Roles and Users
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);

//Profile
Route::get('profile', [ProfileController::class,'index'])->name('profile.index');
Route::post('profile', [ProfileController::class,'update'])->name('profile.update');

//Security
Route::get('profile/security', [ProfileController::class,'changePassword'])->name('profile.password.change');
Route::post('profile/security', [ProfileController::class,'updatePassword'])->name('profile.password.update');

//Backups
Route::resource('backups', BackupController::class)->only(['index','store','destroy']);
Route::get('backups/{file_name}', [BackupController::class,'download'])->name('backups.download');
Route::delete('backups', [BackupController::class,'clean'])->name('backups.clean');

// Pages
Route::resource('pages', PageController::class);

// Route::get('/clear', function() {

//     Artisan::call('cache:clear');
//     Artisan::call('config:clear');
//     Artisan::call('config:cache');
//     Artisan::call('view:clear');
 
//     return "Cleared!";
 
//  });

// php artisan optimize:clear