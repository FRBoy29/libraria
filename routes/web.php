<?php

use App\Livewire\Admin\Auth\Login as AdminLogin;
use App\Livewire\Auth\Login as LegacyLogin;
use App\Livewire\Book\Manager as BookManager;
use App\Livewire\Borrowing\Manager as BorrowingManager;
use App\Livewire\Category\Manager as CategoryManager;
use App\Livewire\Dashboard\Stats;
use App\Livewire\Member\Auth\Login as MemberLogin;
use App\Livewire\Member\BookDetail as MemberBookDetail;
use App\Livewire\Member\Catalog as MemberCatalog;
use App\Livewire\Member\Dashboard as MemberDashboard;
use App\Livewire\Member\History as MemberHistory;
use App\Livewire\Member\Manager as MemberManager;
use App\Livewire\Member\MyBorrowings as MemberBorrowings;
use App\Livewire\Member\Profile as MemberProfile;
use App\Livewire\Report\Index as Reports;
use App\Livewire\ReturnBook\Manager as ReturnsManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('landing.index'))->name('landing');

Route::get('/login', fn () => redirect('/admin/login'));

Route::get('/admin/login', AdminLogin::class)->middleware('admin.guest')->name('admin.login');
Route::post('/admin/logout', function () {
    Auth::guard('web')->logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/admin/login');
})->middleware('admin.auth')->name('admin.logout');

// Backward-compat lama: POST /logout untuk admin
Route::post('/logout', function () {
    Auth::guard('web')->logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/admin/login');
})->middleware('admin.auth');

Route::get('/member/login', MemberLogin::class)->middleware('member.guest')->name('member.login');
Route::post('/member/logout', function () {
    Auth::guard('member')->logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/member/login');
})->middleware('member.auth')->name('member.logout');

Route::middleware('admin.auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', Stats::class);
    Route::get('/categories', CategoryManager::class);
    Route::get('/books', BookManager::class);
    Route::get('/books/export', function () {
        $rows = \App\Models\Book::with('category')->orderBy('id')->get();
        $name = 'katalog-buku-' . now()->format('Ymd') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ISBN', 'Judul', 'Penulis', 'Penerbit', 'Tahun', 'Kategori', 'Stok', 'Deskripsi']);
            foreach ($rows as $b) {
                fputcsv($out, [
                    $b->isbn, $b->title, $b->author, $b->publisher, $b->publication_year,
                    $b->category->name ?? '', $b->stock, $b->description,
                ]);
            }
            fclose($out);
        }, $name, ['Content-Type' => 'text/csv']);
    });
    Route::get('/books/create', BookManager::class);
    Route::get('/books/{id}/edit', BookManager::class);
    Route::get('/members', MemberManager::class);
    Route::get('/members/export', function () {
        $rows = \App\Models\Member::orderBy('id')->get([
            'member_code', 'name', 'email', 'phone', 'address', 'status', 'active_until', 'created_at',
        ]);
        $name = 'anggota-libraria-' . now()->format('Ymd') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Member Code', 'Nama', 'Email', 'Telepon', 'Alamat', 'Status', 'Aktif Sampai', 'Terdaftar']);
            foreach ($rows as $m) {
                fputcsv($out, [
                    $m->member_code, $m->name, $m->email, $m->phone, $m->address,
                    $m->status, $m->active_until, $m->created_at,
                ]);
            }
            fclose($out);
        }, $name, ['Content-Type' => 'text/csv']);
    });
    Route::get('/members/create', MemberManager::class);
    Route::get('/members/{id}/edit', MemberManager::class);
    Route::get('/borrowings', BorrowingManager::class);
    Route::get('/borrowings/create', BorrowingManager::class);
    Route::get('/returns', ReturnsManager::class);
    Route::get('/reports', Reports::class);
    Route::get('/profile', \App\Livewire\Admin\Profile::class);
});

Route::middleware('member.auth')->prefix('member')->group(function () {
    Route::get('/dashboard', MemberDashboard::class);
    Route::get('/books', MemberCatalog::class);
    Route::get('/books/{id}', MemberBookDetail::class);
    Route::get('/activity', \App\Livewire\Member\Activity::class);
    Route::get('/profile', MemberProfile::class);
    Route::redirect('/borrowings', '/member/activity');
    Route::redirect('/history', '/member/activity');
});

// Referensi lama yang tidak dipakai lagi (dipertahankan agar tidak 404 bila di-bookmark)
Route::get('/legacy-login', LegacyLogin::class)->middleware('admin.guest');
