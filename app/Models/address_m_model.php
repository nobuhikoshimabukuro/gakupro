<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class address_m_model extends Model
{
    use HasFactory;
    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'address_m';
    protected $primaryKey = ["prefectural_cd" , "prefectural_name"];

    protected $fillable = [
        'prefectural_cd',
        'prefectural_name',
        'prefectural_name_kana',
        'municipality_cd',
        'municipality_name',
        'municipality_name_kana',     
    ];
}
