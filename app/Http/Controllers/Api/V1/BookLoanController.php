<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\BookLoans;
use Illuminate\Http\Request;

class BookLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BookLoansResource::collection(BookLoans::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookLoanRequest $request)
    {
        $book = Books::findOrFail($request->book_id);

        if ($book->copies()->available()->count() === 0) {
            return response()->json(['message' => 'No copies available'], 400);
        }

        try {
            \DB::beginTransaction();

            $bookLoan = BookLoans::create($request->validated());

            \DB::commit();

            return BookLoansResource::make($bookLoan);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BookLoans $bookLoans)
    {
        return BookLoansResource::make($bookLoans);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookLoans $bookLoans)
    {
        try {
            \DB::beginTransaction();

            $bookLoans->delete();

            \DB::commit();

            return response()->json(['message' => 'Book loan deleted successfully']);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


}
