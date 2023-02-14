<?php


namespace App\Http\Controllers\Headquarters\Master;
use App\Http\Controllers\Controller;

use App\Models\member_m_model;
use App\Models\member_password_t_model;
use App\Models\subcategory_m_model;
use App\Models\school_m_model;
use App\Models\majorsubject_m_model;

use App\Http\Requests\member_m_request;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Original\common;
use App\Original\create_list;
use App\Repositories\gender_list;
use App\Repositories\authority_list;
use Illuminate\Support\Facades\DB;

class member_m_controller extends Controller
{
    function index(Request $request)
    {

        //検索項目格納用配列
        $search_element_array = [
            'search_school_division' => $request->search_school_division,
            'search_school_cd' => $request->search_school_cd,            
            'search_majorsubject_cd' => $request->search_majorsubject_cd,
            'search_member_name' => $request->search_member_name
        ];


        $gender_list = create_list::gender_list();
        //プルダウン作成の為
        $school_division_list = create_list::school_division_list();
        
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
            'member_m.member_last_name as member_last_name',
            'member_m.member_first_name as member_first_name',
            'member_m.member_last_name_yomi as member_last_name_yomi',
            'member_m.member_first_name_yomi as member_first_name_yomi',
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
        ->orderBy('member_m.member_id', 'asc');
        
        
        if(!is_null($search_element_array['search_school_division'])){
            $member_list = $member_list->where('school_m.school_division', '=', $search_element_array['search_school_division']);
        }
        
        if(!is_null($search_element_array['search_school_cd'])){
            $member_list = $member_list->where('member_m.school_cd', '=', $search_element_array['search_school_cd']);
        }

        if(!is_null($search_element_array['search_majorsubject_cd'])){
            $member_list = $member_list->where('member_m.search_majorsubject_cd', '=', $search_element_array['search_majorsubject_cd']);
        }
        
                
        if(!is_null($search_element_array["search_member_name"])){             
            $search_member_name = $search_element_array["search_member_name"];
            $member_list = $member_list ->where(function($query) use ($search_member_name) {

                $query->orWhere('member_m.member_last_name', 'like', "%$search_member_name%")
                      ->orWhere('member_m.member_first_name', 'like', "%$search_member_name%")
                      ->orWhere('member_m.member_last_name_yomi', 'like', "%$search_member_name%")
                      ->orWhere('member_m.member_first_name_yomi', 'like', "%$search_member_name%");
            });           
        } 


        $member_list = $member_list->paginate(env('paginate_count'));


        foreach($member_list as $info){

            $password = "";
            if($info->encrypted_password != ""){            
                $password = common::decryption($info->encrypted_password);
            }
            //DBに登録されている暗号化したパスワードを平文に変更し再格納                    
            $info->password = $password;
        }
        
        return view('headquarters/screen/master/member/index', 
        compact('member_list','search_element_array','gender_list','school_division_list','school_list','majorsubject_list'));
    }
    

    //  更新処理
    function save(member_m_request $request)
    {

        $process_flg = intval($request->process_flg);

        $member_id = intval($request->member_id);
        $member_last_name = $request->member_last_name;
        $member_first_name = $request->member_first_name;
        $member_last_name_yomi = $request->member_last_name_yomi;
        $member_first_name_yomi = $request->member_first_name_yomi;
        $gender = intval($request->gender);
        
        $birthday = $request->birthday;
        $tel = $request->tel;
        $mailaddress = $request->mailaddress;
        $school_cd = intval($request->school_cd);
        $majorsubject_cd = intval($request->majorsubject_cd);
        $admission_yearmonth = $request->admission_yearmonth;
        $graduation_yearmonth = $request->graduation_yearmonth;
        $emergencycontact_relations = $request->emergencycontact_relations;
        $emergencycontact_tel = $request->emergencycontact_tel;
        $remarks = $request->remarks;
        // $registration_status = $request->registration_status;
        $registration_status = 1;

        $operator = 9999;
        
        try {

            if($process_flg == 0){

                              
                member_m_model::create(
                    [
                        'member_last_name' => $member_last_name,
                        'member_first_name' => $member_first_name,
                        'member_last_name_yomi' => $member_last_name_yomi,
                        'member_first_name_yomi' => $member_first_name_yomi,  
                        'gender' => $gender,
                        'birthday' => $birthday,
                        'tel' => $tel,
                        'mailaddress' => $mailaddress,
                        'school_cd' => $school_cd,
                        'majorsubject_cd' => $majorsubject_cd,
                        'admission_yearmonth' => $admission_yearmonth,
                        'graduation_yearmonth' => $graduation_yearmonth,
                        'emergencycontact_relations' => $emergencycontact_relations,
                        'emergencycontact_tel' => $emergencycontact_tel,
                        'remarks' => $remarks,
                        'registration_status' => $registration_status,
                        'created_by' => $operator,
                        
                    ]
                );            

            }else{
                
                //更新処理
                member_m_model::
                where('member_id', $member_id)                
                ->update(
                    [
                        'member_last_name' => $member_last_name,
                        'member_first_name' => $member_first_name,
                        'member_last_name_yomi' => $member_last_name_yomi,
                        'member_first_name_yomi' => $member_first_name_yomi,     
                        'gender' => $gender,
                        'birthday' => $birthday,
                        'tel' => $tel,
                        'mailaddress' => $mailaddress,
                        'school_cd' => $school_cd,
                        'majorsubject_cd' => $majorsubject_cd,
                        'admission_yearmonth' => $admission_yearmonth,
                        'graduation_yearmonth' => $graduation_yearmonth,
                        'emergencycontact_relations' => $emergencycontact_relations,
                        'emergencycontact_tel' => $emergencycontact_tel,
                        'remarks' => $remarks,
                        'registration_status' => $registration_status,
                        'updated_by' => $operator,          
                    ]
                );
            }
    
        } catch (Exception $e) {            
            
            $ErrorMessage = '【メンバーマスタ登録エラー】' . $e->getMessage();            

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

        session()->flash('success', 'データを登録しました。');
        session()->flash('message-type', 'success');
        return response()->json(['ResultArray' => $ResultArray]);
    }

    //  論理削除処理
    function delete_or_restore(Request $request)
    {
        $delete_flg = intval($request->delete_flg);

        $member_id = intval($request->delete_member_id);
        $member_name = $request->delete_member_name;        

        try {

            
            if($delete_flg == 0){

                //論理削除
                member_m_model::
                where('member_id', $member_id)                
                ->delete();
                   
                session()->flash('success', '[メンバーID = ' . $member_id . ' メンバー名 = ' . $member_name . ']データを利用不可状態にしました');                                

            }else{    

                //論理削除解除
                member_m_model::
                where('member_id', $member_id) 
                ->withTrashed()
                ->restore();

                session()->flash('success', '[メンバーID = ' . $member_id . ' メンバー名 = ' . $member_name . ']データを利用可能状態にしました');                                
            }

        } catch (Exception $e) {

            $ErrorMessage = '【メンバーマスタ利用状況変更処理時エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

            session()->flash('error', '[メンバーID = ' . $member_id . ' メンバー名 = ' . $member_name . ']データの利用状況変更処理時エラー'); 
           
        }       

        return back();
    }


    // ログイン情報重複確認処理
    function login_info_check(request $request){

        $member_id = $request->member_id;
        $login_id = $request->login_id;
        //画面で入力した平文パスワードを暗号化
        $password = common::encryption($request->password);
                
        try {

            $login_id_duplication = "";
            $password_duplication = "";

            //ログインIDでデータ重複チェック
            $login_id_check = member_password_t_model::
            where('login_id', $login_id)   
            ->where('member_id', '<>', $member_id)              
            ->first();

            if(!is_null($login_id_check)){
                $login_id_duplication = "ログインID重複エラー";
            }

            //パスワード（暗号文）でデータ重複チェック
            $login_id_check = member_password_t_model::
            where('password', $password)  
            ->where('member_id', '<>', $member_id)                    
            ->first();

            if(!is_null($login_id_check)){
                $password_duplication = "パスワード重複エラー";
            }

            if($login_id_duplication == "" && $password_duplication == ""){
                      
                $ResultArray = array(
                    "Result" => "success",
                    "Message" => '',
                );

            }else{

                $ResultArray = array(
                    "Result" => "duplication_error",
                    "login_id_duplication" => $login_id_duplication,
                    "password_duplication" => $password_duplication,
                );

            }         


        } catch (Exception $e) {

            $ErrorMessage = '【メンバーログイン情報確認エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

            $ResultArray = array(
                "Result" => "error",
                "Message" => $ErrorMessage,
            );           
         
        }  

        return response()->json(['ResultArray' => $ResultArray]);

    }

    // ログイン情報更新処理
    function login_info_update(request $request)
    {
        
        $id = intval($request->logininfo_password_id);
        $member_id = intval($request->logininfo_member_id);
        $login_id = $request->login_id;
        //画面で入力した平文パスワードを暗号化
        $password = common::encryption($request->password);
        $operator = session()->get('member_id');
        
        try {
    
            DB::connection('mysql')->beginTransaction();

            //メンバーIDで全てのデータの論理削除
            member_password_t_model::
            where('member_id', $member_id)                    
            ->delete();

            //新規登録処理                
            member_password_t_model::create(
                [
                    'member_id' => $member_id,                        
                    'login_id' => $login_id,     
                    'password' => $password,               
                    'created_by' => $operator,                        
                ]
            );          

            session()->flash('success', '[メンバーID = ' . $member_id . ']のログイン情報を変更しました。');                

            DB::connection('mysql')->commit();

        } catch (Exception $e) {

            DB::connection('mysql')->rollBack();

            $ErrorMessage = '【ログイン情報変更処理時エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);
            
            session()->flash('error', '[メンバーID = ' . $member_id . ']のログイン情報を変更時にエラーが発生しました。');                

        }  

        return back();

    }

}
