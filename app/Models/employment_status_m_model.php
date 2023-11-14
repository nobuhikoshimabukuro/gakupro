<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class employment_status_m_model extends Model
{
    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'employment_status_m';
    protected $primaryKey = 'employment_status_id';



    protected $fillable = [
        'employment_status_name',        
    ];
}
