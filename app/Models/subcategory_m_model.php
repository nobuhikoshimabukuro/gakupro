<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class subcategory_m_model extends Model
{
    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'subcategory_m';

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
        'maincategory_cd'
        ,'subcategory_cd'        
        ,'subcategory_name'
        ,'display_order'
        ,'created_at'
        ,'created_by'
        ,'updated_at'
        ,'updated_by'
        ,'deleted_at'
        ,'deleted_by'
    ];
}
