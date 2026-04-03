<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Category;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $member1 = Member::create([
            'name' => 'Daniel Casimiro',
            'email' => 'daniel@test.com',
            'password' => bcrypt('123456')
        ]);

        $member2 = Member::create([
            'name' => 'Maria Santos',
            'email' => 'maria@test.com',
            'password' => bcrypt('123456')
        ]);

        // One-to-One
        $member1->membershipCard()->create([
            'card_number' => 'LIB123'
        ]);

        $member2->membershipCard()->create([
            'card_number' => 'LIB456'
        ]);

        // One-to-Many
        $category = Category::create([
            'name' => 'Science'
        ]);

        $book1 = $category->books()->create([
            'title' => 'Physics Basics'
        ]);

        $book2 = $category->books()->create([
            'title' => 'Chemistry Intro'
        ]);

        // Many-to-Many

        $member1->books()->attach([$book1->id, $book2->id]);
        $member2->books()->attach($book1->id);
    }
}
