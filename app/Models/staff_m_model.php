<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class staff_m_model extends Model
{

    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'staff_m';
    protected $primaryKey = 'staff_id';

     /**
     * 更新を拒否するカラム
     *
     * @var array
     */
    protected $guarded = [
        'staff_id',
    ];
}
