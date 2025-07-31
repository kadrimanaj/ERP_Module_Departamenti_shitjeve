<?php

namespace Modules\DepartamentiShitjes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DepartamentiShitjes\Database\Factories\DshProductsCategoryFactory;

class DshProductsCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['hapsira_id','parent_id','product_category_name'];

    // protected static function newFactory(): DshProductsCategoryFactory
    // {
    //     // return DshProductsCategoryFactory::new();
    // }
}
