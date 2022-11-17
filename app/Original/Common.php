<?php

namespace App\Original;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendErrorMail;

use App\Models\staff_m_model;

use Illuminate\Http\Request;


class Common
{   
    
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


            $ErrorTitle = 'メール送信エラー';
            $ErrorMessage = $e->getMessage();
                    
            $LogErrorMessage = $ErrorTitle .'::' .$ErrorMessage;
            Log::channel('error')->error($LogErrorMessage);
            $Result = false;          
        }
        

        return $Result;
    }    


    //※利用者の端末がPCかそれ以外かチェックする    
    //第1引数 Request $request
    //戻り値 PC_FLG (ture = PC , false = PC以外)
    public static function TerminalCheck(Request $request)
    {
        //初期値はture
        $PC_FLG = true;

        //端末判断
        $user_agent = $request->userAgent();
        
        if ((strpos($user_agent, 'iPhone')) || (strpos($user_agent, 'iPod')) || (strpos($user_agent, 'Android'))){              
            $PC_FLG = false;            
        }

        return $PC_FLG;

    }



    
}

