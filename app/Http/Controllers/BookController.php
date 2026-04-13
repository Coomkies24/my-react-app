<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * READ: Display a listing of the resource.
     */
    public function index()
    {
        // ACTIVITY REQUIREMENT: Use eager loading (with('category'))
        $books = Book::with('category')->latest()->get();
        
        // We also pass categories so we can use them in the "Create Book" dropdown
        $categories = Category::all();

        return Inertia::render('Books/Index', [
            'books' => $books,
            'categories' => $categories
        ]);
    }

    /**
     * CREATE: Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // BACKEND SECURITY: Only Admins can add books
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action. Admins only.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        Book::create($validated);

        return redirect()->back()->with('message', 'Book created successfully!');
    }

    /**
     * UPDATE: Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        // BACKEND SECURITY: Only Admins can edit books
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action. Admins only.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book->update($validated);

        return redirect()->back()->with('message', 'Book updated successfully!');
    }

    /**
     * DELETE: Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // BACKEND SECURITY: Only Admins can delete books
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action. Admins only.');
        }
        
        $book->delete();

        return redirect()->back()->with('message', 'Book deleted successfully!');
    }
}