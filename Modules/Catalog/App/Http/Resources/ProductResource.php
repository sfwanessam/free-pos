<?php

namespace Modules\Catalog\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    protected $isMinimal;

    public function __construct($resource, $isMinimal = false)
    {
        $this->isMinimal = $isMinimal;
        parent::__construct($resource);
    }

    
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
             $this->mergeWhen(!$this->isMinimal,[            
                'active' => $this->active,
                'image' => $this->image,
                'stock_quantity' => $this->stock_quantity,
                'is_a_service' => $this->is_a_service,
                'price' => $this->price,
                'last_purchase_price' => $this->last_purchase_price,
                'unit' => $this->unit,
                'category_id' => $this->category_id,
                'category_name' => $this->whenLoaded('category', fn() => $this->category->name),
                'image_path' =>  getImage($this->image,'product'),
                'created_at' =>  (isset($this->created_at) ? $this->created_at->toDateString() : $this->created_at) ,
             ]),
        ];
    }
}
