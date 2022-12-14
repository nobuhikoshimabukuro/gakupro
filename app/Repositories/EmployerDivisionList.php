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
class EmployerDivisionList
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
        $maincategory_cd = 4;
        $employer_division_list = subcategory_m_model::select(
            'subcategory_cd as employer_division',
            'subcategory_name as employer_division_name',
        )->where('maincategory_cd', $maincategory_cd)
        ->orderBy('display_order', 'asc')
        ->get();

        return $employer_division_list;
    }
}