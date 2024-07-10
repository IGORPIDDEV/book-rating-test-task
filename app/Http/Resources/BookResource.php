<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            "title" => $this->title,
            "author" => $this->author,
            "cover_image" => $this->cover_image,
            "published_at" => $this->published_at,
        ];
    }
}
