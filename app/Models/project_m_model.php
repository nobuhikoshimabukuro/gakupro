<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class project_m_model extends Model
{
    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'project_m';
    protected $primaryKey = 'project_id';

     /**
     * 更新を拒否するカラム
     *
     * @var array
     */
    protected $guarded = [
        'project_id',
    ];
    
}
