<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class job_password_connection_t_model extends Model
{
    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'job_password_connection_t';

    // protected $primaryKey = [
    //     'maincategory_cd'
    //     ,'subcategory_cd'  
    // ];

     /**
     * 更新を拒否するカラム
     *
     * @var array
     */
    // protected $guarded = [
    //     'maincategory_cd'
    //     ,'subcategory_cd'  
    // ];


    protected $fillable = [ 
        'employer_id'
        ,'job_id'        
        ,'branch_number'       
        ,'job_password_id'       
        ,'publish_start_date'     
        ,'publish_end_date'     
        ,'created_at'
        ,'created_by'
        ,'updated_at'
        ,'updated_by'
        ,'deleted_at'
        ,'deleted_by'
    ];
}
