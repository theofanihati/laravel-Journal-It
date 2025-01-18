<?php

use App\Models\Journal;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('auth/register');
});

Route::get('/dashboard', [JournalController::class, 'home'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
    Route::post('/journals/delete', [JournalController::class, 'delete'])->name('journals.delete');
});

Route::get('/add-journal', function () {
    return view('add-journal');
})->name('journals.create');

Route::post('/journals', [JournalController::class, 'store'])->name('journals.store');

Route::get('/edit-journal/{id_journal}', [JournalController::class, 'editJournal'])->name('edit-journal');

Route::post('/edit-journal/{id_journal}', [JournalController::class, 'updateJournal'])->name('update-journal');

require __DIR__.'/auth.php';