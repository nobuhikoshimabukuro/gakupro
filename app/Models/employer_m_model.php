<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class employer_m_model extends Model
{
    use HasFactory;
    use SoftDeletes;

    //コネクション名を指定
    protected $connection = 'mysql';
    protected $table = 'employer_m';
    protected $primaryKey = 'id';

    protected $fillable = [
        'employer_id',
        'employer_name',
        'employer_name_kana',
        'post_code',
        'address1',
        'address2',
        'tel',
        'fax',
        'hp_url',
        'mailaddress'
    ];
}
