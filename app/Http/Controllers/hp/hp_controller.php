<?php

// Log::channel('info_log')->info($process_title . "");
// Log::channel('send_mail_log')->info($process_title . "");
// Log::channel('important_log')->info($process_title . "");
// Log::channel('error_log')->info($process_title . "");
// Log::channel('emergency_log')->info($process_title . "");
// Log::channel('database_backup_log')->info($process_title . "");

namespace App\Http\Controllers\hp;
use App\Http\Controllers\Controller;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Original\common;
use App\Original\create_list;
use App\Original\get_data;

use App\Models\job_information_t_model;
use App\Models\job_subcategory_m_model;
use App\Models\job_supplement_maincategory_m_model;
use App\Models\job_supplement_subcategory_m_model;
use App\Models\job_supplement_connection_t_model;
use App\Models\job_search_history_t_model;


class hp_controller extends Controller
{

    function index(Request $request)
    {    
        return view('hp/screen/index');
    }

    function job_information(Request $request)
    {

        $search_prefectural_cd = "";
        $search_municipality_cd_array = [];
        $search_job_category_array = [];
        $search_job_supplement_array = [];
        

        if(session()->has('all_job_search_value_array')) {

            $all_job_search_value_array = session()->get('all_job_search_value_array');
            session()->remove('all_job_search_value_array');
            $job_information = $this->search_job_information($all_job_search_value_array);

            $prefectural_cd_search_value_array = $all_job_search_value_array["prefectural_cd_search_value_array"];
            $municipality_cd_search_value_array = $all_job_search_value_array["municipality_cd_search_value_array"];
            $job_category_search_value_array = $all_job_search_value_array["job_category_search_value_array"];
            $job_supplement_search_value_array = $all_job_search_value_array["job_supplement_search_value_array"];


            if($prefectural_cd_search_value_array["existence_data"] == 1) {
                $search_prefectural_cd = $prefectural_cd_search_value_array["prefectural_cd"];
            }

            if($municipality_cd_search_value_array["existence_data"] == 1) {
                $search_municipality_cd_array = $municipality_cd_search_value_array["value_array"];
            }

            if($job_category_search_value_array["existence_data"] == 1) {
                $search_job_category_array = $job_category_search_value_array["value_array"];
            }

            if($job_supplement_search_value_array["existence_data"] == 1) {
                $search_job_supplement_array = $job_supplement_search_value_array["value_array"];
            }


        } else {

            $job_information = [];

        }



        //検索項目格納用配列
        $search_element_array = [
            'search_prefectural_cd' => $search_prefectural_cd,
            'search_municipality_cd_array' => $search_municipality_cd_array,
            'search_job_category_array' => $search_job_category_array,
            'search_job_supplement_array' => $search_job_supplement_array,
        ];



        //都道府県ブルダウン作成用
        $prefectural_list = create_list::prefectural_list();
        //給与プルダウン作成用
        $salary_maincategory_list = create_list::salary_maincategory_list();
        //職種データ取得
        $job_category_data = get_data::job_category_data();
        //求人補足データ取得
        $job_supplement_data = get_data::job_supplement_data();


        return view('hp/screen/job_information',
                compact('job_information'
                , 'search_element_array'
                , 'prefectural_list'
                , 'job_category_data'
                , 'job_supplement_data'
                , 'salary_maincategory_list'
        ));

    }

    //求人情報検索処理
    function search_job_information($all_job_search_value_array)
    {
        
        $sql = $this->set_job_search_sql($all_job_search_value_array);        
        $job_information = DB::connection('mysql')->select($sql);


        

        foreach ($job_information as $index => $info){
        
            $asset_path_array = [];           

            $job_image_folder_name = $info->job_image_folder_name;

          
            $check_job_image_folder_path = "public/job_image/" . $job_image_folder_name;

            // $a = asset('storage/job_image/1/1.png');
            $asset_path = asset('storage/job_image/' .$job_image_folder_name);

            if (Storage::exists($check_job_image_folder_path)){

                //フォルダの確認が出来たら、フォルダ内のファイル名を全て取得            
                $files = Storage::files($check_job_image_folder_path);

                // 取得したファイル名を表示する例
                foreach ($files as $file) {

                    $fileInfo = pathinfo($file);
                    $file_name = $fileInfo['basename']; // ファイル名のみ取得
                    $asset_path_array[] = $asset_path ."/". $file_name;
                    
                }
                
            }

            $info->asset_path_array =  $asset_path_array;
            
        }


        return $job_information;

    }

    //求人検索SQL文設定処理
    function set_job_search_sql($all_job_search_value_array){

        //都道府県CDを取得
        $prefectural_cd_search_value_array = $all_job_search_value_array["prefectural_cd_search_value_array"];
        //市区町村CDを取得
        $municipality_cd_search_value_array = $all_job_search_value_array["municipality_cd_search_value_array"];

        //給与を取得
        $salary_search_value_array = $all_job_search_value_array["salary_search_value_array"];

        //職種を取得
        $job_category_search_value_array = $all_job_search_value_array["job_category_search_value_array"];

        //求人補足を取得
        $job_supplement_search_value_array = $all_job_search_value_array["job_supplement_search_value_array"];


        // 日付を取得
        $now = Carbon::now();         
        $today = $now->format('Y-m-d');

        $new_line = "\n";

        $sql = "        
        WITH editing_job_supplement_connection_t AS ( 
            SELECT
                employer_id
                , job_id
                , CONCAT( 
                    '['
                    , GROUP_CONCAT( 
                        job_supplement_subcategory_cd 
                        ORDER BY
                            job_supplement_subcategory_cd SEPARATOR ']['
                    ) 
                    , ']'
                ) AS job_supplement_subcategory_cds 
            FROM
                job_supplement_connection_t 
            GROUP BY
                employer_id
                , job_id
        ) 
        , editing_job_category_connection_t AS ( 
            SELECT
                employer_id
                , job_id
                , CONCAT( 
                    '['
                    , GROUP_CONCAT( 
                        job_subcategory_cd 
                        ORDER BY
                            job_subcategory_cd SEPARATOR ']['
                    ) 
                    , ']'
                ) AS job_subcategory_cds 
            FROM
                job_category_connection_t 
            GROUP BY
                employer_id
                , job_id
        ) 
        , address_m1 AS ( 
            SELECT
                prefectural_cd
                , prefectural_name 
            FROM
                address_m 
            GROUP BY
                prefectural_cd
                , prefectural_name
        ) 
        SELECT
            job_information_t.id
            , job_information_t.employer_id
            , employer_m.employer_name
            , job_information_t.job_id
            , job_information_t.title
            , job_information_t.work_location_prefectural_cd
            , job_information_t.work_location_municipality_cd
            , CASE 
                WHEN address_m2.prefectural_name IS NOT NULL 
                    THEN CONCAT( 
                    address_m2.prefectural_name
                    , '　'
                    , address_m2.municipality_name
                ) 
                ELSE address_m1.prefectural_name 
                END AS work_location
            , job_information_t.working_time
            , job_information_t.employment_status
            , job_information_t.salary
            , job_information_t.holiday
            , job_image_folder_name            
            , editing_job_supplement_connection_t.job_supplement_subcategory_cds 
            , editing_job_category_connection_t.job_subcategory_cds
        FROM
            job_information_t 
            LEFT JOIN employer_m 
                ON employer_m.employer_id = employer_m.employer_id 
            LEFT JOIN editing_job_supplement_connection_t 
                ON editing_job_supplement_connection_t.employer_id = job_information_t.employer_id 
                AND editing_job_supplement_connection_t.job_id = job_information_t.job_id 
            LEFT JOIN editing_job_category_connection_t 
                ON editing_job_category_connection_t.employer_id = job_information_t.employer_id 
                AND editing_job_category_connection_t.job_id = job_information_t.job_id 
            LEFT JOIN address_m1 
                ON address_m1.prefectural_cd = job_information_t.work_location_prefectural_cd 
            LEFT JOIN address_m as address_m2 
                ON address_m2.prefectural_cd = job_information_t.work_location_prefectural_cd 
                AND address_m2.municipality_cd = job_information_t.work_location_municipality_cd 

        WHERE
            job_information_t.publish_flg = '1'    
        ";

        //都道府県CDを取得
        if($prefectural_cd_search_value_array["existence_data"] == 1) {
            $prefectural_cd = $prefectural_cd_search_value_array["prefectural_cd"];
            $sql .= $new_line  . 'AND';            
            $sql .= $new_line  . "job_information_t.work_location_prefectural_cd = '" . $prefectural_cd . "'";
        }

        //市区町村CDを取得
        if($municipality_cd_search_value_array["existence_data"] == 1) {
            $municipality_cd_array = $municipality_cd_search_value_array["value_array"];
            
            $municipality_cd_list = implode(',', $municipality_cd_array);
        
            $sql .= $new_line  . "AND";       
            $sql .= $new_line  . "job_information_t.work_location_municipality_cd IN (" . $municipality_cd_list . ")";        

        }

        //給与を取得
        
        if($salary_search_value_array["existence_data"] == 1) {
            
            $salary_maincategory_cd = $salary_search_value_array["salary_maincategory_cd"];
            $salary = $salary_search_value_array["salary"];            

        }

        //職種
        if($job_category_search_value_array["existence_data"] == 1) {

            $search_job_category_array = $job_category_search_value_array["value_array"];
        
            foreach ($search_job_category_array as $index => $job_subcategory_cd){
                
                if($index == 0){
                    $sql .= $new_line  . "AND";                      
                    $sql .= $new_line  . "(";      
                }else{
                    $sql .= $new_line  . "OR";
                }
                                
                $sql .= $new_line  . "editing_job_category_connection_t.job_subcategory_cds LIKE '%[" . $job_subcategory_cd . "]%'";                

                if(count($search_job_category_array) - 1 == $index){
                    $sql .= $new_line  . ")";  
                }


            }
        }

        //求人情報補足
        if($job_supplement_search_value_array["existence_data"] == 1) {
            $search_job_supplement_array = $job_supplement_search_value_array["value_array"];

            foreach ($search_job_supplement_array as $index => $job_supplement_subcategory_cd){

                if($index == 0){
                    $sql .= $new_line  . "AND";                      
                    $sql .= $new_line  . "(";      
                }else{
                    $sql .= $new_line  . "OR";
                }

                $sql .= $new_line  . " editing_job_supplement_connection_t.job_supplement_subcategory_cds LIKE '%[" . $job_supplement_subcategory_cd . "]%'";                

                if(count($search_job_supplement_array) - 1 == $index){
                    $sql .= $new_line  . ")";  
                }
            }
        }


        Log::channel('sql_log')->info($sql);
        return $sql;

    }
    //求人情報検索値セット処理
    function job_information_set_search_value(Request $request)
    {
        //全ての検索条件を取得
        $all_job_search_value_array = $request->all_job_search_value_array;

        $job_supplement_search_value_array = $all_job_search_value_array["job_supplement_search_value_array"];

        if($job_supplement_search_value_array["existence_data"] == 1) {

            $search_job_supplement_array = $job_supplement_search_value_array["value_array"];
            // 日付を取得
            $now = Carbon::now();

            //求人検索履歴を登録
            $search_date = $now->format('Y/m/d');
            foreach($search_job_supplement_array as $index => $job_supplement_subcategory_cd){
                //photoget_tにデータ作成
                job_search_history_t_model::create(
                    [
                        "job_supplement_subcategory_cd" => $job_supplement_subcategory_cd
                        ,"search_date" => $search_date
                    ]
               );

            }

        }



        session()->put('all_job_search_value_array', $all_job_search_value_array);

        return response()->json(['result' => 'success']);

    }

    function job_information_detail(Request $request)
    {

        // 日付を取得
        $now = Carbon::now();         
        $today = $now->format('Y-m-d');

        $id = $request->job_number;

        $job_information = job_information_t_model::select(
            'job_information_t.id as id',
            'job_information_t.employer_id as employer_id',
            'employer_m.employer_name as employer_name',            
            'employer_m.hp_url as employer_hp_url',
            'employer_m.employer_description as employer_description',
            'employer_m.remarks as employer_remarks',
            'job_information_t.job_id as job_id',
            'job_information_t.title as title',
            'job_information_t.sub_title as sub_title',
            DB::raw("
                CASE
                    WHEN municipality_address_m.prefectural_name IS NOT NULL THEN CONCAT(municipality_address_m.prefectural_name, '　', municipality_address_m.municipality_name)
                    ELSE prefectural_address_m.prefectural_name
                END as work_location
            "),
            'job_information_t.employment_status as employment_status',
            'job_information_t.working_time as working_time',            
            'job_information_t.salary as salary',
            'job_information_t.holiday as holiday',
            'job_information_t.manager_name as manager_name',
            'job_information_t.tel as tel',
            'job_information_t.fax as fax',
            'job_information_t.hp_url as job_hp_url',
            'job_information_t.mailaddress as mailaddress',
            'job_information_t.job_image_folder_name as job_image_folder_name',
            'job_information_t.application_requirements as application_requirements',            
            'job_information_t.scout_statement as scout_statement',
            'job_information_t.remarks as job_remarks',
            
        )
        ->leftJoin('employer_m', 'job_information_t.employer_id', '=', 'employer_m.employer_id')
        ->leftJoin(DB::raw('(SELECT prefectural_cd , prefectural_name FROM address_m GROUP BY prefectural_cd ,prefectural_name) as prefectural_address_m'), function ($join) {
            $join->on('job_information_t.work_location_prefectural_cd', '=', 'prefectural_address_m.prefectural_cd');
        });
        $job_information = $job_information->leftJoin('address_m as municipality_address_m', function ($join) {
            $join->on('job_information_t.work_location_prefectural_cd', '=', 'municipality_address_m.prefectural_cd')
                ->on('job_information_t.work_location_municipality_cd', '=', 'municipality_address_m.municipality_cd');
        })
        ->where('id', '=', $id)
        ->where('job_information_t.publish_flg', '=', '1')        
        ->first();

        if(is_null($job_information)){

            return redirect(route('hp.job_information'));

        }else{

            $asset_path_array = [];
            $job_image_folder_name = $job_information->job_image_folder_name;

            if($job_image_folder_name != ""){
          
                $check_job_image_folder_path = "public/job_image/" . $job_image_folder_name;
                
                $asset_path = asset('storage/job_image/' .$job_image_folder_name);

                if (Storage::exists($check_job_image_folder_path)){

                    //フォルダの確認が出来たら、フォルダ内のファイル名を全て取得            
                    $files = Storage::files($check_job_image_folder_path);

                    // 取得したファイル名を表示する例
                    foreach ($files as $file) {

                        $fileInfo = pathinfo($file);
                        $file_name = $fileInfo['basename']; // ファイル名のみ取得
                        $asset_path_array[] = $asset_path ."/". $file_name;
                        
                    }
                    
                }
            }

            $job_information->asset_path_array =  $asset_path_array;

        }


        $employer_remarks = $job_information->employer_remarks;

        return view('hp/screen/job_information_detail', compact('job_information'));

    }

    function message_to_students(Request $request)
    {

        return view('hp/screen/message_to_students');
    }

    function message_to_employers(Request $request)
    {
        return view('hp/screen/message_to_employers');
    }


    function pseudo_job_information(Request $request)
    {

        //画面で選択したアップロードファイル
        $upload_files = $request->file('file');

        $imagesDataArray = [];

        foreach($upload_files as $Count => $file){

            $extension = $file->getClientOriginalExtension();

            //画像ファイルデータ取得
            $image_data = File::get($file);


            $data_type = "";
            switch ($extension) {

                case 'JPEG':
                case 'jpg' || 'JPG' || 'jpeg' || 'JPEG':
                    $data_type = "data:image/jpeg;base64,";
                    break;
                case 'png' || 'PNG':
                    $data_type = "data:image/png;base64,";
                    break;
                default:
                    $data_type = "data:image/jpeg;base64,";
                    break;
            }

            $base64image = $data_type . base64_encode($image_data);

            $base64imagesArray[] = $base64image;
        }

        foreach ($base64imagesArray as $base64image){

            $a = $base64image;

        }

        return view('hp/screen/pseudo_job_information', compact('base64imagesArray'));

    }

}
