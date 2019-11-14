<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'address','type','total','status', 'payment','user_id'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'payment' => 'boolean'
    ];
    /**
     * Get all meals pivot.
     */
    public function meals()
    {
        return $this->morphedByMany(Meal::class, 'orderable');
    }

    /**
     * Get all of the campaigns that are assigned this tag.
     */
    public function dinners()
    {
        return $this->morphedByMany(Dinner::class, 'orderable');
    }
}