<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class photoget_t_model extends Model
{
    use HasFactory;
    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'photoget_t';
    protected $primaryKey = 'id';

     /**
     * 更新を拒否するカラム
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];
}
