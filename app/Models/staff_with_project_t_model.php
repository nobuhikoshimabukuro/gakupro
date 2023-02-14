<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class staff_with_project_t_model extends Model
{

    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'staff_with_project_t';
    

    protected $fillable = [ 
        'staff_id'
        ,'project_id'                
        ,'created_at'
        ,'created_by'
        ,'updated_at'
        ,'updated_by'
        ,'deleted_at'
        ,'deleted_by'
    ];
}
