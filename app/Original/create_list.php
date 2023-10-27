<?php

namespace App\Original;
use Exception;
use Illuminate\Http\Request;

use App\Original\common;

use App\Models\subcategory_m_model;
use App\Models\address_m_model;


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


    //都道府県コンボボックス
    public static function prefectural_list()
    {      
      
        $prefectural_list = address_m_model::select(
            'prefectural_cd as prefectural_cd',
            'prefectural_name as prefectural_name',
            'prefectural_name_kana as prefectural_name_kana',
        )
        ->orderBy('prefectural_cd', 'asc')
        ->groupBy(
            'prefectural_cd',
            'prefectural_name',
            'prefectural_name_kana',
        )
        ->get();

        return $prefectural_list;
    }

    //都道府県コンボボックス
    public static function prefectural_list_ajax(Request $request)
    {      
      
        $prefectural_list = array();      
        $prefectural_name = $request->prefectural_name;

        $address_m_model = address_m_model::select(
            'prefectural_cd as prefectural_cd',
            'prefectural_name as prefectural_name',
            'prefectural_name_kana as prefectural_name_kana',
        )
        ->orderBy('prefectural_cd', 'asc')
        ->groupBy(
            'prefectural_cd',
            'prefectural_name',
            'prefectural_name_kana',
        )
        ->where('prefectural_name', 'LIKE', "%$prefectural_name%")
        ->get();

        if(count($address_m_model) > 0) {

            foreach($address_m_model as $info){

                $municipality_list[] = array(
                    'prefectural_cd' => $info->prefectural_cd,
                    'prefectural_name' => $info->prefectural_name,
                    'prefectural_name_kana' => $info->prefectural_name_kana            
                );
            }

        }

        return response()->json(['prefectural_list' => $prefectural_list]);      
    }


    //市区町村コンボボックス
    //ajaxからget処理のみで呼ばれる処理
    public static function municipality_list_ajax(Request $request)
    {      
      
        $municipality_list = array();        
        $prefectural_cd = $request->prefectural_cd;
        $municipality_name = $request->municipality_name;

        $address_m_model = address_m_model::select(
            'municipality_cd as municipality_cd',
            'municipality_name as municipality_name',
            'municipality_name_kana as municipality_name_kana',
        )
        ->orderBy('municipality_cd', 'asc')
        ->where('prefectural_cd', '=', $prefectural_cd);        

        if($municipality_name != ""){

            if(common::is_hiragana_or_katakana($municipality_name)){                

                //全文字がひらなが、またはカタカナ
                //全文字全角カタカナに変換
                $municipality_name_kana = mb_convert_kana($municipality_name, 'KHC');

                $address_m_model = $address_m_model->where(function ($query) use ($municipality_name,$municipality_name_kana) {
                    $query->where('municipality_name', 'LIKE', "%$municipality_name%")
                        ->orWhere('municipality_name_kana', 'LIKE', "%$municipality_name_kana%");
                });
                                
            }else{

                $address_m_model = $address_m_model->where(function ($query) use ($municipality_name) {
                    $query->where('prefectural_name', 'LIKE', "%$municipality_name%")
                        ->orWhere('prefectural_name_kana', 'LIKE', "%$municipality_name%");
                });
            }
        }

        $address_m_model = $address_m_model->get();

        if(count($address_m_model) > 0) {

            foreach($address_m_model as $info){

                $municipality_list[] = array(
                    'municipality_cd' => $info->municipality_cd,
                    'municipality_name' => $info->municipality_name,
                    'municipality_name_kana' => $info->municipality_name_kana            
                );
            }

        }

        return response()->json(['municipality_list' => $municipality_list]);        
    }
 

}

