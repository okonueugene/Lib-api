<?php

namespace App\Http\Resources;

use App\Models\BookCopy;
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
        $mediaUrl = optional($this->media->first())->original_url;
        $copies = BookCopy::where('book_id', $this->id)->pluck('copy_number')->toArray();


        return [
            'id' => $this->id,
            'name' => $this->name,
            'publisher' => $this->publisher,
            'category' => $this->category->name,
            'sub_category' => $this->subCategory->name,
            'description' => $this->description,
            'pages' => $this->pages,
            'image' => $this->image,
            'added_by' => $this->addedBy->name,
            'updated_by' => $this->updatedBy->name ?? null,
            'media' => $mediaUrl,
            'copies' => (int) implode("", $copies),

        ];
    }
}
