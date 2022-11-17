<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class school_m_model extends Model
{
    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'school_m';
    protected $primaryKey = 'school_cd';
 
    /**
     * 更新を拒否するカラム
    *
    * @var array
    */
    protected $guarded = [
        'school_cd',
    ];
}
