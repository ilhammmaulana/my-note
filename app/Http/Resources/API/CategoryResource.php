<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "category_name" => $this->category_name,
            "total_notes" => $this->notes_count,
            "created_at" => $this->created_at->format('Y-m-d H:m:s'),
            "updated_at" => $this->updated_at->format('Y-m-d H:m:s')
        ];
    }
}
