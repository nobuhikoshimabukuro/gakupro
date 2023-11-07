<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class job_maincategory_m_model extends Model
{
    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'job_maincategory_m';
    protected $primaryKey = 'job_maincategory_cd';

     /**
     * 更新を拒否するカラム
     *
     * @var array
     */
    protected $guarded = [
        'job_maincategory_cd',
    ];
}
