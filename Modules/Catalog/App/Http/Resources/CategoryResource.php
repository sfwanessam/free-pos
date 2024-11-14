<?php

namespace Modules\Catalog\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'active' => $this->active,
            'image' => $this->image,
            'products_count' => $this->products->count(),
            'image_path' =>  getImage($this->image),
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
