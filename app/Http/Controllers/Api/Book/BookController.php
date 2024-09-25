<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{

    protected BookService $bookService;

    /**
     * @param BookService $bookService
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('view-book')){
            return response()->json(['message' => 'You do not have permission to view books']);
        }

        return Book::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookRequest $request
     * @return JsonResponse
     */
    public function store(BookRequest $request): JsonResponse
    {
        if (!auth()->user()->hasPermission('create-book')){
            return response()->json(['message' => 'You do not have permission to create book']);
        }

        $book = $this->bookService->createBook($request->validated());
        return response()->json(['message' => 'Book created successfully', 'book' => $book], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @return Book|JsonResponse
     */
    public function show(Book $book): Book|JsonResponse
    {
        if (!auth()->user()->hasPermission('view-book')){
            return response()->json(['message' => 'You do not have permission to view book']);
        }

        return $book->load('category:id,name');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBookRequest $request
     * @param Book $book
     * @return JsonResponse
     */
    public function update(UpdateBookRequest $request, Book $book): JsonResponse
    {
        if (!auth()->user()->hasPermission('edit-book')){
            return response()->json(['message' => 'You do not have permission to update book']);
        }

        $data = $request->validated();
        $updatedBook = $this->bookService->updateBook($book, $data);
        return response()->json(['message' => 'Book updated successfully', 'book' => $updatedBook], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Book $book
     * @return JsonResponse
     */
    public function destroy(Book $book): JsonResponse
    {
        if (!auth()->user()->hasPermission('delete-book')){
            return response()->json(['message' => 'You do not have permission to delete book']);
        }

        $book->delete();
        return response()->json(['message' => 'Book deleted successfully'], 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function restore($id): JsonResponse
    {
        if (!auth()->user()->hasPermission('restore')){
            return response()->json(['message' => 'You do not have permission to restore book']);
        }

        $book =$this->bookService->restoreBook($id);
        return response()->json(['message' => 'Book restored successfully', 'book' => $book], 200);
    }

    /**
     * @return array|Collection|JsonResponse
     */
    public function getDeletedBooks(): array|Collection|JsonResponse
    {
        if (!auth()->user()->hasPermission('view-deleted-data')){
            return response()->json(['message' => 'You do not have permission to view deleted book']);
        }

        return Book::onlyTrashed()->get();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function forceDelete($id): JsonResponse
    {
        if (!auth()->user()->hasRole('admin')){
            return response()->json(['message' => 'You do not have permission to delete book']);
        }

        $this->bookService->permanentlyDeleteBook($id);
        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}
