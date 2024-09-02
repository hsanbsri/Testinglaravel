<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_retrieve_list_of_books()
    {
        $books = Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonFragment(['title' => $books[0]->title]);
    }

    /** @test */
    public function can_create_a_book()
    {
        $bookData = [
            'title' => 'New Book',
            'author' => 'Author Name',
            'published_year' => 2023,
        ];

        $response = $this->postJson('/api/books', $bookData);

        $response->assertStatus(201)
            ->assertJsonFragment($bookData);

        $this->assertDatabaseHas('books', $bookData);
    }

    /** @test */
    public function can_retrieve_a_single_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJson($book->toArray());
    }

    /** @test */
    public function can_update_a_book()
    {
        $book = Book::factory()->create();

        $updateData = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'published_year' => 2024,
        ];

        $response = $this->putJson("/api/books/{$book->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment($updateData);

        $this->assertDatabaseHas('books', $updateData);
    }

    /** @test */
    public function can_delete_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
