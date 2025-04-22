<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileUpload;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/agent', [AgentController::class, 'index'])->name('agent.index');
    Route::get('/agent/create', [AgentController::class, 'create'])->name('agent.create');
    Route::post('/agent', [AgentController::class, 'store'])->name('agent.store');
    Route::get('/agent/{agent}/edit', [AgentController::class, 'edit'])->name('agent.edit');
    Route::put('/agent/{agent}/update', [AgentController::class, 'update'])->name('agent.update');
    Route::delete('/agent/{agent}/destroy',[AgentController::class, 'destroy'])->name('agent.destroy');
});

require __DIR__.'/auth.php';
