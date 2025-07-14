<?php

namespace Modules\DepartamentiShitjes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DepartamentiShitjes\Database\Factories\DshProductFactory;

class DshProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['product_name', 'color','dimension','afati_realizimit_product', 'category_id','kryeinxhinieri_product_confirmation', 'offert_price', 'kostoisti_product_confirmation', 'product_description', 'product_type','user_id', 'product_status', 'product_price', 'product_quantity', 'product_confirmation', 'total_cost', 'product_project_id','ofertuesi_status','refuse_comment'];

    // protected static function newFactory(): DshProductFactory
    // {
    //     // return DshProductFactory::new();
    // }
}
