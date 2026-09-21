<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@libraria.local'],
            ['name' => 'Admin Libraria', 'password' => Hash::make('password')]
        );

        $categories = collect([
            ['name' => 'Fiksi', 'description' => 'Novel dan cerita fiksi'],
            ['name' => 'Non-Fiksi', 'description' => 'Pengetahuan umum'],
            ['name' => 'Sains', 'description' => 'Buku sains dan teknologi'],
            ['name' => 'Sejarah', 'description' => 'Buku sejarah'],
            ['name' => 'Teknologi', 'description' => 'Komputer dan IT'],
        ])->map(fn ($c) => Category::updateOrCreate(['name' => $c['name']], $c));

        $books = [
            ['isbn' => '978-602-001', 'title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'publisher' => 'Bentang', 'publication_year' => 2005, 'stock' => 10, 'category' => 'Fiksi'],
            ['isbn' => '978-602-002', 'title' => 'Bumi', 'author' => 'Tere Liye', 'publisher' => 'Gramedia', 'publication_year' => 2014, 'stock' => 8, 'category' => 'Fiksi'],
            ['isbn' => '978-602-003', 'title' => 'Filosofi Teras', 'author' => 'Henry Manampiring', 'publisher' => 'Kompas', 'publication_year' => 2018, 'stock' => 5, 'category' => 'Non-Fiksi'],
            ['isbn' => '978-602-004', 'title' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'publisher' => 'Gramedia', 'publication_year' => 2011, 'stock' => 4, 'category' => 'Sains'],
            ['isbn' => '978-602-005', 'title' => 'Sejarah Indonesia', 'author' => 'M.C. Ricklefs', 'publisher' => 'Serambi', 'publication_year' => 2008, 'stock' => 6, 'category' => 'Sejarah'],
            ['isbn' => '978-602-006', 'title' => 'Clean Code', 'author' => 'Robert C. Martin', 'publisher' => 'Prentice Hall', 'publication_year' => 2008, 'stock' => 3, 'category' => 'Teknologi'],
            ['isbn' => '978-602-007', 'title' => 'Stok Habis Demo', 'author' => 'Penulis', 'publisher' => 'Demo', 'publication_year' => 2020, 'stock' => 0, 'category' => 'Fiksi'],
        ];

        foreach ($books as $b) {
            $cat = $categories->firstWhere('name', $b['category']);
            Book::updateOrCreate(['isbn' => $b['isbn']], [
                'category_id' => $cat->id,
                'title' => $b['title'],
                'author' => $b['author'],
                'publisher' => $b['publisher'],
                'publication_year' => $b['publication_year'],
                'stock' => $b['stock'],
            ]);
        }

        $members = [
            ['member_code' => 'M001', 'name' => 'Budi Santoso', 'email' => 'budi@mail.com', 'phone' => '0811', 'address' => 'Jakarta', 'status' => 'active'],
            ['member_code' => 'M002', 'name' => 'Siti Aminah', 'email' => 'siti@mail.com', 'phone' => '0812', 'address' => 'Bandung', 'status' => 'active'],
            ['member_code' => 'M003', 'name' => 'Andi Wijaya', 'email' => 'andi@mail.com', 'phone' => '0813', 'address' => 'Surabaya', 'status' => 'active'],
        ];
        foreach ($members as $m) {
            Member::updateOrCreate(['member_code' => $m['member_code']], $m);
        }

        if (Borrowing::count() === 0) {
            $member = Member::first();
            $book = Book::where('stock', '>', 1)->first();
            if ($member && $book) {
                $borrowing = Borrowing::create([
                    'member_id' => $member->id,
                    'borrowed_at' => now()->subDays(2),
                    'due_at' => now()->addDays(5),
                    'status' => 'borrowed',
                ]);
                BorrowingDetail::create([
                    'borrowing_id' => $borrowing->id,
                    'book_id' => $book->id,
                    'quantity' => 1,
                    'status' => 'borrowed',
                ]);
                $book->decrement('stock', 1);
            }
        }
    }
}
