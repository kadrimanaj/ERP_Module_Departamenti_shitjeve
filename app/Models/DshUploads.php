<?php

namespace Modules\DepartamentiShitjes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DepartamentiShitjes\Database\Factories\DshUploadsFactory;

class DshUploads extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['file_name', 'file_id', 'file_path', 'file_type', 'file_size', 'file_userId'];

    // protected static function newFactory(): DshUploadsFactory
    // {
    //     // return DshUploadsFactory::new();
    // }
}
