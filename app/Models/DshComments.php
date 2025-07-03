<?php

namespace Modules\DepartamentiShitjes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DepartamentiShitjes\Database\Factories\DshCommentsFactory;

class DshComments extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['comment_type', 'comment', 'user_id', 'project_id'];

    // protected static function newFactory(): DshCommentsFactory
    // {
    //     // return DshCommentsFactory::new();
    // }
}