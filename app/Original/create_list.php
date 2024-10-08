<?php

namespace App\Original;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Original\common;

use App\Models\maincategory_m_model;
use App\Models\subcategory_m_model;
use App\Models\staff_m_model;
use App\Models\address_m_model;
use App\Models\job_maincategory_m_model;
use App\Models\salary_maincategory_m_model;
use App\Models\salary_subcategory_m_model;
use App\Models\job_supplement_maincategory_m_model;
use App\Models\job_supplement_subcategory_m_model;
use App\Models\job_password_item_m_model;

class create_list
{      


    //大分類コンボボックス
    public static function maincategory_list()
    {      
        $maincategory_list = maincategory_m_model::select(
            'maincategory_cd as maincategory_cd',
            'maincategory_name as maincategory_name',
        )
        ->orderBy('display_order', 'asc')
        ->get();

        return $maincategory_list;
    }

   
    
     
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

    //市町村コンボボックス
    public static function municipality_list($prefectural_cd)
    {      
      
        $municipality_list = address_m_model::select(
            'prefectural_cd as prefectural_cd',
            'prefectural_name as prefectural_name',
            'prefectural_name_kana as prefectural_name_kana',

            'municipality_cd as municipality_cd',
            'municipality_name as municipality_name',
            'municipality_name_kana as municipality_name_kana',
        )
        ->where('prefectural_cd', '=', $prefectural_cd)
        ->orderBy('municipality_cd', 'asc')       
        ->get();

        return $municipality_list;
    }

    //求人補足大分類コンボボックス
    public static function job_supplement_maincategory_list()
    {   

        $job_supplement_maincategory_list = job_supplement_maincategory_m_model::select(
            'job_supplement_maincategory_cd as job_supplement_maincategory_cd',
            'job_supplement_maincategory_name as job_supplement_maincategory_name',
        )
        ->orderBy('display_order', 'asc')
        ->get();

        return $job_supplement_maincategory_list;

        
    }


    //給与大分類コンボボックス
    public static function salary_maincategory_list()
    {      
        $salary_maincategory_list = salary_maincategory_m_model::select(
            'salary_maincategory_cd as salary_maincategory_cd',
            'salary_maincategory_name as salary_maincategory_name',
        )
        ->orderBy('display_order', 'asc')
        ->get();

        return $salary_maincategory_list;        
    }

    //給与中分類コンボボックス
    public static function salary_subcategory_list()
    {       
        $salary_subcategory_list = salary_subcategory_m_model::select(
            'salary_subcategory_cd as salary_subcategory_cd',
            'salary_maincategory_cd as salary_maincategory_cd',            
            'salary as salary',
        )
        ->orderBy('display_order', 'asc')
        ->get();

        return $salary_subcategory_list;        
    }


    //スタッフコンボボックス
    public static function staff_list()
    {   

        $staff_list = staff_m_model::select(
            'staff_id as staff_id',
            'staff_last_name as staff_last_name',
            'staff_first_name as staff_first_name',
            'staff_last_name_yomi as staff_last_name_yomi',
            'staff_first_name_yomi as staff_first_name_yomi',
            DB::raw('CONCAT(staff_last_name, " ", staff_first_name) as staff_full_name'),
            DB::raw('CONCAT(staff_last_name_yomi, " ", staff_first_name_yomi) as staff_full_name_yomi'),
            
        )
        ->orderBy('staff_id', 'asc')
        ->get();

        return $staff_list;        
    }

    //求人公開パスワード商品一覧
    public static function job_password_item_list()
    {   

        $today = common::get_date(1);

        $job_password_item_list = job_password_item_m_model::select(
            'job_password_item_id as job_password_item_id',
            'job_password_item_name as job_password_item_name',
            'sales_start_date as sales_start_date',
            'sales_end_date as sales_end_date',
        )
        ->orderBy('job_password_item_id', 'asc')
        ->get();

        foreach ($job_password_item_list as $job_password_item_info){

            $sales_start_date = $job_password_item_info->sales_start_date;
            $sales_end_date = $job_password_item_info->sales_end_date;

            $sale_flg = 0;

            //販売期間内かチェック
            if($today >= $sales_start_date && $today <= $sales_end_date){
                $sale_flg = 1;
            }

            $job_password_item_info->sale_flg = $sale_flg;
          
        }

        return $job_password_item_list;        
    }

    //職種大分類コンボボックス
    public static function job_maincategory_list()
    {   

        $job_maincategory_list = job_maincategory_m_model::select(
            'job_maincategory_cd as job_maincategory_cd',
            'job_maincategory_name as job_maincategory_name',
        )
        ->orderBy('display_order', 'asc')
        ->get();

        return $job_maincategory_list;        
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
 



    //給与中分類コンボボックス
    //ajaxからget処理のみで呼ばれる処理
    public static function salary_sabcategory_list_ajax(Request $request)
    {      
      
        $salary_sabcategory_list = array();        
        $salary_maincategory_cd = $request->salary_maincategory_cd;
        

        $salary_subcategory_m_model = salary_subcategory_m_model::select(
            'salary_subcategory_cd as salary_subcategory_cd',
            'salary_maincategory_cd as salary_maincategory_cd',
            'display_order as display_order',
            'salary as salary',
        )
        ->orderBy('display_order', 'asc')
        ->where('salary_maincategory_cd', '=', $salary_maincategory_cd)
        ->get();
              

        if(count($salary_subcategory_m_model) > 0) {

            foreach($salary_subcategory_m_model as $info){

                $salary_sabcategory_list[] = array(
                    'salary_subcategory_cd' => $info->salary_subcategory_cd,
                    'salary_maincategory_cd' => $info->salary_maincategory_cd,
                    'salary' => number_format($info->salary) ,            
                    'salary_display' => number_format($info->salary) . "円以上",
                );
            }

        }

        return response()->json(['salary_sabcategory_list' => $salary_sabcategory_list]);        
    }


    
}

