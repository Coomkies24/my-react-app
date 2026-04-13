<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController; // <-- Added this
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Imports for your debug route
use App\Models\Member;
use App\Models\Category;
use App\Models\Book;
use App\Http\Middleware\AdminMiddleware;

// 1. Standard Welcome Page
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// 2. Dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Consolidated Authenticated Routes (This handles your Access Rules)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Books CRUD API/Routes
    // We exclude create/edit/show since we'll likely use modals or a single page in React
    Route::resource('books', BookController::class)->except(['create', 'edit', 'show']);
});

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    // Only admins can access routes inside this group!
    Route::get('/manage-users', function() {
        return "Welcome Admin!";
    });
});

// 4. Moved your Activity 2 tests here so they don't break the home page!
Route::get('/debug', function () {
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
