<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Review;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Book::factory(33)->create()->each(function ($book) {
             $numReviews = random_int(5,30);
             Review::factory()->count($numReviews)->goodRating()->for($book)->create();
        });
        Book::factory(33)->create()->each(function ($book) {
             $numReviews = random_int(5,30);
             Review::factory()->count($numReviews)->averageRating()->for($book)->create();
        });
        Book::factory(33)->create()->each(function ($book) {
             $numReviews = random_int(5,30);
             Review::factory()->count($numReviews)->badRating()->for($book)->create();
        });
    }
}
