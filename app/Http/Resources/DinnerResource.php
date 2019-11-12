<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DinnerResource extends JsonResource
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
            'id' => $this->id,
            'day' => $this->day,
            'day_en' => $this->day_en,
            'date' => $this->date,
            'price' => $this->price,
            'items' => MealResource::collection($this->meals)
        ];
    }
}
