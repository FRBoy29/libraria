<?php

use App\Livewire\Auth\Login;
use App\Livewire\Book\Manager as BookManager;
use App\Livewire\Borrowing\Manager as BorrowingManager;
use App\Livewire\Category\Manager as CategoryManager;
use App\Livewire\Dashboard\Stats;
use App\Livewire\Member\Manager as MemberManager;
use App\Livewire\Report\Index as Reports;
use App\Livewire\ReturnBook\Manager as ReturnsManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/login'));

Route::get('/login', Login::class)->middleware('guest')->name('login');
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/login');
})->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', Stats::class);
    Route::get('/categories', CategoryManager::class);
    Route::get('/books', BookManager::class);
    Route::get('/books/create', BookManager::class);
    Route::get('/books/{id}/edit', BookManager::class);
    Route::get('/members', MemberManager::class);
    Route::get('/members/create', MemberManager::class);
    Route::get('/members/{id}/edit', MemberManager::class);
    Route::get('/borrowings', BorrowingManager::class);
    Route::get('/borrowings/create', BorrowingManager::class);
    Route::get('/returns', ReturnsManager::class);
    Route::get('/reports', Reports::class);
});
