<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_id' => 'required|integer|exists:books,id',
            'user_id' => 'required|integer|exists:users,id',
            'can_date' => 'required|date',
            'due_date' => 'required|date',
            'return_date' => 'nullable|date',
            'extended' => 'required|string|max:3',
            'extension_tale_cate' => 'nullable|string|max:200',
            'penalty_amount' => 'nullable|string',
            'penalty_status' => 'required|string|max:15',
            'added_by' => 'required|integer|exists:users,id',
        ];
    }
}