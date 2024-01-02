<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\BookCopy;
use App\Models\BookLoans;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookLoansResource;
use App\Http\Requests\StoreBookLoanRequest;

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
     * Store a newly created book loan in storage.
     */
    public function store(StoreBookLoanRequest $request)
    {
        // Check if the user has already borrowed the book
        $existingLoan = BookLoans::where('book_id', $request->book_id)
            ->where('user_id', $request->user_id)
            ->whereNull('return_date')
            ->first();

        if ($existingLoan) {
            return response()->json(['message' => 'You have already borrowed this book'], 400);
        }

        try {
            \DB::beginTransaction();

            // Find an available book copy
            $bookCopy = BookCopy::where('book_id', $request->book_id)
                ->where('is_available', true)
                ->orderBy('copy_number', 'asc') // Order by copy number to get the lowest copy number first
                ->first();

            if (!$bookCopy) {
                return response()->json(['message' => 'No available copies of the book'], 400);
            }

            // Decrement the copy_number
            $bookCopy->decrement('copy_number');

            // Mark the book copy as unavailable if there is only one copy remaining
            if ($bookCopy->copy_number === 0) {
                $bookCopy->update(['is_available' => false ,'updated_at' => now()]);
            }

            // Create the book loan
            $bookLoan = BookLoans::create([
                'book_id' => $request->book_id,
                'user_id' => $request->user_id,
                'can_date' => now(),
                'added_by' => $request->user_id,
                'status' => 'pending',

            ]);

            \DB::commit();

            return BookLoansResource::make($bookLoan);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // /**
    //  * Display the specified book loan.
    //  */
    // public function show(BookLoans $bookLoan)
    // {
    //     return BookLoansResource::make($bookLoan);
    // }


    /**
     * Remove the specified book loan from storage.
     */
    public function destroy($bookLoan)
    {
        try {
            \DB::beginTransaction();

            // Find the book loan by ID
            $bookLoan = BookLoans::findOrFail($bookLoan);

            if(!$bookLoan) {
                return response()->json(['message' => 'Book loan not found'], 404);
            }

            if ($bookLoan->status == 'pending') {
                return response()->json(['message' => 'Book loan cannot be deleted as its pending'], 400);
            }


            // Mark the book copy as available before deleting the loan
            $bookCopy = BookCopy::where('book_id', $bookLoan->book_id)->first();
            $bookCopy->increment('copy_number');
            $bookCopy->update(['is_available' => true]);

            // Delete the book loan
            $bookLoan->delete();

            \DB::commit();

            return response()->json(['message' => 'Book loan deleted successfully']);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Calculate penalty amount if the book is returned late.
     */
    private function calculatePenalty(BookLoans $bookLoan)
    {
        //50 per day after due date
        $penaltyAmount = 0;

        if ($bookLoan->due_date < now()) {
            $daysLate = now()->diffInDays($bookLoan->due_date);
            $penaltyAmount = $daysLate * 50;
        }



        return $penaltyAmount;
    }

    /**
     * Approve a book loan.
     */
    public function approveBookLoan($bookLoan)
    {
        // Check if the user is an admin
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['message' => 'You are not authorized to approve book loans'], 403);
        }

        try {
            \DB::beginTransaction();
            $bookLoan = BookLoans::findOrfail($bookLoan);

            if ($bookLoan->status != 'pending') {
                return response()->json(['message' => 'Book loan cannot be approved'], 400);
            }

            // Update the book loan status
            $bookLoan->update(['status' => 'approved','due_date' => now()->addDays(config('library.lending_period')),'updated_at' => now(), 'updated_by' => auth()->id()]);


            \DB::commit();

            return response()->json(['message' => 'Book loan approved successfully']);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    /**
     * Extend a book loan.
     */

    public function extendBookLoan($bookLoan)
    {
        // Check if the book loan exists and is approved
        $bookLoan = BookLoans::findOrFail($bookLoan);
        if ($bookLoan->status !== 'approved') {
            return response()->json(['message' => 'Book loan not' . $bookLoan->status], 400);
        } elseif($bookLoan->return_date !== null) {
            return response()->json(['message' => 'Book loan has been returned'], 400);
        } elseif($bookLoan->extended == 'yes') {
            return response()->json(['message' => 'Book loan has been extended'], 400);
        } elseif($bookLoan->due_date < now()) {
            return response()->json(['message' => 'Book loan has been overdue'], 400);
        }

        try {
            \DB::beginTransaction();

            // Update the book loan status
            $bookLoan->update(['extended' => 'yes','updated_at' => now(), 'updated_by' => auth()->id(), 'extension_tale_cate' => $bookLoan->due_date, 'due_date' => now()->addDays(config('library.lending_period'))]);

            \DB::commit();

            return response()->json(['message' => 'Book loan extended successfully']);

        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    /**
     * Reject a book loan.
     */
    public function rejectBookLoan($bookLoan)
    {
        // Check if the user is an admin
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['message' => 'You are not authorized to reject book loans'], 403);
        }

        try {
            \DB::beginTransaction();

            // Find the book loan by ID
            $bookLoan = BookLoans::findOrFail($bookLoan);

            // Check if the book loan is pending
            if ($bookLoan->status !== 'pending') {
                return response()->json(['message' => 'Book loan cannot be rejected'], 400);
            }

            // Update the book loan status
            $bookLoan->update(['status' => 'rejected', 'updated_at' => now(), 'updated_by' => auth()->id()]);

            \DB::commit();

            return response()->json(['message' => 'Book loan rejected successfully']);

        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Return a book loan.
     */

    public function returnBook($bookLoan)
    {
        try {
            \DB::beginTransaction();

            // Find the book loan by ID
            $bookLoan = BookLoans::findOrFail($bookLoan);

            // Check if the book is approved and not returned
            if ($bookLoan->status !== 'approved' || $bookLoan->return_date !== null) {
                return response()->json(['message' => 'Book loan not approved or has already been returned'], 400);
            }

            // Update the book loan status
            $bookLoan->update(['status' => 'returned', 'updated_at' => now(), 'updated_by' => auth()->id(), 'return_date' => now()]);

            // Increment the copy_number
            $bookCopy = BookCopy::where('book_id', $bookLoan->book_id)->first();
            $bookCopy->increment('copy_number');

            \DB::commit();

            return response()->json(['message' => 'Book loan returned successfully']);

        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function getApprovedBookLoans()
    {
        return BookLoansResource::collection(BookLoans::where('status', 'approved')->get());
    }

    public function getPendingBookLoans()
    {
        return BookLoansResource::collection(BookLoans::where('status', 'pending')->get());
    }

    public function getRejectedBookLoans()
    {
        return BookLoansResource::collection(BookLoans::where('status', 'rejected')->get());
    }

    public function getReturnedBookLoans()
    {
        return BookLoansResource::collection(BookLoans::where('return_date', '!=', null)->get());
    }

    public function getExtendedBookLoans()
    {
        return BookLoansResource::collection(BookLoans::where('extended', 'yes')->get());
    }

    public function getOverdueBookLoans()
    {
        return BookLoansResource::collection(BookLoans::where('due_date', '<', now())->get());
    }

    public function getUnpaidBookLoans()
    {
        return BookLoansResource::collection(BookLoans::where('penalty_status', 'unpaid')->get());
    }

    public function getUserBookLoans($user)
    {
        return BookLoansResource::collection(BookLoans::where('user_id', $user)->get());
    }
}
