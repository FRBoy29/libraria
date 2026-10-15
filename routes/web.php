<?php

use App\Livewire\Admin\Auth\Login as AdminLogin;
use App\Livewire\Book\Manager as BookManager;
use App\Livewire\Category\Manager as CategoryManager;
use App\Livewire\Dashboard\Stats;
use App\Livewire\Member\Auth\Login as MemberLogin;
use App\Livewire\Member\BookDetail as MemberBookDetail;
use App\Livewire\Member\Catalog as MemberCatalog;
use App\Livewire\Member\Dashboard as MemberDashboard;
use App\Livewire\Member\Manager as MemberManager;
use App\Livewire\Member\Profile as MemberProfile;
use App\Livewire\Report\Index as Reports;
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

        $sheet = (new \PhpOffice\PhpSpreadsheet\Spreadsheet())->getActiveSheet();
        $sheet->fromArray(
            [['ISBN', 'Judul', 'Penulis', 'Penerbit', 'Tahun', 'Kategori', 'Stok', 'Deskripsi']],
            null, 'A1', true
        );
        foreach ($rows as $i => $b) {
            $sheet->fromArray([[
                $b->isbn, $b->title, $b->author, $b->publisher, $b->publication_year,
                $b->category->name ?? '', $b->stock, $b->description,
            ]], null, 'A' . ($i + 2), true);
        }
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return response()->streamDownload(function () use ($sheet) {
            (new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($sheet->getParent()))->save('php://output');
        }, 'katalog-buku-' . now()->format('Ymd') . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    });
    Route::get('/books/create', BookManager::class);
    Route::get('/books/{id}/edit', BookManager::class);
    Route::get('/members', MemberManager::class);
    Route::get('/members/export', function () {
        $rows = \App\Models\Member::orderBy('id')->get();

        $sheet = (new \PhpOffice\PhpSpreadsheet\Spreadsheet())->getActiveSheet();
        $sheet->fromArray(
            [['Member Code', 'Nama', 'Email', 'Telepon', 'Alamat', 'Status', 'Aktif Sampai', 'Terdaftar']],
            null, 'A1', true
        );
        foreach ($rows as $i => $m) {
            $sheet->fromArray([[
                $m->member_code, $m->name, $m->email, $m->phone, $m->address,
                $m->status, (string) $m->active_until,
                $m->created_at ? $m->created_at->format('Y-m-d H:i') : '',
            ]], null, 'A' . ($i + 2), true);
        }
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return response()->streamDownload(function () use ($sheet) {
            (new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($sheet->getParent()))->save('php://output');
        }, 'anggota-libraria-' . now()->format('Ymd') . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    });
    Route::get('/members/create', MemberManager::class);
    Route::get('/members/{id}/edit', MemberManager::class);
    Route::get('/circulations', \App\Livewire\Circulation\Manager::class);
    Route::get('/borrowings', fn () => redirect('/admin/circulations' . (request()->getQueryString() ? '?' . request()->getQueryString() : '')));
    Route::get('/borrowings/create', fn () => redirect('/admin/circulations?create=1' . (request()->getQueryString() ? '&' . request()->getQueryString() : '')));
    Route::get('/returns', fn () => redirect('/admin/circulations'));
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
