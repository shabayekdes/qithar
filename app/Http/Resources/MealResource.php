<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $rating = $this->rating / $this->rating_count;
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "name_en"=>$this->name_en,
            "price"=> $this->price,
            "detail"=>$this->detail,
            "detail_en"=> $this->detail_en,
            "calorie"=> $this->calorie,
            "image"=> $this->image,
            "rating"=> round($rating,1)
        ];
    }
}