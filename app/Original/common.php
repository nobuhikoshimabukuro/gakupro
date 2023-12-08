<?php

namespace App\Original;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendErrorMail;
use Carbon\Carbon;
use App\Models\staff_m_model;

use Illuminate\Http\Request;

use Jenssegers\Agent\Agent;

class common
{   
    
    //管理側session確認処理
    public static function headquarters_session_confirmation()
    {
        //返却用変数、初期値はfalse
        $Judge = false;

        // 指定キーがセッションに存在するかを調べる
        if ((session()->exists('staff_id'))) {

            $login_flg = session()->get('login_flg');

            $staff_id = session()->get('staff_id');
            $staff_name = session()->get('staff_name');            
            $staff_name_yomi = session()->get('staff_name_yomi');

            //login_flgが'1'はsession確認OK
            if ($login_flg == 1) {

                //改めてセッションに格納
                session()->put('staff_id', $staff_id);
                session()->put('staff_name', $staff_name);
                session()->put('staff_name_yomi', $staff_name_yomi);
                //ログイン状況をtrueで設定
                session()->put('login_flg', 1);

                $Judge = true;
            }
        }

        return $Judge;
    }

    //管理側ログイン情報を破棄
    public static function headquarters_session_remove() {

        session()->remove('staff_id');
        session()->remove('staff_name');
        session()->remove('staff_name_yomi');
        session()->remove('authority');
        session()->remove('login_flg');
        
        return true;
    }



    //メンバーsession確認処理    
    public static function member_session_confirmation()
    {
        //返却用変数、初期値はfalse
        $Judge = false;

        // 指定キーがセッションに存在するかを調べる
        if ((session()->exists('member_login_flg'))) {

            $login_flg = session()->get('member_login_flg');

            $member_id = session()->get('member_id');
            $member_name = session()->get('member_name');            
            $member_name_yomi = session()->get('member_name_yomi');

            //login_flgが'1'はsession確認OK
            if ($login_flg == 1) {

                //改めてセッションに格納
                session()->put('member_id', $member_id);
                session()->put('member_name', $member_name);
                session()->put('member_name_yomi', $member_name_yomi);
                //ログイン状況をtrueで設定
                session()->put('member_login_flg', 1);

                $Judge = true;
            }
        }

        return $Judge;
    }

    //管理側ログイン情報を破棄
    public static function member_session_remove() {

        session()->remove('member_id');
        session()->remove('member_name');
        session()->remove('member_name_yomi');        
        session()->remove('member_login_flg');
        
        return true;
    }



    //入力画面にてテキストボックス未入力、チェックボックスの未チェックの場合はNullを取得するため
    //Null時に返却してほしい値を第二引数に設定してください。
    //第1引数（$Value）は対象の値
    //第2引数（$ReturnValueWhenNull）はNull時に返却する文字
    public function NullValueConversion($Value , $ReturnValueWhenNull)
    {      
        if (is_null($Value)) {
            $Value = $ReturnValueWhenNull;
        }
        return $Value;
    }
 
    //置換処理
    //第1引数（$TargetString）は検索する目的の文字
    //第2引数（$SearchChar）は検索する文
    //第3引数（$ConvertedChara）は検索した文字を置換する文字     
    public function Replacement($TargetString,$SearchChar,$ConvertedChara)
    {
        $Value = str_replace($SearchChar, $ConvertedChara, $TargetString);
        return $Value;
    }    

    
    //文字埋め処理
    //第1引数（$Target）は文字埋めの対象文
    //第2引数（$Digit）は桁数
    //第3引数（$FillWith）は埋める文字        
    public function FillingProcess($Target,$Digit,$FillWith)
    {
        //$Target = 1 , $Digit = 4 , $FillWith = 0 の場合は、
        //1を4桁の0埋めにするので、"0001"が戻り値
        $Value = str_pad($Target, $Digit, $FillWith, STR_PAD_LEFT);

        return $Value;
    }    

    //処理エラー時にメール送信処理
    //詳細：管理者権限以上のスタッフにメールする
    //第1引数（$Subject）はメールの件名
    //第2引数（$ErrorDetails）はエラー内容          
    public static function SendErrorMail($Subject,$ErrorDetails)
    {

        $Result = true;

        try{

            $staff_m_list = staff_m_model::withTrashed()
            ->where('authority', '>', 2)
            ->orderBy('staff_id', 'asc')
            ->get();

            foreach($staff_m_list as $staffinfo){
                $mailaddress = $staffinfo->mailaddress;
                Mail::to($mailaddress)->send(new SendErrorMail($Subject,$ErrorDetails));
            }
            

        } catch (Exception $e) {


            $error_title = 'メール送信エラー';
            $ErrorMessage = $e->getMessage();
                    
            $log_error_message = $error_title .'::' .$ErrorMessage;
            Log::channel('error_log')->info($log_error_message);
            $Result = false;          
        }
        

        return $Result;
    }    


    //※利用者の端末がPCかそれ以外かチェックする    
    //第1引数 Request $request
    //戻り値 端末情報
    public static function TerminalCheck(Request $request)
    {

        $agent = new Agent();

        // デバイスのチェック
        $isAndroidOS = $agent->isAndroidOS();
        $isPhone = $agent->isPhone();
        $isDesktop = $agent->isDesktop();
        $isTablet = $agent->isTablet();
        $platform = $agent->platform();
        $device = $agent->device();
        $browser = $agent->browser();      

        if($isPhone || $isTablet){
            $pc_flg = 0;
        }else{
            $pc_flg = 1;
        }

        $terminal = 99;                

        if($pc_flg == 0){

            if( is_int(strpos($platform, 'iOS')) || is_int(strpos($device, 'iPhone')) ){

                $terminal = 1;

            }else if( is_int(strpos($platform, 'android')) || is_int(strpos($device, '不明')) ){

                $terminal = 2;                
            }
        
        }else{

            if( is_int(strpos($platform, 'macOS')) || is_int(strpos($device, 'iPhone')) ){

                $terminal = 1;

            }else if( is_int(strpos($platform, 'Windows')) || is_int(strpos($platform, 'windows')) ){

                $terminal = 2;                
            }

        }
     
        $termina_info = array(            
            "pc_flg" => $pc_flg,
            "terminal" => $terminal,           
        );   

        return $termina_info;

    }

    //ランダム文字列作成処理    引数で桁数を指定する
    public static function create_random_letters($length)
    {           
                
        $password = "";
     
        // $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $chars = 'abcdefhkmnpqrstuvwxyzAEFHJKLMNPRSTUVWXY345679';

        $count = mb_strlen($chars);
     
        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $password .= mb_substr($chars, $index, 1);
        }        

        return $password;

    }   

    //ランダム文字列（数字のみ）作成処理    引数で桁数を指定する
    public static function create_random_letters_limited_number($length)
    {           
                
        $password = "";
     
        // $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $chars = '0123456789';

        $count = mb_strlen($chars);
     
        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $password .= mb_substr($chars, $index, 1);
        }        

        return $password;

    }   

    //ランダム文字列作成処理    引数で桁数を指定する
    public static function is_hiragana_or_katakana($str)
    {           
        // ひらがなまたはカタカナの正規表現
        $pattern = '/^[\p{Hiragana}\p{Katakana}ー]+$/u';

        // マッチングを行う
        if (preg_match($pattern, $str)) {
            return true; // ひらがなまたはカタカナのみ
        } else {
            return false; // それ以外の文字が含まれている
        }

    }   


    //※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※
    //※本番稼働後は暗号化キーは絶対に変更してはダメ
    //※$encryption_key = 'yuma';
    //※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※
    // 平文から暗号文
    public static function encryption($plain_text)
    {
        $encryption_key = 'yuma';

        $encrypted_text = openssl_encrypt($plain_text, 'AES-128-ECB', $encryption_key);

        return $encrypted_text;
    }
    
    // 暗号文から平文
    public static function decryption($encrypted_text)
    {
        $encryption_key = 'yuma';
      
        $plain_text = openssl_decrypt($encrypted_text, 'AES-128-ECB', $encryption_key);
       
        return $plain_text;
    }


    //日付のみ、または日時の取得
    public static function get_date($process_branch)
    {           
                
        $return_value = "";
     
        // 現在の日時を取得
        $now = Carbon::now();

        
        if($process_branch == 1){
            //日付のみ
            // MySQLのdate形式に変換
            $date = $now->toDateString();
            $return_value = $date;
        }else{
            //日時
            // MySQLのdatetime形式に変換
            $datetime = $now->toDateTimeString();
            $return_value = $datetime;

        }
     


        return $return_value;

    }   


    // 給与マスタ作成時のデータ生成
    public static function create_salary_data()
    {
        $salary_data = [];
        $comprehensive_index = 1;
        
        
        //時給start        
        $salary_maincategory_cd = 1;
        for($i = 700; $i <= 2000; $i = $i + 100) {

            $salary_data[] = [                
                'salary_subcategory_cd' => $comprehensive_index,
                'salary_maincategory_cd' => $salary_maincategory_cd,
                'salary' => $i,
                'display_order' => $comprehensive_index,
                'created_by' => '9999',
                
            ];

            $comprehensive_index++;
        }

        for($i = 2500; $i <= 5000; $i = $i + 500) {

            $salary_data[] = [                
                'salary_subcategory_cd' => $comprehensive_index,
                'salary_maincategory_cd' => $salary_maincategory_cd,
                'salary' => $i,
                'display_order' => $comprehensive_index,
                'created_by' => '9999',
                
            ];

            $comprehensive_index++;
        }

        //時給End

        //日給start        
        $salary_maincategory_cd = 2;
        for($i = 6000; $i <= 14000; $i = $i + 1000) {

            $salary_data[] = [                
                'salary_subcategory_cd' => $comprehensive_index,
                'salary_maincategory_cd' => $salary_maincategory_cd,
                'salary' => $i,
                'display_order' => $comprehensive_index,
                'created_by' => '9999',
                
            ];

            $comprehensive_index++;
        }

        for($i = 15000; $i <= 30000; $i = $i + 5000) {

            $salary_data[] = [                
                'salary_subcategory_cd' => $comprehensive_index,
                'salary_maincategory_cd' => $salary_maincategory_cd,
                'salary' => $i,
                'display_order' => $comprehensive_index,
                'created_by' => '9999',
                
            ];

            $comprehensive_index++;
        }

        //日給end

        //月給start        
        $salary_maincategory_cd = 3;
        for($i = 70000; $i <= 200000; $i = $i + 10000) {

            $salary_data[] = [                
                'salary_subcategory_cd' => $comprehensive_index,
                'salary_maincategory_cd' => $salary_maincategory_cd,
                'salary' => $i,
                'display_order' => $comprehensive_index,
                'created_by' => '9999',
                
            ];

            $comprehensive_index++;
        }

        for($i = 250000; $i <= 500000; $i = $i + 50000) {

            $salary_data[] = [                
                'salary_subcategory_cd' => $comprehensive_index,
                'salary_maincategory_cd' => $salary_maincategory_cd,
                'salary' => $i,
                'display_order' => $comprehensive_index,
                'created_by' => '9999',
                
            ];

            $comprehensive_index++;
        }
        //月給end

        //年俸start        
        $salary_maincategory_cd = 4;
        for($i = 1000000; $i <= 5000000; $i = $i + 500000) {

            $salary_data[] = [                
                'salary_subcategory_cd' => $comprehensive_index,
                'salary_maincategory_cd' => $salary_maincategory_cd,
                'salary' => $i,
                'display_order' => $comprehensive_index,
                'created_by' => '9999',
                
            ];

            $comprehensive_index++;
        }       
        //年俸end


       
        return $salary_data;
    }
    

}

