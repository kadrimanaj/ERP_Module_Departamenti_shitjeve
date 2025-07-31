<?php

namespace Modules\DepartamentiShitjes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DepartamentiShitjes\Database\Factories\DshModelesFactory;

class DshModeles extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['model_name','product_id','product_name','module_name','hapsira_category_id','product_category_id'];

    // protected static function newFactory(): DshModelesFactory
    // {
    //     // return DshModelesFactory::new();
    // }

public function items()
{
    return $this->hasMany(DshModeleItems::class, 'model_id'); // <-- specify correct FK
}
}
