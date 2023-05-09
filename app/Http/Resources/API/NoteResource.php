<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
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
            "title" => $this->title,
            "body" => $this->body,
            "tags" => $this->tags,
            "updated_at" => $this->updated_at->format('Y-m-d H:m:s'),
            "created_at" => $this->created_at->format('Y-m-d H:m:s')
        ];
    }
}
