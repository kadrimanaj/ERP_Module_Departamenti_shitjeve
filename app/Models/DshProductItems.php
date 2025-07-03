<?php

namespace Modules\DepartamentiShitjes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DepartamentiShitjes\Database\Factories\DshProductItemsFactory;

class DshProductItems extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['item_name', 'item_description', 'item_quantity', 'item_dimensions', 'product_id', 'item_price', 'product_type','user_id'];

    // protected static function newFactory(): DshProductItemsFactory
    // {
    //     // return DshProductItemsFactory::new();
    // }
}
