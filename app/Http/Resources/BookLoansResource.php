<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookLoansResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $username = User::where('id', $this->user_id)->pluck('name')->toArray();


        return [
            'id' => $this->id,
            'book_name' => $this->book->name,
            'borrower' => $username[0],
            'can_date' => $this->can_date,
            'due_date' => $this->due_date,
            'return_date' => $this->return_date,
            'extended' => $this->extended,
            'extension_tale_cate' => $this->extension_tale_cate,
            'penalty_amount' => $this->penalty_amount,
            'penalty_status' => $this->penalty_status,
            'status' => $this->status,
            'added_by' => $this->addedBy->name,
        ];
    }
}
