<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'name', 'name_en','price','type', 'detail', 'detail_en','rating','rating_count','category_id', 'calorie', 'image'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}