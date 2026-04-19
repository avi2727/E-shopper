<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (float) $this->price,
            'availability' => (int) $this->availability,
            'category_id' => (int) $this->category_id,
            'location' => $this->location,
            'size' => $this->size,
            'color' => $this->color,
            'information' => $this->information,
            'Supercategory_id' => (int) $this->Supercategory_id,
            'trandy' => (int) $this->trandy,
            'justArrived' => (int) $this->justArrived,
            'product_image' => $this->product_image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
