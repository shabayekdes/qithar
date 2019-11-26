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


        if($this->rating != null || $this->rating_count != null){
            $rate = $this->rating / $this->rating_count;
            $rating = round($rate,1);
        }

        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "name_en"=>$this->name_en,
            "price"=> $this->price,
            "detail"=>$this->detail,
            "detail_en"=> $this->detail_en,
            "calorie"=> $this->calorie,
            "image"=> $this->image,
            "type"=> $this->type,
            "category_id"=> $this->category_id,
            "rating"=> $this->rating == null ? 0 : $rating
        ];

    }
}