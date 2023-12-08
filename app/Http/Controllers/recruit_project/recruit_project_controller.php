<?php

namespace App\Http\Controllers\recruit_project;

// Log::channel('info_log')->info($process_title . "");
// Log::channel('send_mail_log')->info($process_title . "");
// Log::channel('important_log')->info($process_title . "");
// Log::channel('error_log')->info($process_title . "");
// Log::channel('emergency_log')->info($process_title . "");
// Log::channel('database_backup_log')->info($process_title . "");

use App\Http\Controllers\Controller;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailAddressConfirmation;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use setasign\Fpdi\Tcpdf\Fpdi;

use App\Original\common;
use App\Original\create_list;
use App\Original\get_data;
use App\Original\job_related;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\employer_m_request;


use App\Models\employer_m_model;
use App\Models\employer_password_t_model;
use App\Models\job_information_t_model;
use App\Models\mailaddress_check_t_model;

use App\Models\salary_maincategory_m_model;
use App\Models\salary_subcategory_m_model;

use App\Models\employment_status_connection_t_model;
use App\Models\employment_status_m_model;



use App\Models\job_maincategory_m_model;
use App\Models\job_subcategory_m_model;
use App\Models\job_category_connection_t_model;

use App\Models\job_supplement_maincategory_m_model;
use App\Models\job_supplement_subcategory_m_model;
use App\Models\job_supplement_connection_t_model;

use App\Models\job_search_history_t_model;

use App\Models\job_password_t_model;
use App\Models\job_password_connection_t_model;



class recruit_project_controller extends Controller
{
    
    

    function test2(Request $request)
    {
        return view('recruit_project/screen/test2');        
    }  

    //雇用者新規登録前のメールアドレス確認用送信画面遷移
    function mailaddress_temporary_registration(Request $request)
    {
        return view('recruit_project/screen/mailaddress_temporary_registration');        
    }  

    //雇用者新規登録前のメールアドレス仮登録処理＆メール送信処理
    function mailaddress_temporary_registration_process(Request $request)
    {
                
        $process_title = "【雇用者メールアドレス仮登録処理】";
        try {

            $mailaddress = $request->mailaddress;
            $destination_name = $request->destination_name;

            while(true){         
                //6桁数字のみのパスワード作成
                $password =  common::create_random_letters_limited_number(6);
                
                //平文を暗号文に
                $encryption_password = common::encryption($password);

                $check_password = mailaddress_check_t_model::withTrashed()
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
                
                $check_key_code = mailaddress_check_t_model::withTrashed()
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
                
                $check_cipher = mailaddress_check_t_model::withTrashed()
                ->where('cipher', '=', $cipher)                        
                ->exists();

                if(!$check_cipher){
                    //繰返しの強制終了
                    break; 
                }            
            }

            mailaddress_check_t_model::create(
                [
                    "password" => $encryption_password
                    ,"key_code" => $key_code
                    ,"cipher" => $cipher
                    ,"destination_name" => $destination_name
                    ,"mailaddress" => $mailaddress                    
                ]
    
            );           
                    

            $url = route('recruit_project.mailaddress_approval') . '?key_code=' . $key_code . '&cipher=' .$cipher; 
            $subject = "学生応援プロジェクト（確認メール）";

            Log::channel('send_mail_log')->info($process_title . "destination_name[" . $destination_name ."]mailaddress[" . $mailaddress . "]【Start】");
            Mail::to($mailaddress)->send(new SendMailAddressConfirmation($subject , $destination_name , $url , $password));
            Log::channel('send_mail_log')->info($process_title . "destination_name[" . $destination_name ."]mailaddress[" . $mailaddress . "]【End】");
        } catch (Exception $e) {

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "destination_name[" . $destination_name ."]mailaddress[" . $mailaddress . "]error_message【" . $error_message ."】");

            $ErrorMessage = 'メール送信処理でエラーが発生しました。';

            $result_array = array(
                "Result" => "error",
                "Message" => $ErrorMessage,
            );        
            return response()->json(['result_array' => $result_array]);
        }

        $result_array = array(
            "Result" => "success",
            "Message" => '',
        );

        return response()->json(['result_array' => $result_array]);

    }  

    //メールアドレス確認用パスワード入力画面
    function mailaddress_approval(Request $request)
    {

        $process_title = "【メールアドレス確認用パスワード入力画面遷移】";

        $key_code = $request->key_code;       
        $cipher = $request->cipher;      
        
        //mailaddress_check_tからデータを取得
        $mailaddress_check_t_info = mailaddress_check_t_model::withTrashed()                   
        ->where('key_code', '=', $key_code)          
        ->where('cipher', '=', $cipher)  
        ->first();   

        //key_codeと暗号文でデータが存在すればOK

        if(is_null($mailaddress_check_t_info)){

            Log::channel('emergency_log')->info($process_title . "key_code[" . $key_code ."]cipher[" . $cipher . "]【データ異常】");

            // 暗号文と不一致   不正な処理           
            session()->flash('infomessage', 'お送りしたメールのURLから再度遷移してください。');
            return view('recruit_project/screen/info');              
            
        }else{
            return view('recruit_project/screen/mailaddress_approval', compact('key_code','cipher'));
        }       

    }

    //メールアドレス確認用パスワード認証処理
    function mailaddress_approval_check(Request $request)
    {

        $process_title = "【メールアドレス確認用パスワード認証処理】";

        $key_code = $request->key_code;        
        $cipher = $request->cipher;            
        $password = $request->password;
        $encryption_password = common::encryption($password);

        //mailaddress_check_tからデータを取得
        $mailaddress_check_t_info = mailaddress_check_t_model::withTrashed()                   
        ->where('key_code', '=', $key_code)          
        ->where('cipher', '=', $cipher)  
        ->first();   
        
        if(!is_null($mailaddress_check_t_info)){

                        
            $mailaddress_check_t = mailaddress_check_t_model::
            where('key_code', '=', $key_code)
            ->where('cipher', '=', $cipher)
            ->where('password', '=', $encryption_password)  
            ->get();

            $GetCount = count($mailaddress_check_t);
            
            if($GetCount == 0){
                //ログインIDとパスワードで取得できず::NG            

                // 認証失敗
                session()->flash('authentication_error', 'メッセージはviewで');
                return back();

            }elseif($GetCount == 1){
                //ログインIDとパスワードで1件のみ取得::OK

                $mailaddress = $mailaddress_check_t[0]->mailaddress;
                session()->flash('certification_mailaddress', $mailaddress); 
                //雇用者情報編集画面遷移         
                return redirect()->route('recruit_project.information_register_insert');

            }elseif($GetCount > 1){                

                Log::channel('emergency_log')->info($process_title . "key_code[" . $key_code ."]cipher[" . $cipher . "]password[" . $password . "]【件数異常】");

            }


        }else{

            // 暗号文と不一致   不正な処理            
            session()->flash('infomessage', 'お送りしたメールのURLから再度遷移してください。');
            return view('recruit_project/screen/info');  

        }

       
    }

     

     
    //雇用者情報確認画面遷移
    function information_confirmation(Request $request)
    {       
        if (!$this->LoginStatusCheck()) {
            //セッション切れ
            session()->flash('employer_loginerror', '再度ログインお願い致します。');            
            return redirect()->route('recruit_project.login');
        }

        $employer_id = session()->get('employer_id');

        $employer_info = employer_m_model::
        where('employer_id', '=', $employer_id)          
        ->first();
      
        return view('recruit_project/screen/information_confirmation', compact('employer_info'));        
    }  
    

    //雇用者情報新規登録画面遷移
    function information_register_insert(Request $request)
    {
        $process_title = "【雇用者情報新規登録画面遷移】";

        $employer_info = array();        

        //仮登録のメールアドレスを取得しメールアドレスがあれば仮登録
        $mailaddress = session()->get('certification_mailaddress');
        
        if(!is_null($mailaddress)){
            $login_flg = 0;       
        }

        $employer_division_list = create_list::employer_division_list();   

        return view('recruit_project/screen/information_register', compact('mailaddress','employer_info','login_flg','employer_division_list'));   

    }    
  
    //雇用者情報更新画面遷移
    function information_register_update(Request $request)
    {
        $process_title = "【雇用者情報更新画面遷移】";

        $employer_info = array();       
           
        if (!$this->LoginStatusCheck()) {
            //セッション切れ
            session()->flash('employer_loginerror', '再度ログインお願い致します。');            
            return redirect()->route('recruit_project.login');
        }

        $employer_id = session()->get('employer_id');

        $employer_info = employer_m_model::
        where('employer_id', '=', $employer_id)          
        ->first();

        $login_flg = 1;     

        $employer_division_list = create_list::employer_division_list();   

        return view('recruit_project/screen/information_register', compact('employer_info','login_flg','employer_division_list'));   

    }

    //雇用者新規登録処理
    function information_save(employer_m_request $request){
        
        try {                       
        
            $process_title = "【雇用者情報新規登録処理】";

            DB::connection('mysql')->beginTransaction();

            $employer_division = $request->employer_division;
            $employer_name = $request->employer_name;            
            $employer_name_kana = $request->employer_name_kana;
            $post_code = $request->post_code;            
            $tel = $request->tel;
            $fax = $request->fax;            
            $mailaddress = $request->mailaddress;
            $address1 = $request->address1;
            $address2 = $request->address2;

            $hp_url = $request->hp_url;

            //新規作成処理                
            $employer_id = employer_m_model::max('employer_id');

            if(is_null($employer_id)){
                $employer_id = 1;
            }else{
                $employer_id = $employer_id + 1;
            }

            //employer_idの重複チェック
            while(true){

                $employer_id_check = employer_m_model::withTrashed()
                ->where('employer_id', '=', $employer_id)                        
                ->exists();

                if(!$employer_id_check){
                    //繰返しの強制終了
                    break; 
                }

                $employer_id = $employer_id + 1;
                
            }
          

            employer_m_model::create(
                [
                    "employer_id" => $employer_id
                    ,"employer_division" => $employer_division                    
                    ,"employer_name" => $employer_name
                    ,"employer_name_kana" => $employer_name_kana
                    ,"post_code" => $post_code
                    ,"address1" => $address1
                    ,"address2" => $address2
                    ,"tel" => $tel
                    ,"fax" => $fax
                    ,"hp_url" => $hp_url
                    ,"mailaddress" => $mailaddress
                ]
    
            );            

            //login_idの重複チェック
            while(true){ 

                $login_id = common::create_random_letters(4);
                
                $login_id_check = employer_password_t_model::withTrashed()
                ->where('login_id', '=', $login_id)                        
                ->exists();

                if(!$login_id_check){

                    //繰返しの強制終了
                    break; 
                }                
            }

            //パスワードの重複チェック
            while(true){ 

                $password = common::create_random_letters_limited_number(6);

                //平文を暗号文に
                $encryption_password = common::encryption($password);

                $password_check = employer_password_t_model::withTrashed()
                ->where('password', '=', $encryption_password)                        
                ->exists();

                if(!$password_check){

                    //繰返しの強制終了
                    break; 
                }

            }

            

            employer_password_t_model::create(
                [
                    "employer_id" => $employer_id
                    ,"login_id" => $login_id
                    ,"password" => $encryption_password
                ]
    
            );      
            

            DB::connection('mysql')->commit();

            common::headquarters_session_remove();

            session()->put('employer_id', $employer_id);
            session()->put('employer_name', $employer_name);
            session()->put('login_flg', 1);
            
            $Url = route('recruit_project.information_after_registration');
            $result_array = array(
                "Result" => "success",
                "Message" => '',
                "Url" => $Url ,                
            );

        } catch (Exception $e) {

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            DB::connection('mysql')->rollBack();

            $ErrorMessage = 'データ登録時にエラーが発生しました。';

            $result_array = array(
                "Result" => "error",
                "Message" => $ErrorMessage,
            );

        
        }

        return response()->json(['result_array' => $result_array]);
    }

    //雇用者新規登録後の確認画面
    function information_after_registration(Request $request)
    {       

        $process_title = "【雇用者情報新規登録処理後確認画面遷移】";

        $employer_id = session()->get('employer_id');

        $employer_info = employer_m_model::select(
            'employer_m.employer_name as employer_name',
            'employer_m.employer_name_kana as employer_name_kana',  

            'employer_password_t.login_id as login_id',
            'employer_password_t.password as encryption_password',            

        )->withTrashed()        
        ->leftJoin('employer_password_t', function ($join) {
            $join->on('employer_m.employer_id', '=', 'employer_password_t.employer_id');
        })
        ->where('employer_m.employer_id', '=', $employer_id)
        ->first();

        //暗号文を平文にして再格納
        $employer_info->password = common::decryption($employer_info->encryption_password);
      
        return view('recruit_project/screen/information_after_registration', compact('employer_info'));
        
    }



    //雇用者更新処理画面
    function information_update(employer_m_request $request){

        
        try {

            $process_title = "【雇用者情報更新処理】";

            $employer_id = session()->get('employer_id');
            
            //セッションから取得した$employer_idと画面に隠されている$employer_idを比較する
            if($employer_id != $request->employer_id){

                $result_array = array(
                    "Result" => "error",
                    "Message" => "",
                );                
            }
                    
            $employer_division = $request->employer_division;
            $employer_name = $request->employer_name;
            $employer_name_kana = $request->employer_name_kana;
            $post_code = $request->post_code;
            $address1 = $request->address1;
            $address2 = $request->address2;
            $tel = $request->tel;
            $fax = $request->fax;
            $hp_url = $request->hp_url;
            $mailaddress = $request->mailaddress;

            
            //更新処理
            employer_m_model::where('employer_id', $employer_id)
            ->update(
                [
                    
                    "employer_division" => $employer_division
                    ,"employer_name" => $employer_name
                    ,"employer_name_kana" => $employer_name_kana
                    ,"post_code" => $post_code
                    ,"address1" => $address1
                    ,"address2" => $address2
                    ,"tel" => $tel
                    ,"fax" => $fax
                    ,"hp_url" => $hp_url
                    ,"mailaddress" => $mailaddress                
                ]
            );
      

            session()->flash('success', 'データを更新しました。');
            $Url = route('recruit_project.information_confirmation');
            $result_array = array(
                "Result" => "success",
                "Message" => '',
                "Url" => $Url ,                
            );

        } catch (Exception $e) {

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            $ErrorMessage = 'データ更新時にエラーが発生しました。';

            $result_array = array(
                "Result" => "error",
                "Message" => $ErrorMessage,
            );        
        }

        return response()->json(['result_array' => $result_array]);
    }


    function index(Request $request)
    {       

        return view('recruit_project/screen/index');
        
    }    

 
    //ログイン画面遷移
    function login(Request $request)
    {       

        if ($this->LoginStatusCheck()) {
            return redirect()->route('recruit_project.top');
        }        

        return view('recruit_project/screen/login');
    }    

    //ログアウト処理
    function logout(Request $request)
    {       
        
        common::headquarters_session_remove();

        return redirect()->route('recruit_project.login');
    }    

    //ログイン画面にてログインIDとパスワード入力後のチェック処理
    function login_password_check(Request $request)
    {       

        try {

            $process_title = "【雇用者ログイン認証処理】";

            $login_id = $request->login_id;
            
            //平文を暗号文に
            $password = common::encryption($request->password);

            $employer_password_t_model = employer_password_t_model::
            where('login_id', '=', $login_id)  
            ->where('password', '=', $password)
            ->get();

            $GetCount = count($employer_password_t_model);
            
            if($GetCount == 0){
                //ログインIDとパスワードで取得できず::NG            

                common::headquarters_session_remove();
                
                // 認証失敗
                session()->flash('employer_loginerror', '認証失敗');
                return back();

            }elseif($GetCount == 1){
                //ログインIDとパスワードで1件のみ取得::OK


                $employer_info = employer_m_model::
                where('employer_id', '=', $employer_password_t_model[0]->employer_id)          
                ->first();

                common::headquarters_session_remove();

                session()->put('employer_id', $employer_info->employer_id);
                session()->put('employer_name', $employer_info->employer_name);
                session()->put('login_flg', 1);

                return redirect()->route('recruit_project.top');

            }elseif($GetCount > 1){
                //ログインIDとパスワードで1件以上取得::CriticalError

                Log::channel('emergency_log')->info($process_title . "【件数異常】");
                
            }
            
        } catch (Exception $e) {

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            // 認証失敗
            session()->flash('employer_loginerror', '認証失敗');
            return back();
            
        }
        
    }

    //雇用者用TOP画面遷移
    function top(Request $request)
    {       
        
        $employer_id = session()->get('employer_id');

        if (!$this->LoginStatusCheck() || is_null($employer_id)) {
            //セッション切れ
            session()->flash('employer_loginerror', '再度ログインお願い致します。');            
            return redirect()->route('recruit_project.login');
        }       

        $employer_info = employer_m_model::
        where('employer_id', '=', $employer_id)          
        ->first();

      
        return view('recruit_project/screen/top', compact('employer_info'));
    }    

   

    //求人情報一覧画面遷移
    function job_information_confirmation(Request $request)
    {       
        
        $employer_id = session()->get('employer_id');

        if (!$this->LoginStatusCheck() || is_null($employer_id)) {
            //セッション切れ
            session()->flash('employer_loginerror', '再度ログインお願い致します。');            
            return redirect()->route('recruit_project.login');
        }       

        $employer_info = employer_m_model::
        where('employer_id', '=', $employer_id)          
        ->first();

        //employer_idで過去分の求人登録情報をjob_id順で取得
        $job_information_list = job_information_t_model::
        where('employer_id', '=', $employer_id)
        ->orderBy('job_id', 'asc')
        ->get();

        $today = common::get_date(1);

        foreach ($job_information_list as $index => $job_information_info){

            $publish_data_flg = 0;
            $publish_data_job_password_id = 0;
            $employer_id = $job_information_info->employer_id;
            $job_id = $job_information_info->job_id;


            //操作日に掲載可能求人か調べる
            $publish_data = job_password_connection_t_model::select(
                
                'job_password_connection_t.job_password_id as job_password_id',
                'job_password_connection_t.branch_number as branch_number',
                'job_password_connection_t.publish_start_date as publish_start_date',
                'job_password_connection_t.publish_end_date as publish_end_date',            
                'job_password_t.job_password_item_id as job_password_item_id',                
            )
            ->leftJoin('job_password_t', function ($join) {
                $join->on('job_password_t.job_password_id', '=', 'job_password_connection_t.job_password_id');
            })        
            ->where('job_password_connection_t.employer_id', '=', $employer_id)
            ->where('job_password_connection_t.job_id', '=', $job_id)
            ->where('job_password_connection_t.publish_start_date', '<=', $today)
            ->where('job_password_connection_t.publish_end_date', '>=', $today)
            ->first();

            if(!is_null($publish_data)){
                $publish_data_flg = 1;
                $publish_data_job_password_id = $publish_data->job_password_id;
            }

            //操作日を限定せず、雇用者IDと求人IDのみで取得
            $job_password_connection_t = job_password_connection_t_model::select(
                
                'job_password_connection_t.job_password_id as job_password_id',
                'job_password_connection_t.branch_number as branch_number',
                'job_password_connection_t.publish_start_date as publish_start_date',
                'job_password_connection_t.publish_end_date as publish_end_date',            
                'job_password_t.job_password_item_id as job_password_item_id',                
            )
            ->leftJoin('job_password_t', function ($join) {
                $join->on('job_password_t.job_password_id', '=', 'job_password_connection_t.job_password_id');
            })        
            ->where('job_password_connection_t.employer_id', '=', $employer_id)
            ->where('job_password_connection_t.job_id', '=', $job_id)            
            ->get();


            
            //雇用者と求人別で求人パスワード履歴をループして、操作日が
            foreach ($job_password_connection_t as $job_password_connection_index => $job_password_connection_info){

                if($job_password_connection_info->job_password_id == $publish_data_job_password_id){
                    $job_password_connection_info->today_publish_flg = 1;
                }else{
                    $job_password_connection_info->today_publish_flg = 0;
                }

            }


            $job_information_info->job_password_connection_t = $job_password_connection_t;
            $job_information_info->publish_data_flg = $publish_data_flg;


        }

        return view('recruit_project/screen/job_information_confirmation', compact('employer_info','job_information_list'));
    }    


    //求人情報登録更新画面遷移
    function job_information_register(Request $request)
    {       

        $employer_id = session()->get('employer_id');

        if (!$this->LoginStatusCheck() || is_null($employer_id)) {
            //セッション切れ
            session()->flash('employer_loginerror', '再度ログインをお願い致します。');            
            return redirect()->route('recruit_project.login');
        }       

        $job_info = null;
        $employment_status_connections = [];
        $job_category_connections = [];
        $job_supplement_category_connections = [];
        $asset_path_array = [];


        $employer_info = employer_m_model::
        where('employer_id', '=', $employer_id)          
        ->first();

        

        //既存の求人情報編集の場合は値が入ってくる
        //新規登録時はnull
        $job_id = $request->job_id;
    
        if(is_null($job_id)){
            //新規登録時
            $job_id = 0;            
          
        }else{

            //既存の求人情報編集時            
            $job_info = job_information_t_model::
            where('employer_id', '=', $employer_id)
            ->where('job_id', '=', $job_id)            
            ->first();

         
        }

        $job_images_path_array = job_related::get_job_images($employer_id,$job_id);

        $employment_status_connection_t = employment_status_connection_t_model::
        where('employer_id', '=', $employer_id)
        ->where('job_id', '=', $job_id)
        ->get();

        foreach ($employment_status_connection_t as $index => $employment_status_connection){            
            $employment_status_connections[] = $employment_status_connection->employment_status_id;
        }


        $job_category_connection_t = job_category_connection_t_model::
        where('employer_id', '=', $employer_id)
        ->where('job_id', '=', $job_id)
        ->get();

        foreach ($job_category_connection_t as $index => $job_category_connection){            
            $job_category_connections[] = $job_category_connection->job_subcategory_cd;
        }

        $job_supplement_connection_t = job_supplement_connection_t_model::
        where('employer_id', '=', $employer_id)
        ->where('job_id', '=', $job_id)            
        ->get();

        foreach ($job_supplement_connection_t as $index => $job_supplement_connection){            
            $job_supplement_category_connections[] = $job_supplement_connection->job_supplement_subcategory_cd;
        }


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

        return view('recruit_project/screen/job_information_register',
         compact(
                 'employer_id'
                ,'employer_info'
                ,'job_id'
                ,'job_info'

                ,'job_images_path_array'
                
                ,'prefectural_list'
                ,'salary_maincategory_list'

                ,'employment_status_data'
                ,'employment_status_connections'

                ,'job_category_data'
                ,'job_category_connections'

                ,'job_supplement_data'
                ,'job_supplement_category_connections'
            ));        
    }


    //求人情報公開フラグ更新処理
    function job_information_publish_flg_change(Request $request)
    {       
        $process_title = "求人情報公開フラグ更新処理";

        try {
            
            $employer_id = session()->get('employer_id');
            $job_id = $request->job_id;
            $publish_flg = $request->publish_flg;

            if(is_null($employer_id)){

                $result_array = array(
                    "Result" => "non_session",
                    "Message" => $process_title."でエラーが発生しました。",
                );            

                //セッション切れ
                session()->flash('employer_loginerror', '再度ログインお願い致します。');    

                return response()->json(['result_array' => $result_array]);
            }           

            $new_publish_flg = 0;

            if($publish_flg == 0){
                
                $new_publish_flg = 1;

            }elseif($publish_flg == 1){

                $new_publish_flg = 0;

            }
            


            job_information_t_model::
                where('employer_id', $employer_id)
                ->where('job_id', $job_id)
                ->update(
                    [
                        'publish_flg' => $new_publish_flg,                        
                    ]
                );


                

            $result_array = array(
                "Result" => "success",
                "Message" => ""
            );       


        } catch (Exception $e) {

            

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");
            
            $result_array = array(
                "Result" => "error",
                "Message" => $process_title."でエラーが発生しました。",
            );                      
                                
        }

        return response()->json(['result_array' => $result_array]);

    }


    //求人掲載期間情報画面遷移
    function job_publish_info(Request $request)
    {       

        $employer_id = session()->get('employer_id');

        if (!$this->LoginStatusCheck() || is_null($employer_id)) {
            //セッション切れ
            session()->flash('employer_loginerror', '再度ログインお願い致します。');            
            return redirect()->route('recruit_project.login');
        }       

        
        $job_id = $request->job_id;

        $job_password_connection_t = job_password_connection_t_model::select(
            
            'job_password_connection_t.job_password_id as job_password_id',
            'job_password_connection_t.branch_number as branch_number',
            'job_password_connection_t.publish_start_date as publish_start_date',
            'job_password_connection_t.publish_end_date as publish_end_date',            
            'job_password_t.job_password_item_id as job_password_item_id',            
        )
        ->leftJoin('job_password_t', function ($join) {
            $join->on('job_password_t.job_password_id', '=', 'job_password_connection_t.job_password_id');
        })        
        ->where('job_password_connection_t.employer_id', '=', $employer_id)
        ->where('job_password_connection_t.job_id', '=', $job_id)
        ->first();



        $job_password_connection_t = job_password_connection_t_model::
        where('employer_id', '=', $employer_id)          
        ->where('job_id', '=', $job_id)          
        ->get();

        $employer_info = employer_m_model::
        where('employer_id', '=', $employer_id)          
        ->first();

        //既存の求人情報編集時            
        $job_info = job_information_t_model::
            where('employer_id', '=', $employer_id)
            ->where('job_id', '=', $job_id)            
            ->first();
        
        if(is_null($job_info)){
            return redirect()->route('recruit_project.job_information_confirmation');
        }
        


        return view('recruit_project/screen/job_publish_info',
        compact(
                 'employer_id'
                ,'employer_info'
                ,'job_id'
                ,'job_info'
                ,'job_password_connection_t'
        ));        
    }

    //求人パスワード確認処理
    function job_password_check(Request $request)
    {       

        $process_title = "求人パスワード確認処理";

        try {

            // キー配列の作成
            $messages = [
                0 => "使用可能なパスワードです。",
                1 => "パスワードが存在しません。再入力してください。",
                2 => "使用済みのパスワードです。"
            ];

            $password = $request->password;
            

            $result_type = $this->job_password_available_check($password);

            
            $result_array = array(
                "Result" => "success",
                "result_type" => $result_type,
                "Message" => $messages[$result_type]
            );       


        } catch (Exception $e) {

            
            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "::error_message【" . $error_message ."】");
            
            $result_array = array(
                "Result" => "error",
                "result_type" => "",
                "Message" => ""
            );                        
                                
        }

        return response()->json(['result_array' => $result_array]);

    }

    //求人パスワード承認処理
    function job_password_authentication(Request $request)
    {       

        $process_title = "求人パスワード承認処理";

        try {

            $employer_id = session()->get('employer_id');

            if(is_null($employer_id)){

                $result_array = array(
                    "Result" => "non_session",
                    "Message" => $process_title."でエラーが発生しました。",
                );            
    
                return response()->json(['result_array' => $result_array]);
            }
            
            DB::connection('mysql')->beginTransaction();


            // キー配列の作成
            $messages = [
                0 => "使用可能なパスワードです。",
                1 => "パスワードが存在しません。再入力してください。",
                2 => "使用済みのパスワードです。"
            ];

            $password = $request->password;
            

            $result_type = $this->job_password_available_check($password);


            DB::connection('mysql')->commit();

            $result_array = array(
                "Result" => "success",
                "Message" => ""
            );       


        } catch (Exception $e) {

            DB::connection('mysql')->rollBack();

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");
            
            $result_array = array(
                "Result" => "error",
                "Message" => $process_title."でエラーが発生しました。",
            );           

            return response()->json(['result_array' => $result_array]);
                                
        }




    }

    //求人パスワードチェック（共通処理）    
    function job_password_available_check($password)
    {    

        $result_type = 0;

        $existence_password = job_password_t_model::
            where('password', '=', $password)                        
            ->where('sale_flg', '=', 1)
            ->exists();

            
        if($existence_password){

            
            $job_password_t = job_password_t_model::
            where('password', '=', $password)                            
            ->where('usage_flg', '=', 0)
            ->where('sale_flg', '=', 1)                
            ->first();

            if(is_null($job_password_t)){

                //パスワードは存在するが、利用フラグがたっている、NG                         
                $result_type = 2;

                
            }else{

                $job_password_id = $job_password_t->job_password_id;

                //求人データと求人パスワードの紐づけチェック
                $job_password_connection_t = job_password_connection_t_model::
                where('job_password_id', '=', $job_password_id)                                  
                ->first();

                if(is_null($job_password_connection_t)){
                        
                    $result_type = 0;

                }else{

                    $result_type = 2;

                }


            }

        }else{

            //パスワードが管理マスタに無いため、NG
            $result_type = 1;

        }

        return $result_type;

    }

    
    function job_information_output_pdf_session(Request $request)
    {

        $employer_id = $request->employer_id;
        $job_id = $request->job_id;

        session()->put('pdf_employer_id', $employer_id);
        session()->put('pdf_job_id', $job_id);

        $result_array = array(
            "result" => "success",            
        );           

        return response()->json(['result_array' => $result_array]);

    }

    function job_information_output_pdf(Request $request)
    {    

        $process_title = "求人情報PDF出力処理";

        try {

            $employer_id = session()->get('pdf_employer_id');
            $job_id = session()->get('pdf_job_id');
            
            
            session()->remove('pdf_employer_id');
            session()->remove('pdf_job_id');


            $job_information_t = job_information_t_model::where('employer_id', $employer_id)
            ->where('job_id', $job_id)
            ->first();



            if(is_null($job_information_t)){

                //pdfテンプレートの保存場所
                $job_information_template_path = public_path("pdf/job_information_template_ng.pdf");        
            
            }else{

                //pdfテンプレートの保存場所
                $job_information_template_path = public_path("pdf/job_information_template.pdf");

            }

            

            // 縦A4サイズのPDF文書を準備
            $pdf = new Fpdi('P', 'mm', 'A4');

            // ヘッダーの出力なし（falseにしないと線が出る）
            $pdf->setPrintHeader(false);
            // フッターの出力なし（同じく）
            $pdf->setPrintFooter(false);
            //自動改ページ設定（自動改ページをさせない）
            $pdf->SetAutoPageBreak(false);

            //１ページ目テンプレートをセット
            $pdf->setSourceFile($job_information_template_path);
            $importPage = $pdf->importPage(1);

            //テンプレートを頁に追加
            $pdf->addPage();

            //テンプレートをページに適用
            $pdf->useTemplate($importPage, 0, 0);


            //↓ここから１ページ目テンプレートにコンテンツを描画
            // フォント
            $pdf->setFont('kozminproregular', '', 25); // ←FPDFの標準日本語フォントはこれだけしかない

            if(is_null($job_information_t)){

                //出力ファイル名
                $output_filename = "job_information_ng.pdf";



            }else{


                //出力ファイル名
                $output_filename = "job_information.pdf";

                $id = $job_information_t->id;
                $employer_id = $job_information_t->employer_id;
                $job_id = $job_information_t->job_id;
                $publish_flg = $job_information_t->publish_flg;
                $title = $job_information_t->title;
                $sub_title = $job_information_t->sub_title;
                $work_location_prefectural_cd = $job_information_t->work_location_prefectural_cd;
                $work_location_municipality_cd = $job_information_t->work_location_municipality_cd;
                $working_time = $job_information_t->working_time;
                $salary = $job_information_t->salary;
                $holiday = $job_information_t->holiday;
                $manager_name = $job_information_t->manager_name;
                $tel = $job_information_t->tel;
                $fax = $job_information_t->fax;
                $hp_url = $job_information_t->hp_url;
                $job_image_folder_name = $job_information_t->job_image_folder_name;
                $mailaddress = $job_information_t->mailaddress;
                $application_requirements = $job_information_t->application_requirements;
                $scout_statement = $job_information_t->scout_statement;
                $remarks = $job_information_t->remarks;

                
                //画像パス設定処理                
                $image_full_path = "";
                for ($i = 1; $i <= 3; $i++) {
                
                    $image_directory_path = public_path("storage/recruit_project/job_image/id_" . $id . "/" . $job_image_folder_name . "/" . $i . "/");

                    //フォルダがあるかチェック
                    if (File::isDirectory($image_directory_path)) {

                        // ディレクトリ内のファイルを取得
                        $files = File::files($image_directory_path);    
                        
                        if (!empty($files)) {
    
                            // ファイル名を取得（ここでは最初のファイルを取得しています）
                            $firstFileName = basename($files[0]);
                            // 完全なファイルパスを生成
                            $image_full_path = $image_directory_path . $firstFileName;
                            break;

                        }
                    }
                }

                
                if($image_full_path != ""){
                    // $imagePathを使ってPDFに画像を挿入する処理を行う
                    // (画像パス, X座標, Y座標, 幅, 高さ)
                    // $pdf->Image($image_full_path, 10, 10, 70, 50); 

                    list($image_width, $image_height) = getimagesize($image_full_path);
                    $pdf->Image($image_full_path, 10, 10, 70 * $image_width / $image_height, 70);
                }


                // RGB参考
                // https://itsakura.com/html-color-codes

                // テキストの色を設定（RGB）
                $pdf->SetTextColor(35,59,108);
                // テキストを配置する座標を設定
                $pdf->SetXY(50, 50);
                // テキストを追加
                $pdf->Cell(0, 10, $title, 0, 1, 'L');
              
            }
            

        } catch (Exception $e) {


            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            //出力ファイル名
            $output_filename = "job_information_ng.pdf";


            //pdfテンプレートの保存場所
            $job_information_template_path = public_path("pdf/job_information_template_ng.pdf");  


            // 縦A4サイズのPDF文書を準備
            $pdf = new Fpdi('P', 'mm', 'A4');

            // ヘッダーの出力なし（falseにしないと線が出る）
            $pdf->setPrintHeader(false);
            // フッターの出力なし（同じく）
            $pdf->setPrintFooter(false);
            //自動改ページ設定（自動改ページをさせない）
            $pdf->SetAutoPageBreak(false);

            //１ページ目テンプレートをセット
            $pdf->setSourceFile($job_information_template_path);
            $importPage = $pdf->importPage(1);

            //テンプレートを頁に追加
            $pdf->addPage();

            //テンプレートをページに適用
            $pdf->useTemplate($importPage, 0, 0);


        }
        
        //完成、ブラウザに表示        
        $pdf->output($output_filename, "I");

    }

    

    //求人情報登録処理
    function job_information_save(Request $request)
    {       
        $process_title = "求人情報登録処理";

        try {

            DB::connection('mysql')->beginTransaction();

            $new_data_flg = false;
            
            //雇用形態データ取得
            $employment_status_data = get_data::employment_status_data();
            //職種データ取得
            $job_category_data = get_data::job_category_data();
            //求人補足データ取得
            $job_supplement_data = get_data::job_supplement_data();

            $a = $request->all();
               

            $employer_id = $request->employer_id;
            $job_id = $request->job_id;
            // $publish_flg = $request->publish_flg;
            $title = $request->title;
            $sub_title = $request->sub_title;
            $work_location_prefectural_cd = $request->work_location_prefectural_cd;
            $work_location_municipality_cd = $request->work_location_municipality_cd;
            $working_time = $request->working_time;
            $salary = $request->salary;
            $holiday = $request->holiday;
            $manager_name = $request->manager_name;
            $tel = $request->tel;
            $fax = $request->fax;
            $hp_url = $request->hp_url;
            $job_image_folder_name = $request->job_image_folder_name;
            $mailaddress = $request->mailaddress;
            $application_requirements = $request->application_requirements;
            $scout_statement = $request->scout_statement;
            $remarks = $request->remarks;


            //新規登録時
            if($job_id == 0){       
                $new_data_flg = true;
                
                $job_id_Check = job_information_t_model::
                where('employer_id', '=', $employer_id)
                ->max('job_id');

                if(is_null($job_id_Check)){
                    $job_id = 1;
                }else{
                    $job_id = $job_id_Check + 1;
                }

            }else{
                $new_data_flg = false;
            }


            if($new_data_flg){

                $job_image_folder_name = $this->create_job_image_folder_name(10);

                job_information_t_model::insert(
                    [                            
                        "employer_id" => $employer_id
                        ,"job_id" => $job_id
                        ,"publish_flg" => 1
                        ,"title" => $title
                        ,"sub_title" => $sub_title
                        ,"work_location_prefectural_cd" => $work_location_prefectural_cd
                        ,"work_location_municipality_cd" => $work_location_municipality_cd
                        ,"working_time" => $working_time
                        ,"salary" => $salary
                        ,"holiday" => $holiday
                        ,"manager_name" => $manager_name
                        ,"tel" => $tel
                        ,"fax" => $fax
                        ,"hp_url" => $hp_url
                        ,"job_image_folder_name" => $job_image_folder_name
                        ,"mailaddress" => $mailaddress
                        ,"application_requirements" => $application_requirements
                        ,"scout_statement" => $scout_statement
                        ,"remarks" => $remarks                        
                    ]
                );

            }else{

                 //更新処理
                 job_information_t_model::where('employer_id', $employer_id)
                 ->where('job_id', $job_id)
                 ->update(
                    [
                    
                     "title" => $title
                    ,"sub_title" => $sub_title
                    ,"work_location_prefectural_cd" => $work_location_prefectural_cd
                    ,"work_location_municipality_cd" => $work_location_municipality_cd
                    ,"working_time" => $working_time
                    ,"salary" => $salary
                    ,"holiday" => $holiday
                    ,"manager_name" => $manager_name
                    ,"tel" => $tel
                    ,"fax" => $fax
                    ,"hp_url" => $hp_url                    
                    ,"mailaddress" => $mailaddress
                    ,"application_requirements" => $application_requirements
                    ,"scout_statement" => $scout_statement
                    ,"remarks" => $remarks                        
                    ]
                 );

            }
            

            


            //求人情報と雇用形態データの連結テーブルの処理  start
            employment_status_connection_t_model::where('employer_id', '=', $employer_id)
            ->where('job_id', '=', $job_id)
            ->forceDelete();

            foreach ($employment_status_data as $index => $employment_status_info){       

                $employment_status_id = $employment_status_info->employment_status_id;

                $target_name = "employment-status-checkbox" . $employment_status_id;

                $data = $request->$target_name;

                if(!is_null($data)){


                    employment_status_connection_t_model::insert(
                        [                            
                            "employer_id" => $employer_id
                            ,"job_id" => $job_id
                            ,"employment_status_id" => intval($employment_status_id)                        
                        ]
                    );

                }

            }
            //求人情報と職種データの連結テーブルの処理  end



            //求人情報と職種データの連結テーブルの処理  start
            job_category_connection_t_model::where('employer_id', '=', $employer_id)
            ->where('job_id', '=', $job_id)
            ->forceDelete();

            foreach ($job_category_data as $index => $job_category_info){       

                $job_subcategory_cd = $job_category_info->job_subcategory_cd;

                $target_name = "job-category-checkbox" . $job_subcategory_cd;

                $data = $request->$target_name;

                if(!is_null($data)){


                    job_category_connection_t_model::insert(
                        [                            
                            "employer_id" => $employer_id
                            ,"job_id" => $job_id
                            ,"job_subcategory_cd" => intval($job_subcategory_cd)                        
                        ]
                    );

                }

            }
            //求人情報と職種データの連結テーブルの処理  end



            //求人情報と職種データの連結テーブルの処理  start
            job_supplement_connection_t_model::where('employer_id', '=', $employer_id)
            ->where('job_id', '=', $job_id)
            ->forceDelete();

            foreach ($job_supplement_data as $index => $job_supplement_info){       

                $job_supplement_subcategory_cd = $job_supplement_info->job_supplement_subcategory_cd;

                $target_name = "job-supplement-checkbox" . $job_supplement_subcategory_cd;

                $data = $request->$target_name;

                if(!is_null($data)){


                    job_supplement_connection_t_model::insert(
                        [                            
                            "employer_id" => $employer_id
                            ,"job_id" => $job_id
                            ,"job_supplement_subcategory_cd" => intval($job_supplement_subcategory_cd)                        
                        ]
                    );

                }

            }
            //求人情報と職種データの連結テーブルの処理  end


            DB::connection('mysql')->commit();

            $update_job_images_result = job_related::update_job_images($request , $employer_id , $job_id);

            if(!$update_job_images_result){

                $error_message = "求人情報画像更新処理でエラーが発生しました。";
                Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");
                
                $result_array = array(
                    "Result" => "error",
                    "message" => $process_title."でエラーが発生しました。",
                );           

                return response()->json(['result_array' => $result_array]);

            }
      


            //全ての処理終了
            $result_array = array(
                "Result" => "success",
                "message" => '',
            );
    
    
            if($new_data_flg){
                $success_message = '求人ID【' . $job_id . '】のデータを登録しました。';
            }else{
                $success_message = '求人ID【' . $job_id . '】のデータを更新しました。';
            }
    
            session()->flash('success', $success_message);
            session()->flash('message-type', 'success');
            return response()->json(['result_array' => $result_array]);       


        } catch (Exception $e) {

            DB::connection('mysql')->rollBack();

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");
            
            $result_array = array(
                "Result" => "error",
                "message" => $process_title."でエラーが発生しました。",
            );           

            return response()->json(['result_array' => $result_array]);
                                
        }



       

    }

    //ランダム文字列作成処理    引数で桁数を指定する
    function create_job_image_folder_name($length)
    {           
                
        $job_image_folder_name = "";            
        $chars = 'abcdefhkmnpqrstuvwxyzAEFHJKLMNPRSTUVWXY';
        $count = mb_strlen($chars);


        while(true){         
            
            for ($i = 0, $result = ''; $i < $length; $i++) {
                $index = rand(0, $count - 1);
                $job_image_folder_name .= mb_substr($chars, $index, 1);
            }        
                
            $job_image_folder_name_check = job_information_t_model::
                where('job_image_folder_name', '=', $job_image_folder_name)
                ->exists();
    
            if(!$job_image_folder_name_check){
                //繰返しの強制終了
                break; 
            }            
        }
     
    
        return $job_image_folder_name;

    }   
    
 
    //ログイン状況を確認  
    function LoginStatusCheck() {

        $Judge = false;

        if (session()->exists('login_flg') && session()->exists('employer_id')) {
            $Judge = true;            
        }
        
        return $Judge;
    }

    //ログイン情報を破棄
    function headquarters_session_remove() {

        session()->remove('login_flg');
        session()->remove('employer_id');
        session()->remove('employer_name');

    }

     
}
