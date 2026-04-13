<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Category;
use App\Models\User;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Fetch the users we created in DatabaseSeeder
        // We link these library profiles to the login accounts
        $adminUser = User::where('email', 'admin@library.com')->first();
        $memberUser = User::where('email', 'member@library.com')->first();

        // 2. Create Members (Removed email/password as they now live in the Users table)
        $member1 = Member::create([
            'user_id' => $adminUser->id, // Linked to the admin login
            'name'    => 'Daniel Casimiro',
        ]);

        $member2 = Member::create([
            'user_id' => $memberUser->id, // Linked to the regular member login
            'name'    => 'Maria Santos',
        ]);

        // 3. One-to-One
        $member1->membershipCard()->create(['card_number' => 'LIB123']);
        $member2->membershipCard()->create(['card_number' => 'LIB456']);

        // 4. One-to-Many
        $category = Category::create(['name' => 'Science']);
        $book1 = $category->books()->create(['title' => 'Physics Basics']);
        $book2 = $category->books()->create(['title' => 'Chemistry Intro']);

        // 5. Many-to-Many
        $member1->books()->attach([$book1->id, $book2->id]);
        $member2->books()->attach($book1->id);
    }
}