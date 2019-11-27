<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "number" => $this->number,
            "address" => $this->address,
            "status" => $this->status,
            "payment" => $this->payment,
            "type" => $this->type,
            "total" => $this->total,
            "items" => $this->type == "dinner" ? $this->dinners()->where('date', today())->get() : $this->meals()->get(),
            "user" => new UserResource($this->user)
        ];
    }
}
