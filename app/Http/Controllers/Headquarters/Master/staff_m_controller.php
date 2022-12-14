<?php

namespace App\Http\Controllers\Headquarters\Master;
use App\Http\Controllers\Controller;

use App\Models\staff_m_model;
use App\Models\staff_password_t_model;
use App\Models\subcategory_m_model;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Repositories\GenderList;
use App\Repositories\AuthorityList;
use Illuminate\Support\Facades\DB;
class staff_m_controller extends Controller
{
    function index()
    {
        $gender_list = GenderList::get();

        $authority_list = AuthorityList::get();      

        $operator_authority = session()->get('authority');

        $staff_list = staff_m_model::select(

            'staff_m.staff_id as staff_id',
            'staff_m.staff_name as staff_name',
            'staff_m.staff_name_yomi as staff_name_yomi',
            'staff_m.nick_name as nick_name',

            'staff_m.gender as gender',
            'genderinfo.subcategory_name as gender_name',

            'staff_m.tel as tel',
            'staff_m.mailaddress as mailaddress',

            'staff_m.authority as authority',
            'authorityinfo.subcategory_name as authority_name',
       
            'staff_password_t.id as password_id',
            'staff_password_t.login_id as login_id',
            'staff_password_t.password as password',
        )
        ->leftJoin('subcategory_m as genderinfo', function ($join) {
            $join->on('genderinfo.subcategory_cd', '=', 'staff_m.gender')
                 ->where('genderinfo.maincategory_cd', '=', '1');
            ;
        })
        ->leftJoin('subcategory_m as authorityinfo', function ($join) {
            $join->on('authorityinfo.subcategory_cd', '=', 'staff_m.authority')
                ->where('authorityinfo.maincategory_cd', '=', '2');
            ;
        })     
        ->leftJoin('staff_password_t', function ($join) {
            $join->on('staff_password_t.staff_id', '=', 'staff_m.staff_id')
                ->whereNull('staff_password_t.deleted_at');
            ;
        })       
        ->orderBy('staff_m.staff_id', 'asc')        
        ->get();

        
        return view('headquarters/screen/master/staff/index', compact('staff_list','gender_list','authority_list','operator_authority'));
    }


    //  ????????????
    function save(request $request)
    {

        $staff_id = intval($request->staff_id);

        
        $staff_name = $request->staff_name;
        $staff_name_yomi = $request->staff_name_yomi;
        $nick_name = $request->nick_name;        
        $gender = intval($request->gender);
        $tel = $request->tel;
        $mailaddress = $request->mailaddress;
        $authority = intval($request->authority);
        $operator = 9999;
        
        try {

            if($staff_id == 0){
                               
                //??????????????????                
                staff_m_model::create(
                    [
                        'staff_name' => $staff_name,                        
                        'staff_name_yomi' => $staff_name_yomi,     
                        'nick_name' => $nick_name,
                        'gender' => $gender,
                        'tel' => $tel,
                        'mailaddress' => $mailaddress,
                        'authority' => $authority,
                        'tel' => $tel,
                        'created_by' => $operator,                        
                    ]
                );            


            }else{

                //????????????
                staff_m_model::
                where('staff_id', $staff_id)                
                ->update(
                    [
                        'staff_name' => $staff_name,                        
                        'staff_name_yomi' => $staff_name_yomi,     
                        'nick_name' => $nick_name,
                        'gender' => $gender,
                        'tel' => $tel,
                        'mailaddress' => $mailaddress,
                        'authority' => $authority,
                        'tel' => $tel,
                        'updated_by' => $operator,                 
                    ]
                );
            }
    
        } catch (Exception $e) {            
            
            $ErrorMessage = '??????????????????????????????????????????' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

            $ResultArray = array(
                "Result" => "error",
                "Message" => $ErrorMessage,
            );

            return response()->json(['ResultArray' => $ResultArray]);
                                
        }

        $ResultArray = array(
            "Result" => "success",
            "Message" => '',
        );

        session()->flash('success', '?????????????????????????????????');
        session()->flash('message-type', 'success');
        return response()->json(['ResultArray' => $ResultArray]);
    }

    //  ??????????????????
    function delete_or_restore(Request $request)
    {
        $delete_flg = intval($request->delete_flg);

        $maincategory_cd = intval($request->delete_maincategory_cd);
        $subcategory_cd = intval($request->delete_subcategory_cd);

        $maincategory_name = $request->delete_maincategory_name;
        $subcategory_name = $request->delete_subcategory_name;       

        try {

            
            if($delete_flg == 0){

                //????????????
                subcategory_m_model::
                where('maincategory_cd', $maincategory_cd)
                ->where('subcategory_cd', $subcategory_cd)
                ->delete();

                session()->flash('success', '[???????????? = ' . $maincategory_name . ' ???????????? = ' . $subcategory_name . ']?????????????????????????????????????????????');                
            }else{    

                //??????????????????
                subcategory_m_model::
                where('maincategory_cd', $maincategory_cd)
                ->where('subcategory_cd', $subcategory_cd)
                ->withTrashed()                
                ->restore();

                session()->flash('success', '[???????????? = ' . $maincategory_name . ' ???????????? = ' . $subcategory_name . ']?????????????????????????????????????????????');                                
            }

        } catch (Exception $e) {

            $ErrorMessage = '????????????????????????????????????????????????????????????' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

            session()->flash('error', '[???????????? = ' . $maincategory_name . ' ????????? = ' . $subcategory_name . ']????????????????????????????????????????????????'); 
           
        }       

        return back();
    }

    // ??????????????????????????????
    function login_info_update(request $request)
    {
        
        $id = intval($request->logininfo_password_id);
        $staff_id = intval($request->logininfo_staff_id);
        $login_id = $request->login_id;
        $password = $request->password;
        $operator = 9999;
        
        try {
    
            DB::connection('mysql')->beginTransaction();

            //????????????
            staff_password_t_model::
            where('id', $id)        
            ->delete();

            //??????????????????                
            staff_password_t_model::create(
                [
                    'staff_id' => $staff_id,                        
                    'login_id' => $login_id,     
                    'password' => $password,               
                    'created_by' => $operator,                        
                ]
            );          

            session()->flash('success', '[????????????ID = ' . $staff_id . ']?????????????????????????????????????????????');                

            DB::connection('mysql')->commit();

        } catch (Exception $e) {

            DB::connection('mysql')->rollBack();

            $ErrorMessage = '????????????????????????????????????????????????' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);
            
            session()->flash('error', '[????????????ID = ' . $staff_id . ']?????????????????????????????????????????????????????????????????????');                

        }  

        return back();

        

    }

}
