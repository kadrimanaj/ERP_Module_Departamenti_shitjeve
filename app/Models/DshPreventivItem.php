<?php

namespace Modules\DepartamentiShitjes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DepartamentiShitjes\Database\Factories\DshPreventivItemFactory;

class DshPreventivItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['sku_code', 'product_id','element_id', 'product_type', 'product_name', 'unit_id', 'quantity', 'cost','user_id'];

    // protected static function newFactory(): DshPreventivItemFactory
    // {
    //     // return DshPreventivItemFactory::new();
    // }
}
