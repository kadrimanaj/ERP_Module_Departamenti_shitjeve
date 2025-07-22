<?php

namespace Modules\DepartamentiShitjes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DepartamentiShitjes\Database\Factories\DshCategoryFactory;

class DshCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['parent_id', 'name'];

    // protected static function newFactory(): DshCategoryFactory
    // {
    //     // return DshCategoryFactory::new();
    // }
}
