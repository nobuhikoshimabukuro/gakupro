<?php

namespace App\Original;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\member_m_model;
use App\Models\member_password_t_model;
use App\Models\subcategory_m_model;
use App\Models\school_m_model;
use App\Models\majorsubject_m_model;

use Carbon\Carbon;
use App\Http\Requests\member_m_request;

use Exception;
use Illuminate\Support\Facades\Log;

use App\Original\common;
use App\Original\create_list;
use App\Repositories\gender_list;
use App\Repositories\authority_list;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

use App\Models\employer_m_model;
use App\Models\employer_password_t_model;
use App\Models\job_information_t_model;
use App\Models\mailaddress_check_t_model;

use App\Models\salary_maincategory_m_model;
use App\Models\salary_subcategory_m_model;

use App\Models\employment_status_connection_t_model;
use App\Models\employment_status_m_model;

use App\Models\job_maincategory_m_model;
use App\Models\job_subcategory_m_model;
use App\Models\job_category_connection_t_model;

use App\Models\job_supplement_maincategory_m_model;
use App\Models\job_supplement_subcategory_m_model;
use App\Models\job_supplement_connection_t_model;

use App\Models\job_search_history_t_model;

class job_related
{      
    public static function get_job_images($employer_id,$job_id)
    {      
        $job_images_path_array = [];
        $job_image_path_array = [];       

        $job_image_count = 0;
      
        //既存の求人情報編集時            
        $job_info = job_information_t_model::
        where('employer_id', '=', $employer_id)
        ->where('job_id', '=', $job_id)            
        ->first();


        if(is_null($job_info)){

            for ($i = 1; $i <= 3; $i++) {
                        
                $asset_path = "";
                $image_name = "";
                $job_image_info = ["folder_index" => $i , "asset_path" => $asset_path , "image_name" => $image_name];
                $job_image_path_array[] = $job_image_info;            
            }

        }else{

            $job_image_folder_name = $job_info->job_image_folder_name;
            $id = $job_info->id;                        

            for ($i = 1; $i <= 3; $i++) {
                        
                $asset_path = "";
                $image_name = "";
                $check_job_image_folder_path = "public/recruit_project/job_image/id_" . $id . "/" . $job_image_folder_name . "/" . $i;

                if (Storage::exists($check_job_image_folder_path)){

                    //フォルダの確認が出来たら、フォルダ内のファイル名を全て取得            
                    $files = Storage::files($check_job_image_folder_path);

                    if(count($files) > 0){

                        $job_image_count = $job_image_count + 1;
                        $file = $files[0];
                        $image_info = pathinfo($file);
                        $image_name = $image_info['basename']; // ファイル名のみ取得
                        $asset_path = asset("storage/recruit_project/job_image/id_" . $id . "/". $job_image_folder_name . "/" . $i . "/" . $image_name);                   
                    }                      
                }

                $job_image_info = ["folder_index" => $i , "asset_path" => $asset_path , "image_name" => $image_name];
                $job_image_path_array[] = $job_image_info;            
            }
        }
        
           

        $no_image_asset_path = asset('img/no_image/no_image.jpeg');

        $job_images_path_array = ["job_image_count" => $job_image_count ,"no_image_asset_path" => $no_image_asset_path , "job_image_path_array" => $job_image_path_array];
            
        return $job_images_path_array;
    }

    public static function update_job_images(Request $request , $employer_id , $job_id)
    {           
        $result = true;

        //この処理が実行されつタイミングではデータが絶対あるべき
        $job_information_t = job_information_t_model::
            where('employer_id', '=', $employer_id)
            ->where('job_id', '=', $job_id)
            ->first();

        if(is_null($job_information_t)){
            //異常
            return false;

        }else{
            $id = $job_information_t->id;
            $job_image_folder_name = $job_information_t->job_image_folder_name;
        }


        for ($i = 1; $i <= 3; $i++) {

            $target_image_input_name = "job_image_input" . $i;
            $job_image_input = $request->file($target_image_input_name);

            $target_image_change_flg_name = "job_image_change_flg" . $i;
            $job_image_change_flg = $request->$target_image_change_flg_name;

            if($job_image_change_flg == 1){

                $job_image_folder_path = "job_image/id_" . $id . "/" . $job_image_folder_name . "/" . $i;                

                Storage::disk('recruit_project_public_path')->deleteDirectory($job_image_folder_path);                
                Storage::disk('recruit_project_public_path')->makeDirectory($job_image_folder_path);
                

                if(!is_null($job_image_input)){
                    Storage::disk('recruit_project_public_path')->put($job_image_folder_path, $job_image_input);
                }
            }
        }

        return $result;

    }

    //求人検索履歴ランキング
    public static function get_job_search_history_ranking()
    {           
 
        $return_array = [];        

        $now = Carbon::now();

        $start_date = $now;
        $start_date = $start_date->format("Y-m-d");

        $info_array[]= ["3", "3日間"];
        $info_array[]= ["7", "1週間"];
        $info_array[]= ["30", "1ヵ月"];

        foreach($info_array as $index => $info){

            $now = Carbon::now();            
            
            $end_date = $now->subDays($info[0])->format("Y-m-d");

            $job_search_history_t = job_search_history_t_model::select(
            
                'job_search_history_t.job_supplement_subcategory_cd as job_supplement_subcategory_cd',
                'job_supplement_subcategory_m.job_supplement_subcategory_name as job_supplement_subcategory_name',
                DB::raw('COUNT(*) as count')
                
            )
            ->leftJoin('job_supplement_subcategory_m', function ($join) {
                $join->on('job_search_history_t.job_supplement_subcategory_cd', '=', 'job_supplement_subcategory_m.job_supplement_subcategory_cd');
            })
            ->whereBetween('job_search_history_t.search_date', [$start_date, $end_date])       
            ->groupBy('job_search_history_t.job_supplement_subcategory_cd', 'job_supplement_subcategory_m.job_supplement_subcategory_name')            
            ->orderByDesc('count')
            ->limit(3)
            ->get();            

            if(!is_null($job_search_history_t)){
                $return_array[]= ["job_search_history_t" => $job_search_history_t , "title" => $info[1]];
            }
        }

        return $return_array;
 
    }

    //求人検索履歴ランキング
    public static function get_job_search_history_ranking_______(Request $request)
    {           

        // 現在の日時を取得
        $now = Carbon::now();
  
        
        // 三日前の日付
        $three_days_Ago = $now;
        $three_days_Ago = $three_days_Ago->subDays(3);
        
        // 一週間前の日付
        $one_week_ago = $now;
        $one_week_ago = $one_week_ago->subWeek();
        
        // 一か月前の日付
        $one_month_ago = $now;
        $one_month_ago = $one_month_ago->subMonth();


        $today = $now->toDateString();
        $three_days_Ago = $three_days_Ago->toDateString();
        $one_week_ago = $one_week_ago->toDateString();
        $one_month_ago = $one_month_ago->toDateString();

        $three_days_result = job_search_history_t_model::select(
                
            'job_search_history_t.job_supplement_subcategory_cd as job_supplement_subcategory_cd',
            'job_supplement_subcategory_m.job_supplement_subcategory_name as job_supplement_subcategory_name',
            'job_search_history_t.search_date as search_date',
          
        )
        ->leftJoin('job_supplement_subcategory_m', function ($join) {
            $join->on('job_supplement_subcategory_m.job_supplement_subcategory_cd', '=', 'job_supplement_subcategory_m.job_supplement_subcategory_cd');
        })        
        ->where('job_search_history_t.search_date', '<=', $today)
        ->where('job_search_history_t.search_date', '>=', $three_days_Ago)        
        ->groupBy('job_search_history_t.job_supplement_subcategory_cd')
        ->groupBy('job_supplement_subcategory_m.job_supplement_subcategory_name')
        ->get();


        $one_week_result = job_search_history_t_model::select(
                
            'job_search_history_t.job_supplement_subcategory_cd as job_supplement_subcategory_cd',
            'job_supplement_subcategory_m.job_supplement_subcategory_name as job_supplement_subcategory_name',
            'job_search_history_t.search_date as search_date',
          
        )
        ->leftJoin('job_supplement_subcategory_m', function ($join) {
            $join->on('job_supplement_subcategory_m.job_supplement_subcategory_cd', '=', 'job_supplement_subcategory_m.job_supplement_subcategory_cd');
        })        
        ->where('job_search_history_t.search_date', '<=', $today)
        ->where('job_search_history_t.search_date', '>=', $one_week_ago)        
        ->groupBy('job_search_history_t.job_supplement_subcategory_cd')
        ->groupBy('job_supplement_subcategory_m.job_supplement_subcategory_name')
        ->get();

        $one_month_result = job_search_history_t_model::select(
                
            'job_search_history_t.job_supplement_subcategory_cd as job_supplement_subcategory_cd',
            'job_supplement_subcategory_m.job_supplement_subcategory_name as job_supplement_subcategory_name',
            'job_search_history_t.search_date as search_date',
          
        )
        ->leftJoin('job_supplement_subcategory_m', function ($join) {
            $join->on('job_supplement_subcategory_m.job_supplement_subcategory_cd', '=', 'job_supplement_subcategory_m.job_supplement_subcategory_cd');
        })        
        ->where('job_search_history_t.search_date', '<=', $today)
        ->where('job_search_history_t.search_date', '>=', $one_month_ago) 
        ->groupBy('job_search_history_t.job_supplement_subcategory_cd')
        ->groupBy('job_supplement_subcategory_m.job_supplement_subcategory_name')       
        ->get();


        

        $job_search_history_ranking = [
            "three_days_result" => $three_days_result 
            ,"one_week_result" => $one_week_result 
            , "one_month_result" => $one_month_result
        ];
        

        return $job_search_history_ranking;

    }
    
}

