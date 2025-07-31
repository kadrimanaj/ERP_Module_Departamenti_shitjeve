<?php

namespace Modules\DepartamentiShitjes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DepartamentiShitjes\Database\Factories\DshHapsiraCategoryFactory;

class DshHapsiraCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['hapsira_category_name'];

    // protected static function newFactory(): DshHapsiraCategoryFactory
    // {
    //     // return DshHapsiraCategoryFactory::new();
    // }
}
