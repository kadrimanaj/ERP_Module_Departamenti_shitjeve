<?php

namespace Modules\DepartamentiShitjes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DepartamentiShitjes\Database\Factories\DshPreventivFactory;

class DshPreventiv extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['project_id', 'client_id', 'total','user_id'];

    // protected static function newFactory(): DshPreventivFactory
    // {
    //     // return DshPreventivFactory::new();
    // }
}
