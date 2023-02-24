<?php
namespace App\Http\Controllers\member;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Original\common;
use App\Original\create_list;
use Exception;

use App\Http\Requests\member_m_request;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailAddressConfirmation;

use App\Models\member_m_model;
use App\Models\member_password_t_model;
use App\Models\project_m_model;
use App\Models\member_with_project_t_model;
use App\Models\mailaddresscheck_t_model;
use App\Models\school_m_model;
use App\Models\majorsubject_m_model;



class member_controller extends Controller
{

    //トップ画面遷移
    function top()
    {            
        //Session確認処理        
        if(!common::member_session_confirmation()){
            //Session確認で戻り値が(true)時は管理のTop画面に遷移 
            return redirect(route('member.login'));                 
            
        }

        return view('member/screen/top');
    }   

    //ログイン画面遷移
    function login()
    {        
       
        //Session確認処理        
        if(common::member_session_confirmation()){
            //Session確認で戻り値が(true)時は管理のTop画面に遷移 
            return redirect(route('member.top'));
        }

        return view('member/screen/login');
    }

    //ログイン画面にてログインIDとパスワード入力後のチェック処理
    function login_password_check(Request $request)
    {       

        $mailaddress = $request->mailaddress;
        $password = $request->password;

        $member_password_t_model = member_password_t_model::
        where('mailaddress', '=', $mailaddress)          
        ->get();

        $GetCount = count($member_password_t_model);
        
        if($GetCount == 0){
            //ログインIDとパスワードで取得できず::NG            

            common::member_session_remove();
            // 認証失敗
            session()->flash('member_loginerror', '認証失敗');
            return back();

        }elseif($GetCount == 1){
            //ログインIDとパスワードで1件のみ取得::OK

            //暗号化されたパスワードを平文に戻す
            $plain_text = common::decryption($member_password_t_model[0]->password);

            //平文パスワードとログイン画面で入力したパスワードを整合性確認
            if($plain_text == $password){

                //パスワード一致
                $member_info = member_m_model::
                where('member_id', '=', $member_password_t_model[0]->member_id)          
                ->first();
    
                common::member_session_remove();
    
                if(is_null($member_info)){

                    // スタッフ情報取得できず
                    session()->flash('member_loginerror', '認証失敗');
                    return back();

                }else{

                    session()->put('member_id', $member_info->member_id);
                    session()->put('member_name', $member_info->member_last_name . "　" . $member_info->member_first_name);
                    session()->put('member_name_yomi', $member_info->member_last_name_yomi . "　" . $member_info->member_first_name_yomi);                    
                    session()->put('member_login_flg', 1);
        
                    return redirect(route('member.top'));
                }
               

            }else{

                //パスワード不一致
                common::member_session_remove();
                // 認証失敗
                session()->flash('member_loginerror', '認証失敗');
                return back();

            }
                     

        }elseif($GetCount > 1){
            //ログインIDとパスワードで1件以上取得::CriticalError

             //パスワード不一致
             common::member_session_remove();
             // 認証失敗
             session()->flash('member_loginerror', '認証失敗');
             return back();

        }
        
        
    }

    function logout()
    {            
        common::member_session_remove();
         
        return redirect(route('member.login'));
    }


    //学生メンバー新規登録前のメールアドレス確認用送信画面遷移
    function mailaddress_temporary_registration(Request $request)
    {
        return view('member/screen/mailaddress_temporary_registration');        
    }  
    
    //学生メンバー新規登録前のメールアドレス仮登録処理＆メール送信処理
    function mailaddress_temporary_registration_process(Request $request)
    {
                
        try {

            $mailaddress = $request->mailaddress;
            $destination_name = $request->destination_name;

            while(true){         
                //6桁数字のみのパスワード作成
                $password =  common::create_random_letters_limited_number(6);
                
                //平文を暗号文に
                $encryption_password = common::encryption($password);

                $check_password = mailaddresscheck_t_model::withTrashed()
                ->where('password', '=', $encryption_password)                        
                ->exists();

                if(!$check_password){
                    //繰返しの強制終了
                    break; 
                }            
            }

            while(true){         

                //6桁のランダム文字列
                $key_code =  common::create_random_letters(8);
                
                $check_key_code = mailaddresscheck_t_model::withTrashed()
                ->where('key_code', '=', $key_code)                        
                ->exists();

                if(!$check_key_code){
                    //繰返しの強制終了
                    break; 
                }            
            }

            while(true){         

                //6桁のランダム文字列
                $cipher =  common::create_random_letters(8);
                
                $check_cipher = mailaddresscheck_t_model::withTrashed()
                ->where('cipher', '=', $cipher)                        
                ->exists();

                if(!$check_cipher){
                    //繰返しの強制終了
                    break; 
                }            
            }

            mailaddresscheck_t_model::create(
                [
                    "password" => $encryption_password
                    ,"key_code" => $key_code
                    ,"cipher" => $cipher
                    ,"destination_name" => $destination_name
                    ,"mailaddress" => $mailaddress                    
                ]
    
            );           
                    

            $url = route('member.mailaddress_approval') . '?key_code=' . $key_code . '&cipher=' .$cipher; 
            $subject = "学生応援プロジェクト（確認メール）";

            Mail::to($mailaddress)->send(new SendMailAddressConfirmation($subject , $destination_name , $url , $password));

        } catch (Exception $e) {

            
            $ErrorMessage = 'メール送信処理でエラーが発生しました。';

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

        return response()->json(['ResultArray' => $ResultArray]);

    }  

    //メールアドレス確認用パスワード入力画面
    function mailaddress_approval(Request $request)
    {

        $key_code = $request->key_code;       
        $cipher = $request->cipher;      
        
        //mailaddresscheck_tからデータを取得
        $mailaddresscheck_t_info = mailaddresscheck_t_model::withTrashed()                   
        ->where('key_code', '=', $key_code)          
        ->where('cipher', '=', $cipher)  
        ->first();   

        //key_codeと暗号文でデータが存在すればOK

        if(is_null($mailaddresscheck_t_info)){

            // 暗号文と不一致   不正な処理           
            session()->flash('infomessage', 'お送りしたメールのURLから再度遷移してください。');
            return view('member/screen/info');              
            
        }else{
            return view('member/screen/mailaddress_approval', compact('key_code','cipher'));
        }       

    }
   
    //メールアドレス確認用パスワード認証処理
    function mailaddress_approval_check(Request $request)
    {

        $key_code = $request->key_code;        
        $cipher = $request->cipher;            
        $encryption_password = common::encryption($request->password);

        //mailaddresscheck_tからデータを取得
        $mailaddresscheck_t_info = mailaddresscheck_t_model::withTrashed()                   
        ->where('key_code', '=', $key_code)          
        ->where('cipher', '=', $cipher)  
        ->first();   
        
        if(!is_null($mailaddresscheck_t_info)){

                        
            $mailaddresscheck_t = mailaddresscheck_t_model::
            where('key_code', '=', $key_code)
            ->where('cipher', '=', $cipher)
            ->where('password', '=', $encryption_password)  
            ->get();

            $GetCount = count($mailaddresscheck_t);
            
            if($GetCount == 0){
                //ログインIDとパスワードで取得できず::NG            

                // 認証失敗
                session()->flash('mailaddress_approval_error', 'メッセージはviewで');
                return back();

            }elseif($GetCount == 1){
                //ログインIDとパスワードで1件のみ取得::OK

                $mailaddress = $mailaddresscheck_t[0]->mailaddress;
                session()->flash('certification_mailaddress', $mailaddress);          
                return redirect()->route('member.information_register');

            }elseif($GetCount > 1){
                //ログインIDとパスワードで1件以上取得::CriticalError

            }


        }else{

            // 暗号文と不一致   不正な処理            
            session()->flash('infomessage', 'お送りしたメールのURLから再度遷移してください。');
            return view('member/screen/info');  

        }

       
    }


   //雇用者新規登録画面遷移
   function information_register(Request $request)
   {
        $employer_info = array();        

        $mailaddress = session()->get('certification_mailaddress');        

        //プルダウン作成の為
        $gender_list = create_list::gender_list();
        
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


       return view('member/screen/information_register', compact('mailaddress','gender_list','school_division_list','school_list','majorsubject_list'));

   }    

   function information_save(member_m_request $request){

        //$process_flg = intval($request->process_flg);
        
        $process_flg = 0;

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
                        'registration_status' => $registration_status,
                        'updated_by' => $operator,          
                    ]
                );
            }
    
        } catch (Exception $e) {            
            
            $ErrorMessage = '【新学生メンバー登録エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

            $ResultArray = array(
                "Result" => "error",                
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

   

}
