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
use App\Original\job_related;

use App\Models\job_information_t_model;
use App\Models\job_subcategory_m_model;
use App\Models\job_supplement_maincategory_m_model;
use App\Models\job_supplement_subcategory_m_model;
use App\Models\job_supplement_connection_t_model;
use App\Models\job_search_history_t_model;
use App\Models\employment_status_m_model;

use App\Models\employment_status_connection_t_model;
use App\Models\job_category_connection_t_model;




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
        $search_employment_status_array = [];

        $search_salary_maincategory_cd = "";
        $search_salary_subcategory_cd = "";
        
        $search_job_category_array = [];
        $search_job_supplement_array = [];
        

        if(session()->has('all_job_search_value_array')) {

            $all_job_search_value_array = session()->get('all_job_search_value_array');
            session()->remove('all_job_search_value_array');
            $job_information = $this->search_job_information($all_job_search_value_array);

            $prefectural_cd_search_value_array = $all_job_search_value_array["prefectural_cd_search_value_array"];
            $municipality_cd_search_value_array = $all_job_search_value_array["municipality_cd_search_value_array"];
            
            $salary_maincategory_cd_search_value_array = $all_job_search_value_array["salary_maincategory_cd_search_value_array"];
            $salary_subcategory_cd_search_value_array = $all_job_search_value_array["salary_subcategory_cd_search_value_array"];

            $employment_status_search_value_array = $all_job_search_value_array["employment_status_search_value_array"];
            $job_category_search_value_array = $all_job_search_value_array["job_category_search_value_array"];
            $job_supplement_search_value_array = $all_job_search_value_array["job_supplement_search_value_array"];

            
            if($prefectural_cd_search_value_array["existence_data"] == 1) {
                $search_prefectural_cd = $prefectural_cd_search_value_array["prefectural_cd"];
            }

            if($municipality_cd_search_value_array["existence_data"] == 1) {
                $search_municipality_cd_array = $municipality_cd_search_value_array["value_array"];
            }

            if($salary_maincategory_cd_search_value_array["existence_data"] == 1) {
                $search_salary_maincategory_cd = $salary_maincategory_cd_search_value_array["salary_maincategory_cd"];
            }

            if($salary_subcategory_cd_search_value_array["existence_data"] == 1) {
                $search_salary_subcategory_cd = $salary_subcategory_cd_search_value_array["salary_subcategory_cd"];
            }

            if($employment_status_search_value_array["existence_data"] == 1) {
                $search_employment_status_array = $employment_status_search_value_array["value_array"];
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
            'search_employment_status_array' => $search_employment_status_array,
            'search_salary_maincategory_cd' => $search_salary_maincategory_cd,
            'search_salary_subcategory_cd' => $search_salary_subcategory_cd,
            'search_job_category_array' => $search_job_category_array,
            'search_job_supplement_array' => $search_job_supplement_array,
        ];

        //都道府県ブルダウン作成用
        $prefectural_list = create_list::prefectural_list();
        //給与プルダウン作成用
        $salary_maincategory_list = create_list::salary_maincategory_list();
        //雇用形態データ取得
        $employment_status_data = get_data::employment_status_data();
        //職種データ取得
        $job_category_data = get_data::job_category_data();
        //求人補足データ取得
        $job_supplement_data = get_data::job_supplement_data();



        return view('hp/screen/job_information',
                compact('job_information'
                , 'search_element_array'
                , 'prefectural_list'
                , 'employment_status_data'
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
        
            $employer_id = $info->employer_id;
            $job_id = $info->job_id;

            $job_images_path_array = job_related::get_job_images($employer_id,$job_id);            

            $info->job_images_path_array =  $job_images_path_array;
            
        }


        return $job_information;

    }

    //求人検索SQL文設定処理
    function set_job_search_sql($all_job_search_value_array){

        //都道府県CDを取得
        $prefectural_cd_search_value_array = $all_job_search_value_array["prefectural_cd_search_value_array"];
        //市区町村CDを取得
        $municipality_cd_search_value_array = $all_job_search_value_array["municipality_cd_search_value_array"];

        //雇用形態を取得
        $employment_status_search_value_array = $all_job_search_value_array["employment_status_search_value_array"];

        //給与を取得
        $salary_maincategory_cd_search_value_array = $all_job_search_value_array["salary_maincategory_cd_search_value_array"];
        $salary_subcategory_cd_search_value_array = $all_job_search_value_array["salary_subcategory_cd_search_value_array"];

        //職種を取得
        $job_category_search_value_array = $all_job_search_value_array["job_category_search_value_array"];

        //求人補足を取得
        $job_supplement_search_value_array = $all_job_search_value_array["job_supplement_search_value_array"];


        // 日付を取得
        $now = Carbon::now();         
        $today = $now->format('Y-m-d');

        $new_line = "\n";

        $sql = "        
        WITH 
        editing_employment_status_connection_t AS ( 
            SELECT
                employer_id
                , job_id
                , CONCAT( 
                    '['
                    , GROUP_CONCAT( 
                        employment_status_id 
                        ORDER BY
                        employment_status_id SEPARATOR ']['
                    ) 
                    , ']'
                ) AS employment_status_ids 
            FROM
            employment_status_connection_t 
            GROUP BY
                employer_id
                , job_id
        ) 
        , 
        editing_job_category_connection_t AS ( 
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
        , 
        editing_job_supplement_connection_t AS ( 
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
        ,
        address_m1 AS ( 
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
            , job_information_t.salary
            , job_information_t.holiday
            , job_image_folder_name            
            , editing_employment_status_connection_t.employment_status_ids            
            , editing_job_category_connection_t.job_subcategory_cds
            , editing_job_supplement_connection_t.job_supplement_subcategory_cds
        FROM
            job_information_t 

            LEFT JOIN employer_m 
                ON employer_m.employer_id = employer_m.employer_id 
            
            LEFT JOIN editing_employment_status_connection_t 
                ON editing_employment_status_connection_t.employer_id = job_information_t.employer_id 
                AND editing_employment_status_connection_t.job_id = job_information_t.job_id 
                
            LEFT JOIN editing_job_category_connection_t 
                ON editing_job_category_connection_t.employer_id = job_information_t.employer_id 
                AND editing_job_category_connection_t.job_id = job_information_t.job_id 

            LEFT JOIN editing_job_supplement_connection_t 
                ON editing_job_supplement_connection_t.employer_id = job_information_t.employer_id 
                AND editing_job_supplement_connection_t.job_id = job_information_t.job_id            

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

        //雇用形態
        if($employment_status_search_value_array["existence_data"] == 1) {
            
            $search_employment_status_array = $employment_status_search_value_array["value_array"];
        
            foreach ($search_employment_status_array as $index => $employment_status_id){
                
                if($index == 0){
                    $sql .= $new_line  . "AND";                      
                    $sql .= $new_line  . "(";      
                }else{
                    $sql .= $new_line  . "OR";
                }
                                
                $sql .= $new_line  . "editing_employment_status_connection_t.employment_status_ids LIKE '%[" . $employment_status_id . "]%'";                

                if(count($search_employment_status_array) - 1 == $index){
                    $sql .= $new_line  . ")";  
                }
            }
        }

        //給与を取得        
        if($salary_maincategory_cd_search_value_array["existence_data"] == 1) {
            
            $salary_maincategory_cd = $salary_maincategory_cd_search_value_array["salary_maincategory_cd"];                     

        }

        if($salary_subcategory_cd_search_value_array["existence_data"] == 1) {            
            $salary_subcategory_cd = $salary_subcategory_cd_search_value_array["salary_subcategory_cd"];
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
            'job_information_t.job_id as job_id',
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

            $employer_id = $job_information->employer_id;
            $job_id = $job_information->job_id;
            $job_images_path_array = job_related::get_job_images($employer_id,$job_id);
            $set_job_information_detail = $this->set_job_information_detail($job_information);

            $job_information->asset_path_array = $set_job_information_detail["asset_path_array"];
            $job_information->employment_status_datas = $set_job_information_detail["employment_status_datas"];
            $job_information->job_category_datas = $set_job_information_detail["job_category_datas"];
            $job_information->job_supplement_category_datas = $set_job_information_detail["job_supplement_category_datas"];   
            $job_information->job_images_path_array = $job_images_path_array;
        }        

        return view('hp/screen/job_information_detail', compact('job_information'));

    }

    function set_job_information_detail($job_information)
    {

        $employer_id = $job_information->employer_id;
        $job_id = $job_information->job_id;        

        $return_array = [];

        $asset_path_array = [];
        $employment_status_datas = [];
        $job_category_datas = [];
        $job_supplement_category_datas = [];
        

        $set_employment_status = employment_status_connection_t_model::select(
            'employment_status_connection_t.employer_id as employer_id',
            'employment_status_connection_t.job_id as job_id',
            'employment_status_connection_t.employment_status_id as employment_status_id',
            'employment_status_m.employment_status_name as employment_status_name',
        )
        ->leftJoin('employment_status_m', 'employment_status_connection_t.employment_status_id', '=', 'employment_status_m.employment_status_id')
        ->whereNull('employment_status_m.deleted_at')
        ->where('employment_status_connection_t.employer_id', '=', $employer_id)
        ->where('employment_status_connection_t.job_id', '=', $job_id)            
        ->get();

        foreach ($set_employment_status as $index => $set_employment_status_info){            
            $employment_status_id = $set_employment_status_info->employment_status_id;
            $employment_status_name = $set_employment_status_info->employment_status_name;
            $employment_status_datas[] = ['employment_status_id'=> $employment_status_id , 'employment_status_name'=> $employment_status_name];
        }        

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


        
        $return_array = [
            "asset_path_array" => $asset_path_array
            ,"employment_status_datas" => $employment_status_datas
            ,"job_category_datas" => $job_category_datas
            ,"job_supplement_category_datas" => $job_supplement_category_datas
        ];

        return $return_array;

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
