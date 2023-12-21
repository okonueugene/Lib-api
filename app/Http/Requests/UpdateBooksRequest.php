<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBooksRequest extends FormRequest
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
            'name' => 'sometimes|string|max:500',
            'publisher' => 'sometimes|string',
            'category_id' => 'sometimes|integer',
            'sub_category_id' => 'sometimes|integer',
            'description' => 'sometimes|string',
            'pages' => 'sometimes|integer',
            'image' => 'sometimes|string',
        ];
    }
}
