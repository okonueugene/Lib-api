<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Books;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BooksResource;
use App\Http\Requests\StoreBooksRequest;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BooksResource::collection(Books::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBooksRequest $request)
    {
        $book = Books::create($request->validated());
        return BooksResource::make($book);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $book = Books::find($id);
        return BooksResource::make($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}