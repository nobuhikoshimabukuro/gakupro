<?php
namespace App\Http\Controllers\Headquarters;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Original\Common;
use Exception;

use App\Models\staff_m_model;
use App\Models\staff_password_t_model;

class headquarters_controller extends Controller
{

    function index()
    {        
       
         //Session確認処理        
         if(!Common::SessionConfirmation()){
            //Session確認で戻り値が(true)時は管理のTop画面に遷移
            return redirect(route('headquarters.login'));            
        }

        return view('headquarters/screen/index');
    }



    function login()
    {        
       
         //Session確認処理        
         if(Common::SessionConfirmation()){
            //Session確認で戻り値が(true)時は管理のTop画面に遷移
            return redirect(route('headquarters.index'));            
        }

        return view('headquarters/screen/staff_login');
    }

    //ログイン画面にてログインIDとパスワード入力後のチェック処理
    function login_password_check(Request $request)
    {       

        $login_id = $request->login_id;
        $password = $request->password;

        $staff_password_t_model = staff_password_t_model::
        where('login_id', '=', $login_id)  
        ->where('password', '=', $password)
        ->get();

        $GetCount = count($staff_password_t_model);
        
        if($GetCount == 0){
            //ログインIDとパスワードで取得できず::NG            

            $this->SessionInfoRemove();
            // 認証失敗
            session()->flash('staff_loginerror', '認証失敗');
            return back();

        }elseif($GetCount == 1){
            //ログインIDとパスワードで1件のみ取得::OK


            $staff_info = staff_m_model::
            where('staff_id', '=', $staff_password_t_model[0]->staff_id)          
            ->first();

            $this->SessionInfoRemove();

            session()->put('staff_id', $staff_info->staff_id);
            session()->put('staff_name', $staff_info->staff_name);
            session()->put('staff_name_yomi', $staff_info->staff_name_yomi);
            session()->put('login_flg', 1);

            return redirect(route('headquarters.index'));  

        }elseif($GetCount > 1){
            //ログインIDとパスワードで1件以上取得::CriticalError

        }
        
        
    }

    function logout()
    {     
       
        $this->SessionInfoRemove();
         
        return view('headquarters/screen/staff_login');
    }

    //ログイン情報を破棄
    function SessionInfoRemove() {

        session()->remove('staff_id');
        session()->remove('staff_name');
        session()->remove('staff_name_yomi');
        session()->remove('login_flg');

    }



    function master_index()
    {        
        return view('headquarters/screen/master/index');
    }     















    //今後共通クラスに移動し実装予定
    function DataBase_BackUp()
    {        

         // Log::channel('normal_log')->info("normal_log");
        // Log::channel('error_log')->info("error_log");
        // Log::channel('emergency_log')->info("emergency_log");
        // Log::channel('database_backup_log')->info("database_backup_log");

        // $this->DataBase_BackUp();

        $DB_DATABASE = env('DB_DATABASE');

        $ToDay = Carbon::now();

        //バックアップ用の新しいDB
        $NewDataBase = $DB_DATABASE . "_" . $ToDay->format('Ymd');

        $CreateDataBase_SQL = "
            CREATE DATABASE IF NOT EXISTS 
            " . $NewDataBase
        ;
            
        DB::connection('mysql')->update($CreateDataBase_SQL);

        //バックアップするDBの全テーブル情報を取得
        $SQL = "
            SELECT
            *
            FROM
            INFORMATION_SCHEMA.TABLES
            WHERE
            TABLE_SCHEMA = '" . $DB_DATABASE . "'"
        ;
                
        $AllTableInfo = DB::connection('mysql')->select($SQL);        

        //バックアップ対象外のテーブルを格納
        $NotApplicableTable = [
                'migrations'
               ,'personal_access_tokens'              
        ];

        foreach($AllTableInfo as $Info){

            try{

                $TABLE_NAME = $Info->TABLE_NAME;

                //バックアップ対象外のテーブル時は、次周
                if(in_array($TABLE_NAME, $NotApplicableTable)) {
                    continue;
                }

                //バックアップDBに既にテーブルがある時のテーブル削除
                $DropTable_SQL = "
                    DROP TABLE IF EXISTS " . $NewDataBase . "." . $TABLE_NAME
                ;
                
                DB::connection('mysql')->update($DropTable_SQL);

                //バックアップ元のDBからバックアップ先のDBに同じテーブル名で作成
                $CreateTable_SQL = "
                CREATE TABLE " . $NewDataBase . "." . $TABLE_NAME . 
                "
                 SELECT * FROM " . $DB_DATABASE . "." . $TABLE_NAME
                ;
                
                Log::channel('database_backup_log')->info('DataBaseName【' . $NewDataBase . '】TableName【' . $TABLE_NAME . '】バックアップ成功');

                DB::connection('mysql')->update($CreateTable_SQL);

            } catch (Exception $e) {              

                $ErrorMessage = 'バックアップエラー!!TableName【'.$TABLE_NAME .'】'. $e->getMessage();
                
                Log::channel('database_backup_log')->info($ErrorMessage);               
            }
        
        }
       
    }
}
