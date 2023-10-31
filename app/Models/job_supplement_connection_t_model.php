<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class job_supplement_connection_t_model extends Model
{
    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'job_supplement_connection_t';

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
        ,'job_supplement_subcategory_cd'       
        ,'created_at'
        ,'created_by'
        ,'updated_at'
        ,'updated_by'
        ,'deleted_at'
        ,'deleted_by'
    ];
}
