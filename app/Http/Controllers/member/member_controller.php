<?php
namespace App\Http\Controllers\member;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Original\common;
use Exception;

use App\Models\member_m_model;
use App\Models\member_password_t_model;
use App\Models\project_m_model;
use App\Models\member_with_project_t_model;

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

        return view('member/screen/member_login');
    }

    //ログイン画面にてログインIDとパスワード入力後のチェック処理
    function login_password_check(Request $request)
    {       

        $login_id = $request->login_id;
        $password = $request->password;

        $member_password_t_model = member_password_t_model::
        where('login_id', '=', $login_id)          
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
                    session()->put('login_flg', 1);
        
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


    
    

   

}
