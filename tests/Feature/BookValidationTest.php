<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function title_is_required()
    {
        $response = $this->postJson('/api/books', [
            'author' => 'Author Name',
            'published_year' => 2023,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('title');
    }

    /** @test */
    public function author_is_required()
    {
        $response = $this->postJson('/api/books', [
            'title' => 'Book Title',
            'published_year' => 2023,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('author');
    }

    /** @test */
    public function published_year_must_be_valid_year()
    {
        $response = $this->postJson('/api/books', [
            'title' => 'Book Title',
            'author' => 'Author Name',
            'published_year' => 'invalid_year',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('published_year');
    }
}
