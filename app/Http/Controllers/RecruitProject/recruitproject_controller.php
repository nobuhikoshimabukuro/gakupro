<?php

namespace App\Http\Controllers\RecruitProject;
use App\Http\Controllers\Controller;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailAddressConfirmation;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Original\Common;

use App\Models\employer_m_model;
use App\Models\employer_password_t_model;
use App\Models\job_information_t_model;
use App\Models\mailaddresscheck_t_model;

use App\Repositories\GenderList;
use App\Repositories\AuthorityList;
use App\Repositories\EmployerDivisionList;


use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\employer_m_request;

class recruitproject_controller extends Controller
{
    
    

    function test2(Request $request)
    {
        return view('recruitproject/screen/test2');        
    }  

    //雇用者新規登録前のメールアドレス確認用送信画面遷移
    function mailaddress_temporary_registration(Request $request)
    {
        return view('recruitproject/screen/employer_mailaddress_temporary_registration');        
    }  

    //雇用者新規登録前のメールアドレス仮登録処理＆メール送信処理
    function mailaddress_temporary_registration_process(Request $request)
    {
                
        try {

            $mailaddress = $request->mailaddress;

            while(true){         
                //6桁数字のみのパスワード作成
                $password =  Common::create_random_letters_limited_number(6);
                
                //平文を暗号文に
                $encryption_password = Common::encryption($password);

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
                $key_code =  Common::create_random_letters(8);
                
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
                $cipher =  Common::create_random_letters(8);
                
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
                    ,"mailaddress" => $mailaddress                    
                ]
    
            );           
                    

            $url = route('recruitproject.mailaddress_approval') . '?key_code=' . $key_code . '&cipher=' .$cipher; 
            $subject = "学生応援プロジェクト（確認メール）";

            Mail::to($mailaddress)->send(new SendMailAddressConfirmation($url , $password , $subject));

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
            return view('recruitproject/screen/info');              
            
        }else{
            return view('recruitproject/screen/employer_mailaddress_approval', compact('key_code','cipher'));
        }       

    }

    //メールアドレス確認用パスワード認証処理
    function mailaddress_approval_check(Request $request)
    {

        $key_code = $request->key_code;        
        $cipher = $request->cipher;            
        $encryption_password = Common::encryption($request->password);

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
                session()->flash('employer_mailaddress_approval_error', 'メッセージはviewで');
                return back();

            }elseif($GetCount == 1){
                //ログインIDとパスワードで1件のみ取得::OK

                $mailaddress = $mailaddresscheck_t[0]->mailaddress;
                session()->flash('certification_mailaddress', $mailaddress);          
                return redirect()->route('recruitproject.employer_information_register');

            }elseif($GetCount > 1){
                //ログインIDとパスワードで1件以上取得::CriticalError

            }


        }else{

            // 暗号文と不一致   不正な処理            
            session()->flash('infomessage', 'お送りしたメールのURLから再度遷移してください。');
            return view('recruitproject/screen/info');  

        }

       
    }

     

     
    //雇用者情報確認画面遷移
    function employer_information_confirmation(Request $request)
    {       
        if (!$this->LoginStatusCheck()) {
            //セッション切れ
            session()->flash('employer_loginerror', 'セッション切れ');            
            return redirect()->route('recruitproject.login');
        }

        $employer_id = session()->get('employer_id');

        $employer_info = employer_m_model::
        where('employer_id', '=', $employer_id)          
        ->first();
      
        return view('recruitproject/screen/employer_information_confirmation', compact('employer_info'));        
    }  
    

    //雇用者新規登録画面遷移
    function employer_information_register(Request $request)
    {
        $employer_info = array();        

        $mailaddress = session()->get('certification_mailaddress');

        //mailaddress 取得時は新規登録の雇用者様
        //mailaddress null時は既存の雇用者様
        if(!is_null($mailaddress)){
            $LoginFlg = 0;
        }else{

            if (!$this->LoginStatusCheck()) {
                //セッション切れ
                session()->flash('employer_loginerror', 'セッション切れ');            
                return redirect()->route('recruitproject.login');
            }

            $employer_id = session()->get('employer_id');

            $employer_info = employer_m_model::
            where('employer_id', '=', $employer_id)          
            ->first();

            $LoginFlg = 1;
        }

        $employer_division_list = EmployerDivisionList::get();   

        return view('recruitproject/screen/employer_information_register', compact('mailaddress','employer_info','LoginFlg','employer_division_list'));   

    }    
  

    //雇用者新規登録処理
    function employer_information_save(employer_m_request $request){
        
        try {                       
                            
            DB::connection('mysql')->beginTransaction();

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

                $login_id = Common::create_random_letters(4);
                
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

                $password = Common::create_random_letters_limited_number(6);

                //平文を暗号文に
                $encryption_password = Common::encryption($password);

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

            $this->SessionInfoRemove();

            session()->put('employer_id', $employer_id);
            session()->put('employer_name', $employer_name);
            session()->put('login_flg', 1);
            
            $Url = route('recruitproject.employer_information_after_registration');
            $ResultArray = array(
                "Result" => "success",
                "Message" => '',
                "Url" => $Url ,                
            );

        } catch (Exception $e) {

            DB::connection('mysql')->rollBack();

            $ErrorMessage = 'データ登録時にエラーが発生しました。';

            $ResultArray = array(
                "Result" => "error",
                "Message" => $ErrorMessage,
            );

        
        }

        return response()->json(['ResultArray' => $ResultArray]);
    }

    //雇用者新規登録後の確認画面
    function employer_information_after_registration(Request $request)
    {       

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
        $employer_info->password = Common::decryption($employer_info->encryption_password);
      
        return view('recruitproject/screen/employer_information_after_registration', compact('employer_info'));
        
    }



    //雇用者更新処理画面
    function employer_information_update(employer_m_request $request){

        
        try {

            $employer_id = session()->get('employer_id');
            
            //セッションから取得した$employer_idと画面に隠されている$employer_idを比較する
            if($employer_id != $request->employer_id){

                $ResultArray = array(
                    "Result" => "error",
                    "Message" => "",
                );                
            }
                    
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
                    
                    "employer_name" => $employer_name
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
            $Url = route('recruitproject.employer_information_confirmation');
            $ResultArray = array(
                "Result" => "success",
                "Message" => '',
                "Url" => $Url ,                
            );

        } catch (Exception $e) {

            $ErrorMessage = 'データ更新時にエラーが発生しました。';

            $ResultArray = array(
                "Result" => "error",
                "Message" => $ErrorMessage,
            );        
        }

        return response()->json(['ResultArray' => $ResultArray]);
    }


    function index(Request $request)
    {       

        return view('recruitproject/screen/index');
        
    }    

 
    //ログイン画面遷移
    function login(Request $request)
    {       

        if ($this->LoginStatusCheck()) {
            return redirect()->route('recruitproject.employer_top');
        }        

        return view('recruitproject/screen/employer_login');
    }    

    //ログアウト処理
    function logout(Request $request)
    {       
        
        $this->SessionInfoRemove();

        return redirect()->route('recruitproject.login');
    }    

    //ログイン画面にてログインIDとパスワード入力後のチェック処理
    function login_password_check(Request $request)
    {       

        $login_id = $request->login_id;
        
        //平文を暗号文に
        $password = Common::encryption($request->password);

        $employer_password_t_model = employer_password_t_model::
        where('login_id', '=', $login_id)  
        ->where('password', '=', $password)
        ->get();

        $GetCount = count($employer_password_t_model);
        
        if($GetCount == 0){
            //ログインIDとパスワードで取得できず::NG            

            $this->SessionInfoRemove();
            
            // 認証失敗
            session()->flash('employer_loginerror', '認証失敗');
            return back();

        }elseif($GetCount == 1){
            //ログインIDとパスワードで1件のみ取得::OK


            $employer_info = employer_m_model::
            where('employer_id', '=', $employer_password_t_model[0]->employer_id)          
            ->first();

            $this->SessionInfoRemove();

            session()->put('employer_id', $employer_info->employer_id);
            session()->put('employer_name', $employer_info->employer_name);
            session()->put('login_flg', 1);

            return redirect()->route('recruitproject.employer_top');

        }elseif($GetCount > 1){
            //ログインIDとパスワードで1件以上取得::CriticalError

        }
        
        
    }

    //雇用者用TOP画面遷移
    function employer_top(Request $request)
    {       
        
        if (!$this->LoginStatusCheck()) {
            //セッション切れ
            session()->flash('employer_loginerror', 'セッション切れ');            
            return redirect()->route('recruitproject.login');
        }

        $employer_id = session()->get('employer_id');

        $employer_info = employer_m_model::
        where('employer_id', '=', $employer_id)          
        ->first();

      
        return view('recruitproject/screen/employer_top', compact('employer_info'));
    }    

   

    //求人情報一覧画面遷移
    function job_information_confirmation(Request $request)
    {       
        
        if (!$this->LoginStatusCheck()) {
            //セッション切れ
            session()->flash('employer_loginerror', 'セッション切れ');            
            return redirect()->route('recruitproject.login');
        }

        $employer_id = session()->get('employer_id');

        $employer_info = employer_m_model::
        where('employer_id', '=', $employer_id)          
        ->first();

        //employer_idで過去分の求人登録情報をjob_id順で取得
        $job_information_list = job_information_t_model::
        where('employer_id', '=', $employer_id)
        ->orderBy('job_id', 'asc')
        ->get();

        return view('recruitproject/screen/job_information_confirmation', compact('employer_info','job_information_list'));
    }    


    //求人情報登録更新画面遷移
    function job_information_register(Request $request)
    {       

        if (!$this->LoginStatusCheck()) {
            //セッション切れ
            session()->flash('employer_loginerror', 'セッション切れ');            
            return redirect()->route('recruitproject.login');
        }
       

        $employer_id = session()->get('employer_id');

        $employer_info = employer_m_model::
        where('employer_id', '=', $employer_id)          
        ->first();

        $job_information_info = "";

        //既存の求人情報編集の場合は値が入ってくる
        //新規登録時はnull
        $job_id = $request->job_id;
    
        if(is_null($job_id)){
            //新規登録時
            $job_id = 0;            
          
        }else{

            //既存の求人情報編集時            
            $job_information_info = job_information_t_model::
            where('employer_id', '=', $employer_id)
            ->where('job_id', '=', $job_id)            
            ->first();
        }

        return view('recruitproject/screen/job_information_register', compact('employer_info','job_information_info','job_id'));        
    }


    //求人情報新規登録処理
    function job_information_save(Request $request)
    {       
       
        $Date = Carbon::now()->format('Ymd');

        $employer_id = session()->get('employer_id');        

        $job_id = $request->job_id;

        //新規登録時
        if($job_id == 0){       

            $job_id_Check = job_information_t_model::
            where('employer_id', '=', $employer_id)
            ->max('job_id');

            if(is_null($job_id_Check)){
                $job_id = 1;
            }else{
                $job_id = $job_id_Check + 1;
            }
            
        }


        $title = $request->title;
        $manager_name = $request->manager_name;
        $tel = $request->tel;
        $fax = $request->fax;
        $hp_url = $request->hp_url;
        $mailaddress = $request->mailaddress;
        $remarks = $request->remarks;


        $job_information_info = job_information_t_model::
        where('employer_id', '=', $employer_id)
        ->where('job_id', '=', $job_id)            
        ->first();


        

        $PublicPath = "public/recruitroject/". $employer_id."/jobinformation"."/". $job_id."/";


        //画面で選択したアップロードファイル
        $file_input_1 = $request->file('file_1');

        foreach($file_input_1 as $Count => $file){      

            $Extension = $file->getClientOriginalExtension();

            $FileName = $Count . "." . $Extension;

            $Public_SavePath =  $PublicPath ."area1/";
                
            //画像ファイルデータ取得
            $Image = File::get($file);

            //保存するファイルパス & ファイル名
            $upload_save_path = $Public_SavePath . $FileName;
            Storage::put($upload_save_path, $Image);   
            
        }


        $file_input_2 = $request->file('file_2');

        foreach($file_input_2 as $Count => $file){  
            
            $Extension = $file->getClientOriginalExtension();

            $FileName = $Count . "." . $Extension;


            $Public_SavePath =  $PublicPath ."area2/";
                
            //画像ファイルデータ取得
            $Image = File::get($file);

            //保存するファイルパス & ファイル名
            $upload_save_path = $Public_SavePath . $FileName;
            Storage::put($upload_save_path, $Image);   
            
        }

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
    function SessionInfoRemove() {

        session()->remove('login_flg');
        session()->remove('employer_id');
        session()->remove('employer_name');

    }

     
}
