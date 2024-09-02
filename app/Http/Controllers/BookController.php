<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Menampilkan semua buku
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    // Menyimpan buku baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'published_year' => 'required|digits:4|integer|min:1000|max:' . date('Y'),
        ]);

        $book = Book::create($validatedData);

        return response()->json([
            'message' => 'Book created successfully',
            'data'    => $book
        ], 201);
    }

    // Menampilkan detail buku berdasarkan ID
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }

        return response()->json($book);
    }

    // Mengupdate data buku
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }

        $validatedData = $request->validate([
            'title'          => 'sometimes|required|string|max:255',
            'author'         => 'sometimes|required|string|max:255',
            'published_year' => 'sometimes|required|digits:4|integer|min:1000|max:' . date('Y'),
        ]);

        $book->update($validatedData);

        return response()->json([
            'message' => 'Book updated successfully',
            'data'    => $book
        ]);
    }

    // Menghapus buku
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully'
        ]);
    }
}
