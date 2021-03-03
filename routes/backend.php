<?php

use App\Http\Controllers\Backend\BackupController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\MenuBuilderController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SettingController;
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

// Menu Builder
Route::resource('menus', MenuController::class)->except(['show']);
// Route::post('menus/{menu}/order', [MenuController::class, 'orderItem'])->name('menus.order');
Route::group(['as' => 'menus.', 'prefix' => 'menus/{id}/'], function () {
    Route::post('order', [MenuBuilderController::class, 'order'])->name('order');
    Route::get('builder', [MenuBuilderController::class, 'index'])->name('builder');

    Route::get('item/create', [MenuBuilderController::class, 'itemCreate'])->name('item.create');
    Route::post('item/store', [MenuBuilderController::class, 'itemStore'])->name('item.store');
    Route::get('item/{itemId}/edit', [MenuBuilderController::class, 'itemEdit'])->name('item.edit');
    Route::put('item/{itemId}/update', [MenuBuilderController::class, 'itemUpdate'])->name('item.update');
    Route::delete('/{itemId}/destroy', [MenuBuilderController::class, 'itemDestroy'])->name('item.destroy');

});

// Settings
Route::group(['as' => 'settings.', 'prefix' => 'settings'], function () {
    Route::get('general', [SettingController::class, 'general'])->name('general');
    Route::patch('general', [SettingController::class, 'generalUpdate'])->name('general.update');

    Route::get('appearance', [SettingController::class, 'appearance'])->name('appearance');
    Route::put('appearance', [SettingController::class, 'appearanceUpdate'])->name('appearance.update');

    Route::get('mail', [SettingController::class, 'mail'])->name('mail');
    Route::put('mail', [SettingController::class, 'mailUpdate'])->name('mail.update');

    Route::get('socialite', [SettingController::class, 'socialite'])->name('socialite');
    Route::put('socialite', [SettingController::class, 'socialiteUpdate'])->name('socialite.update');

});
















// Route::get('/clear', function() {

//     Artisan::call('cache:clear');
//     Artisan::call('config:clear');
//     Artisan::call('config:cache');
//     Artisan::call('view:clear');
 
//     return "Cleared!";
 
//  });

//  