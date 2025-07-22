<?php

namespace Modules\DepartamentiShitjes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DepartamentiShitjes\Database\Factories\DshTagsFactory;

class DshTags extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['tag_name'];

    // protected static function newFactory(): DshTagsFactory
    // {
    //     // return DshTagsFactory::new();
    // }
}
