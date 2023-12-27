<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Books;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BooksResource;
use App\Http\Requests\StoreBooksRequest;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:add_books')->only(['store']);
        $this->middleware('permission:view_books')->only(['index', 'show']);
        $this->middleware('permission:edit_books')->only(['update']);
        $this->middleware('permission:delete_books')->only(['destroy']);


    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return BooksResource::collection(Books::orderBy('id', 'desc')->take(350)->get());
        $books = Books::orderBy('id', 'desc')->take(500)->get();
        //load media
        $books->load('media');

        return BooksResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBooksRequest $request)
    {
        try {
            \DB::beginTransaction();

            $book = Books::create($request->validated());

            // Handle image upload
            if ($request->hasFile('image')) {
                $book->addMediaFromRequest('image')->toMediaCollection('book_image');
            }

            \DB::commit();

            return BooksResource::make($book);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $book = Books::find($id);
        return BooksResource::make($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBooksRequest $request, Books $book)
    {
        if (!$book) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        $book->update($request->validated());

        return BooksResource::make($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if (!$book) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);


    }

    public function search($search)
    {
        try {
            // Filter by name or publisher
            $books = Books::where('name', 'like', '%' . $search . '%')
                ->orWhere('publisher', 'like', '%' . $search . '%')
                ->paginate(10);

            // Check if any books were found
            if ($books->isEmpty()) {
                return response()->json(['message' => 'No books found.'], 404);
            }

            return BooksResource::collection($books);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
