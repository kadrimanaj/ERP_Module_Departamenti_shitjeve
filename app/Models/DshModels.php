<?php

namespace Modules\DepartamentiShitjes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DepartamentiShitjes\Database\Factories\DshModelsFactory;

class DshModels extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['model_name', 'category_id', 'tags'];

    // protected static function newFactory(): DshModelsFactory
    // {
    //     // return DshModelsFactory::new();
    // }
}
