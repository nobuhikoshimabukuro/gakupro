<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class salary_subcategory_m_model extends Model
{
    use SoftDeletes;
    
    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'salary_subcategory_m';
    protected $primaryKey = 'salary_subcategory_cd';

     /**
     * 更新を拒否するカラム
     *
     * @var array
     */
    protected $guarded = [
        'salary_subcategory_cd',
    ];
}
