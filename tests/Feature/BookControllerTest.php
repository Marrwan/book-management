<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_all_books()
    {
        $book = Book::factory()->create();

        $response = $this->get(route('books.index'));

        $response->assertStatus(200)
                 ->assertViewHas('books', Book::all());
    }

    /** @test */
    public function it_displays_create_book_form()
    {
        $response = $this->get(route('books.create'));

        $response->assertStatus(200)
                 ->assertViewIs('Books/Create');
    }

    /** @test */
    public function it_stores_a_new_book()
    {
        $response = $this->withoutMiddleware()->post(route('books.store'), [
            'title' => 'New Book Title',
            'author' => 'Author Name',
            'published_year' => 2023,
            'genre' => 'Fiction',
        ]);
    
        $response->assertRedirect(route('books.index'))
                 ->assertSessionHas('flash', ['message' => 'Book added successfully!', 'type' => 'success']);
    
        $this->assertDatabaseHas('books', [
            'title' => 'New Book Title',
            'author' => 'Author Name',
        ]);
    }
    
    public function it_updates_a_book()
    {
        $book = Book::factory()->create();
        $response = $this->withoutMiddleware()->put(route('books.update', $book), [
            'title' => 'Updated Book Title',
            'author' => 'Updated Author',
            'published_year' => 2024,
            'genre' => 'Non-Fiction',
        ]);
    
        $response->assertRedirect(route('books.index'))
                 ->assertSessionHas('flash', ['message' => 'Book updated successfully!', 'type' => 'success']);
    
        $this->assertDatabaseHas('books', [
            'title' => 'Updated Book Title',
            'author' => 'Updated Author',
        ]);
    }
    
    public function it_deletes_a_book()
    {
        $book = Book::factory()->create();
    
        $response = $this->withoutMiddleware()->delete(route('books.destroy', $book));
    
        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);
    }
    

    /** @test */
    public function it_displays_validation_errors_when_storing_a_book()
    {
        $response = $this->post(route('books.store'), []);

        $response->assertRedirect()
                 ->assertSessionHasErrors(['title', 'author', 'published_year', 'genre']);
    }

    /** @test */
    public function it_displays_validation_errors_when_updating_a_book()
    {
        $book = Book::factory()->create();
        $response = $this->put(route('books.update', $book), []);

        $response->assertRedirect()
                 ->assertSessionHasErrors(['title', 'author', 'published_year', 'genre']);
    }
}
