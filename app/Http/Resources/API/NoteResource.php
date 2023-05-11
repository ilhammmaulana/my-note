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
        $currentYear = date('Y');
        $updatedYear = $this->updated_at->format('Y');
        $formattedDate = ($updatedYear != $currentYear)
            ? $this->updated_at->format('M y') . ' ' . $updatedYear
            : $this->updated_at->format('M y');
        return [
            "id" => $this->id,
            "title" => $this->title,
            "body" => $this->body,
            "tags" => $this->tags,
            "pined" => $this->pinned == 1 || $this->pinned == true ? true : false,
            "updated_at_format" => $formattedDate,
            "updated_at" => $this->updated_at->format('Y-m-d H:m:s'),
            "created_at" => $this->created_at->format('Y-m-d H:m:s')
        ];
    }
}
