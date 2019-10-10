<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dinner extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dinners';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'day', 'day_en', 'date'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get all meals pivot.
     */
    public function meals()
    {
        return $this->belongsToMany(Meal::class)->withPivot('type','qty');
    }
}
