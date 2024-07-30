<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

class BookTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_book()
    {
        $response = $this->withoutMiddleware()->post('/books', [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'published_year' => 2024,
            'genre' => 'Test Genre',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('books', [
            'title' => 'Test Book',
            'author' => 'Test Author',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_update_a_book()
{
    $book = Book::factory()->create();

    $response = $this->withoutMiddleware()->put("/books/{$book->id}", [
        'title' => 'Updated Book Title',
        'author' => 'Updated Author',
        'published_year' => 2025,
        'genre' => 'Updated Genre',
    ]);

    $response->assertStatus(302);

    $book->refresh();

    $this->assertEquals('Updated Book Title', $book->title);
    $this->assertEquals('Updated Author', $book->author);
}

#[\PHPUnit\Framework\Attributes\Test]
public function it_can_delete_a_book()
{
    $book = Book::factory()->create();

    $response = $this->withoutMiddleware()->delete("/books/{$book->id}");

    $response->assertStatus(302);
    $this->assertDatabaseMissing('books', [
        'id' => $book->id,
    ]);
}

}
