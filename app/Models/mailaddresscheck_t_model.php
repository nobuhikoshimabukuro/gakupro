<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mailaddress_check_t_model extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'mailaddress_check_t';
    protected $primaryKey = 'id';



    protected $fillable = [
        'key_code',
        'cipher',
        'password',
        'mailaddress',
        'check_count',     
        
    ];


}
