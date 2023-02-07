<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class majorsubject_m_model extends Model
{
    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'majorsubject_m';
    protected $primaryKey = 'id';
 
    /**
     * 更新を拒否するカラム
    *
    * @var array
    */
    protected $guarded = [
        'school_cd'
        ,'majorsubject_cd'  
    ];

    protected $fillable = [ 
        'school_cd'
        ,'majorsubject_cd'        
        ,'majorsubject_name'
        ,'studyperiod'
        ,'remarks'
        ,'created_at'
        ,'created_by'
        ,'updated_at'
        ,'updated_by'
        ,'deleted_at'
        ,'deleted_by'
    ];
}
