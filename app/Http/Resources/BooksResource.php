<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BooksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'name' => $this->name,
            'publisher' => $this->publisher,
            'category' => $this->category->name,
            'sub_category' => $this->subCategory->name,
            'description' => $this->description,
            'pages' => $this->pages,
            'image' => $this->image,
            'added_by' => $this->addedBy->name,
        ];
    }
}