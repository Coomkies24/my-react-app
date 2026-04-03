<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Member;
use App\Models\Category;
use App\Models\Book;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    $member = Member::with(['membershipCard', 'books'])->first();
    $members = Member::with('books')->get();
    $books = Book::with('members')->get();

    if (!$member) {
        return "No member found. Please run migration and seeder.";
    }

    $categories = Category::with('books')->get();

    return [
        'ONE TO ONE (Member to Membership Card)' => [
            'Member' => $member->name,
            'Card' => optional($member->membershipCard)->card_number
        ],

        'ONE TO MANY (Category to Books)' => $categories->map(function ($cat) {
            return [
                'Category' => $cat->name,
                'Books' => $cat->books->pluck('title')
            ];
        }),

        'MANY TO MANY (Members and Books)' => [
            'Members with their Books' => $members->map(function ($m) {
                return [
                    'Member' => $m->name,
                    'Books' => $m->books->pluck('title')
                ];
            }),

            'Books with their Members' => $books->map(function ($b) {
                return [
                    'Book' => $b->title,
                    'Members' => $b->members->pluck('name')
                ];
            }),
        ]
    ];
});

require __DIR__.'/auth.php';
