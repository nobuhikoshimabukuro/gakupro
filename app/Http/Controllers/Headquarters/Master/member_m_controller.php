<?php


namespace App\Http\Controllers\Headquarters\Master;
use App\Http\Controllers\Controller;

use App\Models\member_m_model;
use App\Models\member_password_t_model;
use App\Models\subcategory_m_model;
use App\Models\school_m_model;
use App\Models\majorsubject_m_model;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Original\Common;
use App\Original\create_list;
use App\Repositories\gender_list;
use App\Repositories\authority_list;
use Illuminate\Support\Facades\DB;

class member_m_controller extends Controller
{
    function index(Request $request)
    {
        $gender_list = create_list::gender_list();
        
        $school_list = school_m_model::select(
            'school_m.school_cd as school_cd',
            'school_m.school_name as school_name',
            'school_m.school_division as school_division',
            'school_m.deleted_at as deleted_at',
        )        
        ->orderBy('school_m.school_cd', 'asc')          
        ->get();

        $majorsubject_list = majorsubject_m_model::select(
            'majorsubject_m.school_cd as school_cd',
            'school_m.school_name as school_name',
            'school_m.school_division as school_division',
            'majorsubject_m.majorsubject_cd as majorsubject_cd',
            'majorsubject_m.majorsubject_name as majorsubject_name',
            'majorsubject_m.deleted_at as deleted_at',
        )
        ->leftJoin('school_m', function ($join) {
            $join->on('school_m.school_cd', '=', 'majorsubject_m.school_cd');            
        })        
        ->orderBy('majorsubject_m.school_cd', 'asc')          
        ->orderBy('majorsubject_m.majorsubject_cd', 'asc') 
        ->get();

        $member_list = member_m_model::select(

            'member_m.member_id as member_id',
            'member_m.member_name as member_name',
            'member_m.member_name_yomi as member_name_yomi',
            'member_m.birthday as birthday',            

            'member_m.gender as gender',
            'genderinfo.subcategory_name as gender_name',

            'member_m.tel as tel',
            'member_m.mailaddress as mailaddress',

            'school_m.school_division as school_division',
            'school_division_info.subcategory_name as school_division_name',

            'member_m.school_cd as school_cd',
            'school_m.school_name as school_name',

            'member_m.majorsubject_cd as majorsubject_cd',
            'majorsubject_m.majorsubject_name as majorsubject_name',

            'member_m.admission_yearmonth as admission_yearmonth',
            'member_m.graduation_yearmonth as graduation_yearmonth',

            'member_m.emergencycontact_relations as emergencycontact_relations',
            'member_m.emergencycontact_tel as emergencycontact_tel',
            'member_m.remarks as remarks',
       
            'member_m.deleted_at as deleted_at',

            'member_password_t.id as password_id',
            'member_password_t.login_id as login_id',
            'member_password_t.password as encrypted_password',
        )
        ->leftJoin('subcategory_m as genderinfo', function ($join) {
            $join->on('genderinfo.subcategory_cd', '=', 'member_m.gender')
                 ->where('genderinfo.maincategory_cd', '=', env('gender_subcategory_cd'));            
        })
        ->leftJoin('school_m', function ($join) {
            $join->on('school_m.school_cd', '=', 'member_m.school_cd');            
        })
        ->leftJoin('subcategory_m as school_division_info', function ($join) {
            $join->on('school_division_info.subcategory_cd', '=', 'school_m.school_division')
                 ->where('school_division_info.maincategory_cd', '=', env('school_division_subcategory_cd'));            
        })   
       
        ->leftJoin('majorsubject_m', function ($join) {
            $join->on('majorsubject_m.school_cd', '=', 'member_m.school_cd')
                ->on('majorsubject_m.majorsubject_cd', '=', 'member_m.majorsubject_cd');                         
        })
        ->leftJoin('member_password_t', function ($join) {
            $join->on('member_password_t.member_id', '=', 'member_m.member_id')
                  ->whereNull('member_password_t.deleted_at');            
        })       
        ->withTrashed()
        ->orderBy('member_m.member_id', 'asc')        
        ->paginate(env('paginate_count'));


        foreach($member_list as $info){

            $password = "";
            if($info->encrypted_password != ""){            
                $password = Common::decryption($info->encrypted_password);
            }
            //DBに登録されている暗号化したパスワードを平文に変更し再格納                    
            $info->password = $password;
        }
        
        return view('headquarters/screen/master/member/index', compact('member_list','gender_list','school_list','majorsubject_list'));
    }


    function majorsubject_search(Request $request)
    {

        $school_cd = $request->school_cd;

        $search_majorsubject_list = majorsubject_m_model::select(
            'majorsubject_m.school_cd as school_cd',
            'school_m.school_name as school_name',
            'school_m.school_division as school_division',
            'majorsubject_m.majorsubject_cd as majorsubject_cd',
            'majorsubject_m.majorsubject_name as majorsubject_name',
            'majorsubject_m.deleted_at as deleted_at',
        )
        ->leftJoin('school_m', function ($join) {
            $join->on('school_m.school_cd', '=', 'majorsubject_m.school_cd');            
        })        
        ->orderBy('majorsubject_m.school_cd', 'asc')          
        ->orderBy('majorsubject_m.majorsubject_cd', 'asc') 
        ->where('majorsubject_m.school_cd', '=', $school_cd)
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
                    "majorsubject_name" => $info->majorsubject_name                  
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
    
}
