<?php

namespace App\Original;
use Exception;
use App\Models\subcategory_m_model;


class create_list
{      
    //性別コンボボックス
    public static function gender_list()
    {      
        $gender_list = subcategory_m_model::select(
            'subcategory_cd as gender_cd',
            'subcategory_name as gender_name',
        )->where('maincategory_cd', env('gender_subcategory_cd'))
        ->orderBy('display_order', 'asc')
        ->get();

        return $gender_list;
    }

    //権限コンボボックス
    public static function authority_list()
    {      
        $authority_list = subcategory_m_model::select(
            'subcategory_cd as authority_cd',
            'subcategory_name as authority_name',
        )->where('maincategory_cd', env('authority_subcategory_cd'))
        ->orderBy('display_order', 'asc')
        ->get();

        return $authority_list;
    }

    //学校区分コンボボックス
    public static function school_division_list()
    {      
        $school_division_list = subcategory_m_model::select(
            'subcategory_cd as school_division_cd',
            'subcategory_name as school_division_name',
        )->where('maincategory_cd', env('school_division_subcategory_cd'))
        ->orderBy('display_order', 'asc')
        ->get();

        return $school_division_list;
    }

    //雇用者区分コンボボックス
    public static function employer_division_list()
    {      
        $employer_division_list = subcategory_m_model::select(
            'subcategory_cd as employer_division_cd',
            'subcategory_name as employer_division_name',
        )->where('maincategory_cd', env('employer_division_subcategory_cd'))
        ->orderBy('display_order', 'asc')
        ->get();

        return $employer_division_list;
    }
 

}

