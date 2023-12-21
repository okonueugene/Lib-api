<?php

namespace App\Http\Resources;

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

        return [
            'id' => $this->id,
            'book_name' => $this->book->name,
            'borrower' => $this->user_id->name,
            'can_date' => $this->can_date,
            'due_date' => $this->due_date,
            'return_date' => $this->return_date,
            'extended' => $this->extended,
            'extension_tale_cate' => $this->extension_tale_cate,
            'penalty_amount' => $this->penalty_amount,
            'penalty_status' => $this->penalty_status,
            'added_by' => $this->added_by->name,
        ];
    }
}
