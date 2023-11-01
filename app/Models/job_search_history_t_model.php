<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class job_search_history_t_model extends Model
{
    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'job_search_history_t';

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
        'job_supplement_subcategory_cd'
        ,'search_date'                   
        ,'created_at'
        ,'created_by'
        ,'updated_at'
        ,'updated_by'
        ,'deleted_at'
        ,'deleted_by'
    ];
}
