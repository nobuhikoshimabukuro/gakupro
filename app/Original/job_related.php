<?php

namespace App\Original;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Intervention\Image\Facades\Image;

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
    //求人写真情報取得
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


    //求人写真アップロード
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

                    // 拡張子取得
                    $extension = $job_image_input->getClientOriginalExtension();

                    // 画像のリサイズ
                    $resizedImage = Image::make($job_image_input)->resize(300, 200)->encode($extension);

                    Storage::disk('recruit_project_public_path')->put($job_image_folder_path, $resizedImage);
                }
            }
        }

        return $result;

    }


     //求人情報別給与情報
     public static function get_salary_info($info)
     {      
         
        $employer_id = $info->employer_id;
        $job_id = $info->job_id;
        $salary_info = $info->salary;          

        $salary_detail = employment_status_connection_t_model::select(
            'employment_status_connection_t.employer_id as employer_id',
            'employment_status_connection_t.job_id as job_id',
            'employment_status_connection_t.employment_status_id as employment_status_id',
            'employment_status_m.employment_status_name as employment_status_name',
            'employment_status_connection_t.salary_maincategory_cd as salary_maincategory_cd',
            'salary_maincategory_m.salary_maincategory_name as salary_maincategory_name',
            'employment_status_connection_t.salary_subcategory_cd as salary_subcategory_cd',
            'salary_subcategory_m.salary as salary',
            
        )
        ->leftJoin('employment_status_m', 'employment_status_connection_t.employment_status_id', '=', 'employment_status_m.employment_status_id')
        ->leftJoin('salary_maincategory_m', 'employment_status_connection_t.salary_maincategory_cd', '=', 'salary_maincategory_m.salary_maincategory_cd')
        ->leftJoin('salary_subcategory_m', 'employment_status_connection_t.salary_subcategory_cd', '=', 'salary_subcategory_m.salary_subcategory_cd')            
        ->where('employment_status_connection_t.employer_id', '=', $employer_id)
        ->where('employment_status_connection_t.job_id', '=', $job_id)
        ->orderBy('employment_status_m.display_order')
        ->get();


        $create_salary = "";
        
        foreach ($salary_detail as $salary_detail_index => $detail){

            $employment_status_name = $detail->employment_status_name;
            $salary_maincategory_name = $detail->salary_maincategory_name;
            $salary = $detail->salary;

            if($salary_detail_index != 0){
                $create_salary .= "\n";                
            }

            $create_salary .= "[" . $employment_status_name . "]" . $salary_maincategory_name . ":" . number_format($salary) . "円以上";
                        
        }

        $return_salary_info = "";

        if($create_salary == ""){
            $return_salary_info = $salary_info;
        }else{
            $return_salary_info = $create_salary . "\n" . $salary_info;                
        }

             
         return $return_salary_info;
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

    //求人補足情報取得処理
    public static function get_job_supplement_category_datas($employer_id , $job_id)
    {   

        $job_supplement_category_datas = [];
       
        
        $set_job_supplement_category = job_supplement_connection_t_model::select(
            'job_supplement_connection_t.employer_id as employer_id',
            'job_supplement_connection_t.job_id as job_id',    
            'job_supplement_connection_t.job_supplement_subcategory_cd as job_supplement_subcategory_cd',
            'job_supplement_subcategory_m.job_supplement_subcategory_name as job_supplement_subcategory_name',
            'job_supplement_subcategory_m.job_supplement_maincategory_cd as job_supplement_maincategory_cd',
            'job_supplement_maincategory_m.job_supplement_maincategory_name as job_supplement_maincategory_name',
        )
        ->leftJoin('job_supplement_subcategory_m', 'job_supplement_connection_t.job_supplement_subcategory_cd', '=', 'job_supplement_subcategory_m.job_supplement_subcategory_cd')
        ->leftJoin('job_supplement_maincategory_m', 'job_supplement_subcategory_m.job_supplement_maincategory_cd', '=', 'job_supplement_maincategory_m.job_supplement_maincategory_cd')            
        ->whereNull('job_supplement_maincategory_m.deleted_at')
        ->whereNull('job_supplement_subcategory_m.deleted_at')
        ->where('job_supplement_connection_t.employer_id', '=', $employer_id)
        ->where('job_supplement_connection_t.job_id', '=', $job_id)   
        ->orderBy('job_supplement_maincategory_m.display_order')
        ->orderBy('job_supplement_subcategory_m.display_order')         
        ->get();
    
        foreach ($set_job_supplement_category as $index => $set_job_category_info){            
            $job_supplement_maincategory_cd = $set_job_category_info->job_supplement_maincategory_cd;
            $job_supplement_maincategory_name = $set_job_category_info->job_supplement_maincategory_name;
            $job_supplement_subcategory_cd = $set_job_category_info->job_supplement_subcategory_cd;
            $job_supplement_subcategory_name = $set_job_category_info->job_supplement_subcategory_name;
            
            $job_supplement_category_datas[] = [
                'job_supplement_maincategory_cd'=> $job_supplement_maincategory_cd 
                ,'job_supplement_maincategory_name'=> $job_supplement_maincategory_name
                ,'job_supplement_subcategory_cd'=> $job_supplement_subcategory_cd
                ,'job_supplement_subcategory_name'=> $job_supplement_subcategory_name
            ];
        }

        return $job_supplement_category_datas;
    }

    
    //職種情報取得処理
    public static function get_job_category_datas($employer_id , $job_id)
    {   

        $job_category_datas = [];
        
        $set_job_category = job_category_connection_t_model::select(
            'job_category_connection_t.employer_id as employer_id',
            'job_category_connection_t.job_id as job_id',    
            'job_maincategory_m.job_maincategory_cd as job_maincategory_cd',
            'job_maincategory_m.job_maincategory_name as job_maincategory_name',
            'job_category_connection_t.job_subcategory_cd as job_subcategory_cd',
            'job_subcategory_m.job_subcategory_name as job_subcategory_name',
        )
        ->leftJoin('job_subcategory_m', 'job_category_connection_t.job_subcategory_cd', '=', 'job_subcategory_m.job_subcategory_cd')
        ->leftJoin('job_maincategory_m', 'job_subcategory_m.job_maincategory_cd', '=', 'job_maincategory_m.job_maincategory_cd')            
        ->whereNull('job_maincategory_m.deleted_at')
        ->whereNull('job_subcategory_m.deleted_at')
        ->where('job_category_connection_t.employer_id', '=', $employer_id)
        ->where('job_category_connection_t.job_id', '=', $job_id)   
        ->orderBy('job_maincategory_m.display_order')
        ->orderBy('job_subcategory_m.display_order')         
        ->get();
    
        foreach ($set_job_category as $index => $set_job_category_info){            
            $job_maincategory_cd = $set_job_category_info->job_maincategory_cd;
            $job_maincategory_name = $set_job_category_info->job_maincategory_name;
            $job_subcategory_cd = $set_job_category_info->job_subcategory_cd;
            $job_subcategory_name = $set_job_category_info->job_subcategory_name;
            
            $job_category_datas[] = [
                'job_maincategory_cd'=> $job_maincategory_cd 
                , 'job_maincategory_name'=> $job_maincategory_name
                , 'job_subcategory_cd'=> $job_subcategory_cd
                , 'job_subcategory_name'=> $job_subcategory_name
            ];
        }

        return $job_category_datas;
    }
    
}

