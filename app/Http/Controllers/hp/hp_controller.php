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

use App\Models\job_information_t_model;
use App\Models\job_supplement_maincategory_m_model;
use App\Models\job_supplement_subcategory_m_model;
use App\Models\job_supplement_connection_t_model;
use App\Models\job_search_history_t_model;


class hp_controller extends Controller
{

    function index(Request $request)
    {

        // Log::channel('info_log')->info("info_log");
        // Log::channel('send_mail_log')->info("send_mail_log");
        // Log::channel('important_log')->info("important_log");
        // Log::channel('error_log')->info("error_log");
        // Log::channel('emergency_log')->info("emergency_log");
        // Log::channel('database_backup_log')->info("database_backup_log");

        return view('hp/screen/index');
    }

    function job_information(Request $request)
    {



        $search_prefectural_cd = "";
        $search_municipality_cd_array = [];
        $search_job_supplement_array = [];

        if(session()->has('all_job_search_value_array')) {

            $all_job_search_value_array = session()->get('all_job_search_value_array');

            $job_information = $this->search_job_information($all_job_search_value_array);

            $all_job_search_value_array = session()->remove('all_job_search_value_array');



            $prefectural_cd_search_value_array = $all_job_search_value_array["prefectural_cd_search_value_array"];
            $municipality_cd_search_value_array = $all_job_search_value_array["municipality_cd_search_value_array"];
            $job_supplement_search_value_array = $all_job_search_value_array["job_supplement_search_value_array"];


            if($prefectural_cd_search_value_array["existence_data"] == 1) {
                $search_prefectural_cd = $prefectural_cd_search_value_array["prefectural_cd"];
            }

            if($municipality_cd_search_value_array["existence_data"] == 1) {
                $search_municipality_cd_array = $municipality_cd_search_value_array["value_array"];
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
            'search_job_supplement_array' => $search_job_supplement_array,
        ];



        //都道府県ブルダウン作成用
        $prefectural_list = create_list::prefectural_list();

        //求人補足情報取得
        $job_supplement_list = job_supplement_subcategory_m_model::select(
            'job_supplement_subcategory_m.job_supplement_maincategory_cd as job_supplement_maincategory_cd',
            'job_supplement_maincategory_m.job_supplement_maincategory_name as job_supplement_maincategory_name',
            'job_supplement_maincategory_m.display_order as maincategory_display_order',

            'job_supplement_subcategory_m.job_supplement_subcategory_cd as job_supplement_subcategory_cd',
            'job_supplement_subcategory_m.job_supplement_subcategory_name as job_supplement_subcategory_name',
            'job_supplement_subcategory_m.display_order as subcategory_display_order'
        )
        ->leftJoin('job_supplement_maincategory_m', 'job_supplement_subcategory_m.job_supplement_maincategory_cd', '=', 'job_supplement_maincategory_m.job_supplement_maincategory_cd')
        ->whereNull('job_supplement_maincategory_m.deleted_at')
        ->whereNull('job_supplement_subcategory_m.deleted_at')
        ->orderBy('job_supplement_maincategory_m.display_order')
        ->orderBy('job_supplement_subcategory_m.display_order')
        ->get();


        return view('hp/screen/job_information',
                compact('job_information'
                , 'search_element_array'
                , 'prefectural_list'
                , 'job_supplement_list'
        ));

    }

    //求人情報検索処理
    function search_job_information($all_job_search_value_array)
    {
        //都道府県CDを取得
        $prefectural_cd_search_value_array = $all_job_search_value_array["prefectural_cd_search_value_array"];
        //市区町村CDを取得
        $municipality_cd_search_value_array = $all_job_search_value_array["municipality_cd_search_value_array"];
        //求人補足を取得
        $job_supplement_search_value_array = $all_job_search_value_array["job_supplement_search_value_array"];




        $job_information = job_information_t_model::select(
            'job_information_t.id as id',
            'job_information_t.employer_id as employer_id',
            'employer_m.employer_name as employer_name',
            'job_information_t.job_id as job_id',
            'job_information_t.title as title',
            'job_information_t.work_location_prefectural_cd as work_location_prefectural_cd',
            'job_information_t.work_location_municipality_cd as work_location_municipality_cd',

            DB::raw("
                CASE
                    WHEN municipality_address_m.prefectural_name IS NOT NULL THEN CONCAT(municipality_address_m.prefectural_name, '　', municipality_address_m.municipality_name)
                    ELSE prefectural_address_m.prefectural_name
                END as work_location
            "),
            'prefectural_address_m.prefectural_name as prefectural_name1',
            'municipality_address_m.prefectural_name as prefectural_name2',
            'municipality_address_m.municipality_name as municipality_name2',
            'job_information_t.working_time as working_time',
            'job_information_t.employment_status as employment_status',
            'job_information_t.salary as salary',
            'job_information_t.holiday as holiday'
        )
        ->leftJoin('employer_m', 'job_information_t.employer_id', '=', 'employer_m.employer_id')

        ->leftJoin(DB::raw('(SELECT prefectural_cd , prefectural_name FROM address_m GROUP BY prefectural_cd ,prefectural_name) as prefectural_address_m'), function ($join) {
            $join->on('job_information_t.work_location_prefectural_cd', '=', 'prefectural_address_m.prefectural_cd');
        });
        $job_information = $job_information->leftJoin('address_m as municipality_address_m', function ($join) {
            $join->on('job_information_t.work_location_prefectural_cd', '=', 'municipality_address_m.prefectural_cd')
                ->on('job_information_t.work_location_municipality_cd', '=', 'municipality_address_m.municipality_cd');
        });

        //都道府県CDを取得
        if($prefectural_cd_search_value_array["existence_data"] == 1) {
            $prefectural_cd = $prefectural_cd_search_value_array["prefectural_cd"];
            $job_information = $job_information->where('job_information_t.work_location_prefectural_cd', '=', $prefectural_cd);
        }

        //市区町村CDを取得
        if($municipality_cd_search_value_array["existence_data"] == 1) {
            $municipality_cd_array = $municipality_cd_search_value_array["value_array"];
            $job_information = $job_information->wherein('job_information_t.work_location_municipality_cd', $municipality_cd_array);
        }

        if($job_supplement_search_value_array["existence_data"] == 1) {
            $search_job_supplement_array = $job_supplement_search_value_array["value_array"];
            $job_supplement_connection_t = job_supplement_connection_t_model::wherein("job_supplement_subcategory_cd",$search_job_supplement_array)->get();

            // foreach ($job_supplement_connection_t as $index => $info) {

            //     $employer_id = $info->employer_id;
            //     $job_id = $info->job_id;

            //     $job_information = $job_information->orWhere(function ($query) use ($employer_id, $job_id) {
            //         $query->where('employer_id', $employer_id)
            //               ->where('job_id', $job_id);
            //     });
            // }
        }


        $job_information = $job_information->get();


        return $job_information;

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
        $id = $request->job_number;

        $job_information = job_information_t_model::select(
            'job_information_t.id as id',
            'job_information_t.employer_id as employer_id',
            'employer_m.employer_name as employer_name',
            'job_information_t.job_id as job_id',
            'job_information_t.title as title',
            DB::raw("
                CASE
                    WHEN municipality_address_m.prefectural_name IS NOT NULL THEN CONCAT(municipality_address_m.prefectural_name, '　', municipality_address_m.municipality_name)
                    ELSE prefectural_address_m.prefectural_name
                END as work_location
            "),
            'job_information_t.working_time as working_time',
            'job_information_t.employment_status as employment_status',
            'job_information_t.salary as salary',
            'job_information_t.holiday as holiday',
            'job_information_t.application_requirements as application_requirements'
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
        ->first();

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
