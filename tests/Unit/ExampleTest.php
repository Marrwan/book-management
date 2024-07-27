<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_book()
    {
        $book = Book::create([
            'title' => 'Test Book',
            'author' => 'Test Author',
            'published_year' => 2020,
            'genre' => 'Test Genre',
        ]);

        $this->assertDatabaseHas('books', ['title' => 'Test Book']);
    }

    public function test_update_book()
    {
        $book = Book::create([
            'title' => 'Test Book',
            'author' => 'Test Author',
            'published_year' => 2020,
            'genre' => 'Test Genre',
        ]);

        $book->update(['title' => 'Updated Book']);
        $this->assertDatabaseHas('books', ['title' => 'Updated Book']);
    }

       public function test_delete_book()
    {
        $book = Book::create([
            'title' => 'Test Book',
            'author' => 'Test Author',
            'published_year' => 2020,
            'genre' => 'Test Genre',
        ]);

        $book->delete();
        $this->assertDatabaseMissing('books', ['title' => 'Test Book']);
    }
}
