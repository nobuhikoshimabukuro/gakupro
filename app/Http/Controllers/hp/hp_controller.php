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
        return view('hp/screen/message_to_students');
    }

    function message_to_employers(Request $request)
    {        
        return view('hp/screen/message_to_employers');
    }

}
