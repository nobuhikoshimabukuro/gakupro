<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class member_password_t_model extends Model
{
    use HasFactory;
    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'member_password_t';
    protected $primaryKey = 'id';



    protected $fillable = [        
        'member_id',
        'login_id',
        'password',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
