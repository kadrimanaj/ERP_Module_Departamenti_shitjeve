<?php

namespace Modules\DepartamentiShitjes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DepartamentiShitjes\Database\Factories\DshModeleItemsFactory;

class DshModeleItems extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['model_id','modele_item_id','input_type','input_name','input_options','icon','cols','parent_name'];

    // protected static function newFactory(): DshModeleItemsFactory
    // {
    //     // return DshModeleItemsFactory::new();
    // }
}
