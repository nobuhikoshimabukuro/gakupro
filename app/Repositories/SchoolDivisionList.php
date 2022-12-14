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
class SchoolDivisionList
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
        $maincategory_cd = 3;
        $gender_list = subcategory_m_model::select(
            'subcategory_cd as school_division_cd',
            'subcategory_name as school_division_name',
        )->where('maincategory_cd', $maincategory_cd)
        ->orderBy('display_order', 'asc')
        ->get();

        return $gender_list;
    }
}