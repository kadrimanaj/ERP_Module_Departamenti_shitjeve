<?php

namespace Modules\DepartamentiShitjes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DepartamentiShitjes\Database\Factories\DshProjectFactory;

class DshProject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['project_name', 'order_address', 'client_limit_date', 'afati_realizimit', 'priority', 'project_description', 'project_status', 'project_start_date','preventiv_status', 'project_client', 'project_architect', 'project_seller_id','arkitekt_confirm','user_id','rruga','qarku','bashkia','tipologjia_objektit','kate','lift','address_comment','orari_pritjes'];

    // protected static function newFactory(): DshProjectFactory
    // {
    //     // return DshProjectFactory::new();
    // }
}