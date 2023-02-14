<?php

namespace App\Original;
use App\Http\Controllers\Controller;

use App\Models\member_m_model;
use App\Models\member_password_t_model;
use App\Models\subcategory_m_model;
use App\Models\school_m_model;
use App\Models\majorsubject_m_model;

use App\Http\Requests\member_m_request;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Original\common;
use App\Original\create_list;
use App\Repositories\gender_list;
use App\Repositories\authority_list;
use Illuminate\Support\Facades\DB;

class get_data
{      
    //学校検索処理  学校区分選択時のプルダウン絞り込みのため
    function school_list_get(Request $request)
    {
        $search_school_division = $request->search_school_division;

        $search_school_list = school_m_model::select(
            
            'school_m.school_cd as school_cd',
            'school_m.school_name as school_name',
            'school_m.school_division as school_division',
            
        )        
        ->orderBy('school_m.school_cd', 'asc')                  
        ->where('school_m.school_division', '=', $search_school_division)
        ->get();


        if(count($search_school_list) == 0){

            $message = "学校情報なし";
            $ResultArray = array(
                "status" => "nodata",
                "message" => $message
            );

        }else  if(count($search_school_list) > 0){


            $school_list = array();

            foreach($search_school_list as $info){

                $info_array = array(
                    "school_cd" => $info->school_cd,
                    "school_name" => $info->school_name                  
                );

                array_push($school_list, $info_array);


            }

            $ResultArray = array(
                "status" => "success",
                "school_list" =>  $school_list
            );


        }

        return response()->json(['ResultArray' => $ResultArray]);

    }


    //学校別専攻検索処理    学校選択時のプルダウン絞り込みのため
    function majorsubject_list_get(Request $request)
    {

        $search_school_cd = $request->search_school_cd;

        $search_majorsubject_list = majorsubject_m_model::select(
            'majorsubject_m.school_cd as school_cd',
            'school_m.school_name as school_name',
            'school_m.school_division as school_division',
            'majorsubject_m.majorsubject_cd as majorsubject_cd',
            'majorsubject_m.majorsubject_name as majorsubject_name',
            'majorsubject_m.studyperiod as studyperiod',
            'majorsubject_m.deleted_at as deleted_at',
        )
        ->leftJoin('school_m', function ($join) {
            $join->on('school_m.school_cd', '=', 'majorsubject_m.school_cd');            
        })        
        ->orderBy('majorsubject_m.school_cd', 'asc')          
        ->orderBy('majorsubject_m.majorsubject_cd', 'asc') 
        ->where('majorsubject_m.school_cd', '=', $search_school_cd)
        ->get();


        if(count($search_majorsubject_list) == 0){

            $message = "専攻情報なし";
            $ResultArray = array(
                "status" => "nodata",
                "message" => $message
            );

        }else  if(count($search_majorsubject_list) > 0){


            $majorsubject_list = array();

            foreach($search_majorsubject_list as $info){

                $info_array = array(
                    "majorsubject_cd" => $info->majorsubject_cd,
                    "majorsubject_name" => $info->majorsubject_name,                  
                    "studyperiod" => $info->studyperiod,
                );

                array_push($majorsubject_list, $info_array);


            }

            $ResultArray = array(
                "status" => "success",
                "majorsubject_list" =>  $majorsubject_list
            );


        }

        return response()->json(['ResultArray' => $ResultArray]);

    }

    function school_info_get(Request $request){

        try {

            $search_school_cd = $request->search_school_cd;

            $get_school_info = school_m_model::select(

                'school_m.school_cd as school_cd',
                'school_m.school_division as school_division',
                'school_division_info.subcategory_name as school_division_name',
                'school_m.school_name as school_name',
                'school_m.post_code as post_code',
                'school_m.address1 as address1',
                'school_m.address2 as address2',
                'school_m.tel as tel',
                'school_m.fax as fax',
                'school_m.hp_url as hp_url',
                'school_m.mailaddress as mailaddress',
                'school_m.remarks as remarks',
                
                'school_m.deleted_at as deleted_at',
            )
            ->leftJoin('subcategory_m as school_division_info', function ($join) {
                $join->on('school_division_info.subcategory_cd', '=', 'school_m.school_division')
                    ->where('school_division_info.maincategory_cd', '=', env('school_division_subcategory_cd'));
            })        
            ->orderBy('school_m.school_cd', 'asc') 
            ->where('school_m.school_cd', '=', $search_school_cd)
            ->withTrashed()
            ->first();


            if(is_null($get_school_info)){

                $message = "学校情報なし";
                $ResultArray = array(
                    "status" => "nodata",
                    "message" => $message
                );

            }else{

                $school_info = array(
                    "school_cd" => $get_school_info->school_cd,
                    "school_division_name" => $get_school_info->school_division_name,
                    "school_name" => $get_school_info->school_name,
                    "post_code" => $get_school_info->post_code,
                    "address1" => $get_school_info->address1,
                    "address2" => $get_school_info->address2,
                    "tel" => $get_school_info->tel,
                    "fax" => $get_school_info->fax,
                    "hp_url" => $get_school_info->hp_url,
                    "mailaddress" => $get_school_info->mailaddress,
                    "remarks" => $get_school_info->remarks
                );

                $ResultArray = array(
                    "status" => "success",
                    "school_info" =>  $school_info
                );


            }

        } catch (Exception $e) {

            $ErrorMessage = '【学校情報データ取得エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

            $message = "データ取得エラー";
            $ResultArray = array(
                "status" => "error",
                "message" => $message
            );

        }
        

        return response()->json(['ResultArray' => $ResultArray]);

    }
    

    
    
    function majorsubject_info_get(Request $request){

        try {

            $search_school_cd = $request->search_school_cd;
            $search_majorsubject_cd = $request->search_majorsubject_cd;

            $get_majorsubject_info = majorsubject_m_model::select(

                'majorsubject_m.school_cd as school_cd',
                'school_m.school_name as school_name',
                'majorsubject_m.majorsubject_cd as majorsubject_cd',
                'majorsubject_m.majorsubject_name as majorsubject_name',
                'majorsubject_m.studyperiod as studyperiod',
                'majorsubject_m.remarks as remarks',            
                'majorsubject_m.deleted_at as deleted_at',
            )
            ->leftJoin('school_m', function ($join) {
                $join->on('school_m.school_cd', '=', 'majorsubject_m.school_cd');            
            })        
            ->where('majorsubject_m.school_cd', '=', $search_school_cd)
            ->where('majorsubject_m.majorsubject_cd', '=', $search_majorsubject_cd)
            ->withTrashed()
            ->first();
            

            

            if(is_null($get_majorsubject_info)){

                $message = "学校別専攻情報なし";
                $ResultArray = array(
                    "status" => "nodata",
                    "message" => $message
                );

            }else{

                $majorsubject_info = array(
                    "school_cd" => $get_majorsubject_info->school_cd,
                    "school_name" => $get_majorsubject_info->school_name,
                    "majorsubject_cd" => $get_majorsubject_info->majorsubject_cd,
                    "majorsubject_name" => $get_majorsubject_info->majorsubject_name,
                    "studyperiod" => $get_majorsubject_info->studyperiod,                
                    "remarks" => $get_majorsubject_info->remarks
                );

                $ResultArray = array(
                    "status" => "success",
                    "majorsubject_info" =>  $majorsubject_info
                );


            }


        } catch (Exception $e) {

            $ErrorMessage = '【学校別専攻情報データ取得エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

            $message = "データ取得エラー";
            $ResultArray = array(
                "status" => "error",
                "message" => $message
            );

        }
        

        return response()->json(['ResultArray' => $ResultArray]);

    }
 

}

