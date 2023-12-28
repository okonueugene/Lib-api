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
            'return_date' => 'nullable|date',
            'extended' => 'sometimes|string|max:3',
            'extension_tale_cate' => 'sometimes|string|max:200',
            'penalty_amount' => 'sometimes|string',
            'penalty_status' => 'sometimes|string|max:15',
        ];
    }
}