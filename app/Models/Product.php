<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'description',
        'quantity',
        'price',
        'brand',
        'category_id'
    ];


    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function purchases()
    {
        return $this->hasMany('App\Models\Purchase');
    }
}
