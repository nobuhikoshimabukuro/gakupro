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

use App\Models\job_information_t_model;

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
        


        //請求先情報取得
        $job_information = job_information_t_model::select(
            'job_information_t.id as id',
            'job_information_t.employer_id as employer_id',
            'employer_m.employer_name as employer_name',
            'job_information_t.job_id as job_id',
            'job_information_t.title as title',
            'job_information_t.work_location as work_location',
            'job_information_t.working_time as working_time',
            'job_information_t.employment_status as employment_status',
            'job_information_t.salary as salary',
            'job_information_t.holiday as holiday'
        )
        ->leftJoin('employer_m', 'job_information_t.employer_id', '=', 'employer_m.employer_id')
        ->get();



        // return view('hp/screen/job_information', compact('job_information_t_model' , 'display_year_array'));
        return view('hp/screen/job_information', compact('job_information'));
    }

    function job_information_detail(Request $request)
    {        
        $id = $request->job_number;


         //請求先情報取得
         $job_information = job_information_t_model::select(
            'job_information_t.id as id',
            'job_information_t.employer_id as employer_id',
            'employer_m.employer_name as employer_name',
            'job_information_t.job_id as job_id',
            'job_information_t.title as title',
            'job_information_t.work_location as work_location',
            'job_information_t.working_time as working_time',
            'job_information_t.employment_status as employment_status',
            'job_information_t.salary as salary',
            'job_information_t.holiday as holiday',
            'job_information_t.application_requirements as application_requirements'
        )
        ->leftJoin('employer_m', 'job_information_t.employer_id', '=', 'employer_m.employer_id')
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
