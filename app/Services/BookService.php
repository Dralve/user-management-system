<?php

namespace App\Services;

use App\Models\Book;

class BookService
{

    public function createBook(array $data)
    {
        return Book::create($data);
    }

    public function updateBook(Book $book, array $data): Book
    {
        $book->update($data);
        return $book;
    }

    public function restoreBook($id)
    {
        $book = Book::onlyTrashed()->find($id);
        if ($book){
            $book->restore();
        }

        return $book;
    }

    public function permanentlyDeleteBook($id)
    {
        $book = Book::withTrashed()->find($id);
        if ($book){
            $book->forceDelete();
        }

        return $book;
    }
}
