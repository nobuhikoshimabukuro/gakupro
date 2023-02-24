<?php
namespace App\Http\Controllers\headquarters;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Original\common;
use Exception;

use App\Models\staff_m_model;
use App\Models\staff_password_t_model;
use App\Models\project_m_model;
use App\Models\staff_with_project_t_model;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use setasign\Fpdi\Tcpdf\Fpdi;
use TCPDF_FONTS;

class headquarters_controller extends Controller
{
    function login()
    {        
       
         //Session確認処理        
         if(common::headquarters_session_confirmation()){
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
        ->get();

        $GetCount = count($staff_password_t_model);
        
        if($GetCount == 0){
            //ログインIDとパスワードで取得できず::NG            

            common::headquarters_session_remove();
            // 認証失敗
            session()->flash('staff_loginerror', '認証失敗');
            return back();

        }elseif($GetCount == 1){
            //ログインIDとパスワードで1件のみ取得::OK

            //暗号化されたパスワードを平文に戻す
            $plain_text = common::decryption($staff_password_t_model[0]->password);

            //平文パスワードとログイン画面で入力したパスワードを整合性確認
            if($plain_text == $password){

                //パスワード一致
                $staff_info = staff_m_model::
                where('staff_id', '=', $staff_password_t_model[0]->staff_id)          
                ->first();
    
                common::headquarters_session_remove();
    
                if(is_null($staff_info)){

                    // スタッフ情報取得できず
                    session()->flash('staff_loginerror', '認証失敗');
                    return back();

                }else{

                    session()->put('staff_id', $staff_info->staff_id);
                    session()->put('staff_name', $staff_info->staff_last_name . "　" . $staff_info->staff_first_name);
                    session()->put('staff_name_yomi', $staff_info->staff_last_name_yomi . "　" . $staff_info->staff_first_name_yomi);                    
                    session()->put('authority', $staff_info->authority);
                    session()->put('login_flg', 1);
        
                    return redirect(route('headquarters.index'));                    
                }
               

            }else{

                //パスワード不一致
                common::headquarters_session_remove();
                // 認証失敗
                session()->flash('staff_loginerror', '認証失敗');
                return back();

            }
                     

        }elseif($GetCount > 1){
            //ログインIDとパスワードで1件以上取得::CriticalError

             //パスワード不一致
             common::headquarters_session_remove();
             // 認証失敗
             session()->flash('staff_loginerror', '認証失敗');
             return back();

        }
        
        
    }

    function logout()
    {     
       
        common::headquarters_session_remove();
         
        return redirect(route('headquarters.login'));
    }

   

    function index()
    {        
        //Session確認処理        
        if(!common::headquarters_session_confirmation()){
            //Session確認で戻り値が(true)時は管理のTop画面に遷移
            return redirect(route('headquarters.login'));            
        }

        // $staff_id = session()->get('staff_id');

        // $project_list = project_m_model::get();

        // $available_list = array();
        
        // foreach($project_list as $info){

        //     $project_id = $info->project_id;
        //     $project_name = $info->project_name;

        //     $staff_with_project_list = staff_with_project_t_model::
        //     where('staff_with_project_t.staff_id', '=', $staff_id)
        //     ->where('staff_with_project_t.project_id', '=', $project_id)
        //     ->first();

        //     $judge = 0;
        //     if(!is_null($staff_with_project_list)){
        //         $judge = 1;
        //     }

        //     $available_info = array($project_name => $judge);

        //     array_push($available_list, $available_info);

        // }        

        return view('headquarters/screen/top');
    }     



    function master_index()
    {        
        //Session確認処理        
        if(!common::headquarters_session_confirmation()){
            //Session確認で戻り値が(true)時は管理のTop画面に遷移
            return redirect(route('headquarters.login'));            
        }

        
        

        return view('headquarters/screen/master/index');
    }     


    function phpinfo()
    {        
       
        //Session確認処理        
        if(!common::headquarters_session_confirmation()){
            //Session確認で戻り値が(true)時は管理のTop画面に遷移
            return redirect(route('headquarters.login'));            
        }

        return view('headquarters/screen/phpinfo');
    }

    
    function photo_project_index()
    {        
        //Session確認処理        
        if(!common::headquarters_session_confirmation()){
            //Session確認で戻り値が(true)時は管理のTop画面に遷移
            return redirect(route('headquarters.login'));            
        }

        return view('headquarters/screen/photo_project/index');        
    }     


    function recruit_project_index()
    {        
       
         //Session確認処理        
         if(!common::headquarters_session_confirmation()){
            //Session確認で戻り値が(true)時は管理のTop画面に遷移
            return redirect(route('headquarters.login'));            
        }

        return view('headquarters/screen/recruit_project/index');
    }

    

    function member_index()
    {

        return view('headquarters/screen/member/index');

        
    }  
    function test()
    {

        $picturebook_info = array();

   
        return view('headquarters/screen/test/index');

        
    }  


    function test1()
    {

        $picturebook_info = array();

        $Saved_Path = "storage/picture_book_project/";           
 
        $Files = glob(public_path($Saved_Path.'*.*'));
       
        foreach ($Files as $FilePath){

            $file = pathinfo($FilePath);            
            $FileName = $file['basename'];

            $PublicPath = asset($Saved_Path . $FileName);

            //配列にアップロードファイルパスとファイル名を格納 
            $Info = array('PublicPath' => $PublicPath , 'FileName' => $FileName);
            array_push($picturebook_info, $Info);
        }

        
        return view('headquarters/screen/test/test1', compact('picturebook_info'));

        
    }  

    function test2()
    {

        return view('headquarters/screen/test/test2');

    }


    function pdf_test()
    {
        $date = "";

        // 横A4サイズのPDF文書を準備
        
        $pdf = new Fpdi('L', 'mm', 'A4');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        //画像挿入
        // https://erabikata.info/tfpdf-fpdi-pdf-template-image-text.html
        
        $pdf->setSourceFile('storage/photo_project/ticket_template/template.pdf');
    
        $importPage = $pdf->importPage(1);

        // ヘッダーの出力.
        $pdf->setPrintHeader(false);
        // フッターの出力.
        $pdf->setPrintFooter(false);

        //表面テンプレートを頁に追加
        $pdf->addPage();

        //テンプレートをページに適用
        $pdf->useTemplate($importPage, 0, 0);

        //１ページ目の自動改ページ設定
        $pdf->SetAutoPageBreak(false);

        //↓ここからテンプレートにコンテンツを描画

        // フォント
        $font = new TCPDF_FONTS();
        
        // フォント：源真ゴシック（下記パスにttfフォントファイルを置いて呼び出せば使用可能）
        // $font_1 = $font->addTTFfont( public_path('eachproject/fsi/fonts/ipaexg.ttf') );
        $pdf->setFont('kozminproregular', '', 10); // ←FPDFの標準日本語フォントはこれだけしかない

        
        $contents = "password";
        $pdf->setXY(100, 10);
        $pdf->write(0, $contents); 

        $password = 9999;
        $pdf->setXY(100, 20);
        $pdf->write(0, $password); 

        $date = "20230218";

        $qr_code_path = 'storage/photo_project/20230218/QrCode';
        $qr_code_name = "QrCode_20230218001.png";
        $qr_code_full_path = $qr_code_path . "/" . $qr_code_name;

        
        //ファイルパスとx, y, w, h, フォーマットを指定しています。
        $pdf->Image($qr_code_full_path , 10, 10, 20, 20, 'PNG');
        

        $create_ticket_path = "public/photo_project/" . $date . "/ticket_create";
        $create_ticket_name = "create.pdf";
        
        $create_ticket_full_path = $create_ticket_path . "/" . $create_ticket_name;

        $content = $pdf->Output($create_ticket_full_path, 'S');

        Storage::put($create_ticket_full_path, $content, 'private');

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
