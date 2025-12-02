<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Model3DController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use App\Http\Middleware\AdminRedirect;

Route::get('/', function () {
    return view('models.about');
});

Route::get('/create3d', [Model3DController::class, 'create3d'])->name('create3d');

Route::get('/info', function () {
    return view('models.info');
});

Route::get('/proba', function () {
    return view('models.proba');
});

Route::get('/about', function () {
    return view('models.about');
})->name('about');

// ПУБЛИЧНЫЕ МАРШРУТЫ (доступны всем)
Route::get('/allmodels', [Model3DController::class, 'allModels'])->name('models.all');
Route::get('/allmodels/{model:slug}', [Model3DController::class, 'allShow'])->name('models.all.show');

// МАРШРУТЫ ДЛЯ ВСЕХ АВТОРИЗОВАННЫХ ПОЛЬЗОВАТЕЛЕЙ
Route::middleware(['auth'])->group(function () {
    Route::get('/models', [Model3DController::class, 'index'])->name('models.index');
    Route::get('/models/create', [Model3DController::class, 'create'])->name('models.create');
    Route::post('/models', [Model3DController::class, 'store'])->name('models.store');
    Route::get('/models/create3d', [Model3DController::class, 'create3d'])->name('models.create3d');
    
    // Просмотр моделей (все авторизованные)
    Route::get('/models/{model:slug}', [Model3DController::class, 'show'])->name('models.show');
});

// МАРШРУТЫ ДЛЯ РЕДАКТИРОВАНИЯ - только владелец
Route::middleware(['auth'])->group(function () {
    Route::get('/models/{model:slug}/edit', [Model3DController::class, 'edit'])
        ->name('models.edit');
    
    Route::put('/models/{model:slug}', [Model3DController::class, 'update'])
        ->name('models.update');
    
    Route::delete('/models/{model:slug}', [Model3DController::class, 'destroy'])
        ->name('models.destroy');
});

// МАРШРУТЫ АДМИНА (с правами на редактирование любых моделей)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Дашборд
    Route::get('/', [Model3DController::class, 'admin'])->name('dashboard');
    Route::get('/dashboard', [Model3DController::class, 'admin'])->name('dashboard');
    
    // Управление админами
    Route::get('/add-admin', [Model3DController::class, 'addAdmin'])->name('addadmin');
    Route::post('/make-admin', [Model3DController::class, 'makeAdmin'])->name('make');
    Route::delete('/remove-admin/{id}', [Model3DController::class, 'removeAdmin'])->name('remove');
    
    // Управление пользователями
    Route::get('/users', [Model3DController::class, 'userManagement'])->name('users');
    Route::get('/users/{userId}', [Model3DController::class, 'userDetail'])->name('user.detail');
    
    // АДМИНСКИЕ МАРШРУТЫ ДЛЯ УПРАВЛЕНИЯ МОДЕЛЯМИ
    Route::get('/models', [Model3DController::class, 'adminModels'])->name('models.index');
    Route::get('/models/{model:slug}/edit', [Model3DController::class, 'adminEdit'])->name('models.edit');
    Route::put('/models/{model:slug}', [Model3DController::class, 'adminUpdate'])->name('models.update');
    Route::delete('/models/{model:slug}', [Model3DController::class, 'adminDestroy'])->name('models.destroy');
    Route::get('/models/{model:slug}', [Model3DController::class, 'adminShow'])->name('models.show');
});

// ПРОФИЛЬ
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';