<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaceController;

// La ventana principal de la aplicación será la vista welcome.blade.php
Route::get('/', function () {
    return view('welcome');
});

// Rutas que requieren autenticación pero no verificación
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard')->with('status', '¡Email verificado correctamente!');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::delete('/profile/photo', [App\Http\Controllers\ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');

Route::get('/drivers', [App\Http\Controllers\DriverController::class, 'index'])->name('drivers.index')->middleware('auth');
Route::get('/drivers/show/{driver}', [App\Http\Controllers\DriverController::class, 'show'])->name('drivers.show')->middleware('auth');

Route::get('/teams', [App\Http\Controllers\TeamController::class, 'index'])->name('teams.index')->middleware('auth');
Route::get('/teams/show/{team}', [App\Http\Controllers\TeamController::class, 'show'])->name('teams.show')->middleware('auth');

// Si no la creamos antes que la ruta de show, Laravel la interpretará como un ID
Route::get('/races/create', [RaceController::class, 'create'])
    ->middleware(['auth', 'admin'])
    ->name('admin.races.create');

Route::get('/races', [App\Http\Controllers\RaceController::class, 'index'])->name('races.index')->middleware('auth');
Route::get('/races/{race}', [App\Http\Controllers\RaceController::class, 'show'])->name('races.show')->middleware('auth');

// Rutas para el administrador
Route::middleware(['admin', 'auth'])->name('admin.')->group(function () {

    // Pilotos

    Route::get('drivers/edit/{driver}', [App\Http\Controllers\DriverController::class, 'edit'])->name('drivers.edit');
    Route::put('drivers/update/{driver}', [App\Http\Controllers\DriverController::class, 'update'])->name('drivers.update');
    Route::get('drivers/create', [App\Http\Controllers\DriverController::class, 'create'])->name('drivers.create');
    Route::post('drivers/store', [App\Http\Controllers\DriverController::class, 'store'])->name('drivers.store');
    Route::delete('drivers/destroy/{driver}', [App\Http\Controllers\DriverController::class, 'destroy'])->name('drivers.destroy');

    // Equipos

    Route::get('teams/edit/{team}', [App\Http\Controllers\TeamController::class, 'edit'])->name('teams.edit');
    Route::put('teams/update/{team}', [App\Http\Controllers\TeamController::class, 'update'])->name('teams.update');
    Route::get('teams/create', [App\Http\Controllers\TeamController::class, 'create'])->name('teams.create');
    Route::post('teams/store', [App\Http\Controllers\TeamController::class, 'store'])->name('teams.store');
    Route::delete('teams/destroy/{team}', [App\Http\Controllers\TeamController::class, 'destroy'])->name('teams.destroy');

    // Carreras

    Route::get('races/edit/{race}', [App\Http\Controllers\RaceController::class, 'edit'])->name('races.edit');
    Route::put('races/update/{race}', [App\Http\Controllers\RaceController::class, 'update'])->name('races.update');
    //Route::get('races/create', [App\Http\Controllers\RaceController::class, 'create'])->name('races.create');
    Route::post('races/store', [App\Http\Controllers\RaceController::class, 'store'])->name('races.store');
    Route::delete('races/destroy/{race}', [App\Http\Controllers\RaceController::class, 'destroy'])->name('races.destroy');


});

// Ruta de fallback customizada
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


//Route::resource('races', RaceController::class);


require __DIR__ . '/auth.php';
