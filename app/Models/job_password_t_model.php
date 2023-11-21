<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class job_password_t_model extends Model
{
    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'job_password_t';
    protected $primaryKey = 'job_password_id';

     /**
     * 更新を拒否するカラム
     *
     * @var array
     */
    protected $guarded = [
        'job_password_id',
    ];

    protected $fillable = [ 
        'product_type'
        ,'password'                   
        ,'usage_flg'
        ,'sold_flg'
        ,'date_range'
        ,'created_by'
        ,'updated_by'
        ,'deleted_by'
    ];
}
