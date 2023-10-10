<?php

namespace App\Http\Controllers\hp;
use App\Http\Controllers\Controller;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Original\common;

use App\Models\photoget_t_model;

use Illuminate\Http\Request;

use Intervention\Image\Facades\Image;

use Illuminate\Support\Facades\DB;

use STS\ZipStream\ZipStreamFacade AS Zip;

class hp_controller extends Controller
{
    
    function index(Request $request)
    {        
        return view('hp/screen/index');
    }

    function job_information(Request $request)
    {        
        return view('hp/screen/job_information');
    }

    function message_to_students(Request $request)
    {        

        Log::info("info ログ!");
        Log::channel('emergency_log')->info("emergency_log");
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
