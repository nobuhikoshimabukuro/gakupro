<?php

namespace App\Repositories;

use App\Models\staff_m_model;
use App\Models\subcategory_m_model;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;

/**
 *
 * 
 */
class AuthorityList
{
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {        
    }

    /**
     * データの取得
     * 
     */
    public static function get()
    {
        $maincategory_cd = 2;
        $authority_list = subcategory_m_model::select(
            'subcategory_cd as authority_cd',
            'subcategory_name as authority_name',
        )->where('maincategory_cd',$maincategory_cd)
        ->orderBy('display_order', 'asc')
        ->get();

        return $authority_list;
    }
}