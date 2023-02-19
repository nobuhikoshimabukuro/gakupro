<?php

namespace App\Http\Controllers\photo_project;
use App\Http\Controllers\Controller;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Original\common;

use App\Models\photoget_t_model;

use Illuminate\Http\Request;

use Intervention\Image\Facades\Image;

use Illuminate\Support\Facades\DB;

use STS\ZipStream\ZipStreamFacade AS Zip;

class photo_project_controller extends Controller
{

     
    protected $job_service;

    public function __construct()
    {
        $this->job_service = 1;
    }

    //お客様用エラー画面
    function info(Request $request)
    {        
        return view('photo_project/screen/info');
    }


    //QRコード作成画面遷移
    function create_qrcode(Request $request)
    {       

        $Qrcode_InfoArray = array();
                
        $date = $request->date;
        if(is_null($date)){            
            
            $Today = Carbon::today();
            $date =  $Today->format('Y-m-d');           

        }


        $photoget_t_info = photoget_t_model::withTrashed()
        ->where('date', '=', str_replace('-', '', $date))          
        ->get();            

        $Saved_Path_Info = $this->get_path_info(str_replace('-', '', $date));            
        $StoragePath_QrCode = $Saved_Path_Info["StoragePath_QrCode"];
        $StoragePath_QrTicket = $Saved_Path_Info["StoragePath_QrTicket"];
            
        
        foreach($photoget_t_info as $info){

            $QrCodeSaved_Path = asset($StoragePath_QrCode . $info->name1);
            $QrTicketSaved_Path = asset($StoragePath_QrTicket . $info->name2);                       

            $display_date = substr($info->date, 0, 4) .'/'. substr($info->date, 4, 2) .'/'. substr($info->date, 6, 2);
            
            //暗号文を平文に            
            $info->display_password = common::decryption( $info->password);

            $info->display_date = $display_date;

            $info->QrCodeSaved_Path = $QrCodeSaved_Path;
            $info->QrTicketSaved_Path = $QrTicketSaved_Path;         

        }

        return view('photo_project/screen/create_qrcode', compact('date','photoget_t_info'));
        
    }

    //QRコード作成処理
    function create_qrcode_execution(Request $request)
    {       

        DB::connection('mysql')->beginTransaction();

        try{
                
            $date = str_replace('-', '', $request->date);
            $count = $request->count;
            $with_password_flg = $request->WithPasswordFlg;
           
            //指定された開催日で既に作成されたデータ数を取得
            $CreatedCount = photoget_t_model::withTrashed()
            ->where('date', '=', $date)                    
            ->get()->count();        

            //画面で指定された作成数分ループ        
            for ($i = 1; $i <= $count; $i++) {

                //画面で指定されたデータ数 + 既に作成されたデータを加算し0埋め3桁のコード作成[001]など
                $code = str_pad($i + $CreatedCount, 3, 0, STR_PAD_LEFT);

                $password = "";
                $cipher = "";
                        
                //パスワード作成 ＆ 重複check
                while(true){ 

                    //数字のみでパスワード作成   
                    $password = common::create_random_letters_limited_number(4);

                    //平文を暗号文に
                    $encryption_password = common::encryption($password);

                    //同日で同じpasswordがある場合はパスワードを再作成
                    //photoget_t_modelのパスワードは暗号文が登録されている
                    $password_check = photoget_t_model::withTrashed()
                    ->where('date', '=', $date)
                    ->where('password', '=', $encryption_password)
                    ->get()->count();

                    if($password_check == 0){

                        //繰返しの強制終了
                        break; 
                    }
                    
                }

                //暗号文作成 ＆ 重複check
                while(true){ 

                    $cipher = common::create_random_letters(10);
                    $password_check = photoget_t_model::withTrashed()
                    ->where('cipher', '=', $cipher)                    
                    ->get()->count();

                    if($password_check == 0){

                        //繰返しの強制終了
                        break; 
                    }
                    
                }


                //.envに設定しているデバックモードを取得    true or false
                //デバッグモードは全てCode
                if(env('APP_DEBUG')){
                    $password = intval($code);      
                    //平文を暗号文に
                    $encryption_password = common::encryption($password);
                }

                //フォルダ名を作成  コード&英数字の羅列
                //例:001_aG4r
                $saved_folder =  $code . '_' . $this->make_saved_folder(10);

                //Qrコードとチケット名を設定
                //例:QrCode_20220101001.png
                //例:QrTicket_20220101001.png
                $Qr_ImageName = 'QrCode_'.$date.$code .'.png';
                $Qr_TicketName = 'QrTicket_'.$date.$code .'.png';            

                $key_code = $date . $code;            
                
                //Qrコードに設定するUrlを設定
                $url = route('photo_project.password_entry') . '?key_code=' . $key_code . '&cipher=' .$cipher;
             

                if(env('APP_DEBUG')){
                    $IpAddress = $request->IpAddress;
                    if(!(is_null($IpAddress) || $IpAddress == "")){
                        $url = str_replace("127.0.0.1", $IpAddress, $url);
                    }
                    
                }

                //photoget_t_modelのパスワードは暗号文が登録されている

                //photoget_tにデータ作成
                photoget_t_model::create(
                    [
                        "date" => $date
                        ,"code" => $code
                        ,"password" => $encryption_password
                        ,"with_password_flg" => $with_password_flg
                        ,"saved_folder" => $saved_folder
                        ,"name1" => $Qr_ImageName
                        ,"name2" => $Qr_TicketName
                        ,"url" => $url
                        ,"cipher" => $cipher
                    ]
                );            

                //get_path_info関数で各階層情報を取得
                $Saved_Path_Info = $this->get_path_info($date,$saved_folder);

                //QrCodeとQrチケットの保存場所
                Storage::disk('photo_project_public_path')->makeDirectory($Saved_Path_Info["CreatePath_QrCode"]);
                Storage::disk('photo_project_public_path')->makeDirectory($Saved_Path_Info["CreatePath_QrTicket"]);
                Storage::disk('photo_project_public_path')->makeDirectory($Saved_Path_Info["CreatePath_Saved_Folder"]);
           
           

            //Qrコード作成から保存  Start
              
                //QRの余白設定の参照サイト
                //https://morioh.com/p/5fc0fdacfdc4
                //設定したUrlでQrコード作成
                $Create_Qr_Image = QrCode::size(150)->format('png')->generate($url);
              
                //作成したQrコード画像を指定階層に保存
                $PublicPath_QrCode = $Saved_Path_Info["PublicPath_QrCode"];

                Storage::put($PublicPath_QrCode . $Qr_ImageName , $Create_Qr_Image);

            //Qrコード作成から保存  End


            //Qrチケット作成から保存  Start

                //QrTicket保存場所
                $StoragePath_QrTicket = $Saved_Path_Info["StoragePath_QrTicket"];              
                
                //QrTicket_Templateを取得            
                $Create_QrTicket = Image::make($Saved_Path_Info["StoragePath_QrTicket_Template"]);

                //Qrコードの画像を取得            
                $QrImage = Image::make($Saved_Path_Info["StoragePath_QrCode"] . $Qr_ImageName);



                $Position = 'center';
                $Position_X = 0;
                $Position_Y = -40;

                $Create_QrTicket->insert($QrImage , $Position , $Position_X , $Position_Y); 
                                
                //表示するパスワードは平文
                $word = 'Pass:' . $password;
                $Create_QrTicket->text($word, 10, 10, function($font){
                    $font->size(40);
                    $font->color('#f00');
                    // $font->align('center');
                    // $font->valign('top');
                    // $font->angle(45);
                });
              
                $Create_QrTicket->save($StoragePath_QrTicket . $Qr_TicketName);

            //Qrチケット作成から保存  End

            }

            $ResultArray = array(
                "Result" => 'success'          
            );

            DB::connection('mysql')->commit();

        } catch (Exception $e) {

            DB::connection('mysql')->rollBack();

            $m =  $e->getMessage();

            Log::channel('error_log')->info("【QRコード作成エラー】" . $m);

            $ResultArray = array(
                "Result" => "error",
                "Message" => '',
            );            
        }

        return response()->json(['ResultArray' => $ResultArray]);   
    }


    //QRコードダウンロード処理  zip作成
    function qrcode_download(Request $request)
    {
        try{

            $date = str_replace('-', '', $request->date);

            //zipの削除
            $deletePath = $date."/QrTicket/zip";
            Storage::disk('photo_project_public_path')->deleteDirectory($deletePath);

            //get_path_info関数に必要値を渡して階層情報を取得
            $Saved_Path_Info = $this->get_path_info($date);            
            $FullPath = public_path($Saved_Path_Info["StoragePath_QrTicket"]);                  
                 
            $Files = glob($FullPath.'*.*');
            
            $ZipName = 'QrTicket.zip';                      

            Zip::create($ZipName, $Files)
            ->saveTo($FullPath . '/zip');


            $Saved_Path = $Saved_Path_Info["StoragePath_QrTicket"];   
            
            
            $ZipDownloadPath = asset($Saved_Path . "zip/" .  $ZipName);           
            

            $ResultArray = array(
                "Result" => "success",
                "ZipDownloadPath" => $ZipDownloadPath,
                "ZipName" => $ZipName,
            );

        } catch (Exception $e) {

            $ErrorMessage = $e->getMessage();
            $ResultArray = array(
                "Result" => "error",
                "Message" => '',
            );

        }   
        
        return response()->json(['ResultArray' => $ResultArray]);


        
    }

    //パスワード必要フラグの変更処理
    function with_password_flg_change(Request $request)
    {

        $id = $request->id;
        $with_password_flg = $request->with_password_flg;
        
        if($with_password_flg == 0){
            $with_password_flg = 1;
        }else if($with_password_flg == 1){
            $with_password_flg = 0;
        }

        $operator = '1';
        try {
       
            //更新処理
            photoget_t_model::
            where('id', $id)                
            ->update(
                [
                    'with_password_flg' => $with_password_flg,                        
                    'updated_by' => $operator,            
                ]
            );
            
        } catch (Exception $e) {

                        
            $error_title = '写真プロジェクト[パスワード必要変更処理エラー]';
            $ErrorMessage = $e->getMessage();
                      
            common::SendErrorMail($error_title,$ErrorMessage);

            $log_error_message = $error_title .'::' .$ErrorMessage;
            Log::channel('error_log')->info($log_error_message);

            $ResultArray = array(
                "Result" => "error",
                "Message" => $error_title,
            );
            

            return response()->json(['ResultArray' => $ResultArray]);
                                
        }

        $ResultArray = array(
            "Result" => "success",
            "Message" => '',
        );

        return response()->json(['ResultArray' => $ResultArray]);
    }
    
    //写真取得画面のURLを直接読み込んだ場合_1
    function qr_announce_transition(Request $request)
    {
        //エラーメッセージ設定
        session()->flash('errormessage','Qrチケットを再度読み込んでください。');
        return redirect()->route('photo_project.info');    
    }

    //写真取得用パスワード入力画面 or 写真アップロード画面への遷移先分岐
    function password_entry(Request $request)
    {
      
        //画像アップロード画面に遷移するか判断する為
        $upload_flg = $request->upload_flg;
        //urlに記載されているkeycode取得
        $key_code = $request->key_code;                
        $cipher = $request->cipher;

        
        //upload_flg非存在時は写真取得画面(お客様用)に遷移
        if(is_null($upload_flg)){

            //画面遷移判断用
            $transition_judge = true;
         
            try{

                //キーコードから日付とコードを取得
                $key_code_split = $this->key_code_split($key_code);
                $date = $key_code_split["date"];
                $code = $key_code_split["code"];
    
                //photoget_tからデータを取得
                $photoget_t_info = photoget_t_model::withTrashed()                   
                ->where('date', '=', $date)  
                ->where('code', '=', $code)  
                ->where('cipher', '=', $cipher)  
                ->first();   

                if(is_null($photoget_t_info)){
                    $transition_judge = false;   
                }
                
    
            } catch (Exception $e) {
                $transition_judge = false;       
            }    

            //処理エラー
            if(!$transition_judge){
                //エラーメッセージ設定
                session()->flash('errormessage','Qrチケットを再度読み込んでください。');
                return redirect()->route('photo_project.info');            
            }

            //保存フォルダ情報を取得
            $Saved_Folder = $photoget_t_info->saved_folder;     

            //get_upload_info関数に必要値を渡して写真のアップロード状況を取得
            $Files = $this->get_upload_info($date,$Saved_Folder);                      
    
            //写真がアップロードされているか確認
            //写真がまだアップロード前であれば画面遷移
            if(!(count($Files) > 0)){    

               //エラーメッセージ設定
               session()->flash('before_upload_message','Qrチケットを再度読み込んでください。');
               return redirect()->route('photo_project.info');

            }


            //パスワード認証が必要かフラグ取得
            $with_password_flg = $photoget_t_info->with_password_flg;

            if($with_password_flg == 1){
                return view('photo_project/screen/password_entry', compact('key_code','cipher'));
            }else{
                //パスワード不要のため、そのまま写真表示画面
                $encryption_password = $photoget_t_info->password; 

                //暗号文を平文に
                $password = common::decryption($encryption_password);           
                return view('photo_project/screen/password_auto_entry', compact('key_code','cipher','password'));
            }
            

        }else{

            //upload_flg存在時は写真アップロード画面(スタッフ用)に遷移
            return redirect()->route('photo_project.photo_upload', ['key_code' => $key_code]); 

        }
        
    }

    //写真取得用パスワードチェック処理
    function photo_confirmation(Request $request)
    {
       
        try{

            //パスワード入力画面から値取得
            $password = $request->password;
            $key_code = $request->key_code;
            $cipher = $request->cipher;

            //キーコードから日付とコードを取得
            $key_code_split = $this->key_code_split($key_code);
            $date = $key_code_split["date"];
            $code = $key_code_split["code"];
            
            //日付、コード、暗号文で
            $photoget_t_info_check = photoget_t_model::withTrashed()                    
            ->where('date', '=', $date)  
            ->where('code', '=', $code)  
            ->where('cipher', '=', $cipher)    
            ->first();

            if(is_null($photoget_t_info_check)){  
                //key_codeと暗号文が不整合
                session()->flash('photo_get_password_check_error', 'Qrコードを再読みしてください。');
                return back();
            }


            //平文を暗号文に
            $encryption_password = common::encryption($password);

            //日付、コード、パスワードで絞込
            $photoget_t_info = photoget_t_model::withTrashed()                    
            ->where('date', '=', $date)  
            ->where('code', '=', $code)  
            ->where('cipher', '=', $cipher)
            ->where('password', '=', $encryption_password)    
            ->get();

            
            if(count($photoget_t_info) == 1){

                $photoget_t_info = $photoget_t_info[0];

                $UploadFileInfo = array();
            
                //get_upload_info関数に必要値を渡して写真のアップロード状況を取得
                $UploadFileInfo = $this->get_upload_info($date,$photoget_t_info->saved_folder); 
            
                //端末情報取得
                $termina_info = common::TerminalCheck($request);
        
                return view('photo_project/screen/photo_confirmation', compact('photoget_t_info','key_code','cipher','UploadFileInfo','termina_info'));  

            }elseif(count($photoget_t_info) > 1){
                //データが複数ある為、CriticalError



            }elseif(count($photoget_t_info) == 0){

                //パスワード認証NG

                //次に日付、コードのみで絞込
                $photoget_t_check = photoget_t_model::withTrashed()                      
                ->where('date', '=', $date)  
                ->where('code', '=', $code)  
                ->where('cipher', '=', $cipher)
                ->get();

                if(count($photoget_t_check) > 0){
                      
                    //日付、コードのみで絞り込んでデータが1レコード存在時は、単純にパスワード認証不一致                    
                
                     // 暗号文と不一致   不正な処理
                    session()->flash('photo_get_password_check_error', 'パスワードが正しくありません。');
                    return back();
                    

                  
                }else{

                    //※※※※※※※※※※※※※※※※※※※
                    //日付、コードのみで絞り込んでもデータ取れていない場合は異常
                    //※※※※※※※※※※※※※※※※※※※

                    session()->flash('photo_get_password_check_error', 'Qrコードを再読みしてください。');
                    return back();
                }               
            }

        } catch (Exception $e) {

            session()->flash('photo_get_password_check_error', 'Qrコードを再読みしてください。');
            return back();       

        }       
    
    }

    //写真一括ダウンロードの為、zipフォルダ作成
    function batch_download(Request $request)
    {
    
        try{
            $key_code = $request->key_code;            
            $cipher = $request->cipher;

            //キーコードから日付とコードを取得
            $key_code_split = $this->key_code_split($key_code);
            $date = $key_code_split["date"];
            $code = $key_code_split["code"];

            //日付、コード、パスワードで絞込
            $photoget_t_info = photoget_t_model::withTrashed()                    
            ->where('date', '=', $date)  
            ->where('code', '=', $code)
            ->where('cipher', '=', $cipher)
            ->first();

            if(is_null($photoget_t_info)){                
                // 暗号文と不一致   不正な処理
                $ResultArray = array(
                "Result" => "error"                   
                );
                return response()->json(['ResultArray' => $ResultArray]);    
            }

            $Saved_Folder = $photoget_t_info->saved_folder;        

            //zipの削除
            $deletePath = $date."/".$Saved_Folder."/phot/zip";
            Storage::disk('photo_project_public_path')->deleteDirectory($deletePath);

            //get_path_info関数に必要値を渡して階層情報を取得
            $Saved_Path_Info = $this->get_path_info($date,$Saved_Folder);            
            $FullPath = public_path($Saved_Path_Info["StoragePath_Photo"]);               
            

            $Files = glob($FullPath.'*.*');
                
            $ZipName = 'photos.zip';                      

            Zip::create($ZipName, $Files)
            ->saveTo($FullPath . '/zip');


            $Saved_Path = $Saved_Path_Info["StoragePath_Photo"];   
            
            
            $ZipDownloadPath = asset($Saved_Path . "zip/" .  $ZipName);           
            

            $ResultArray = array(
                "Result" => "success",
                "ZipDownloadPath" => $ZipDownloadPath,
                "ZipName" => $ZipName,
            );

        } catch (Exception $e) {

            $ErrorMessage = $e->getMessage();
            $ResultArray = array(
                "Result" => "error",
                "Message" => '',
            );

        }   
        
        return response()->json(['ResultArray' => $ResultArray]);

    }


    function delete_zip($date = 0 , $Saved_Folder = 0){

        $deletePath = $date."/".$Saved_Folder."/phot/zip";
        Storage::disk('photo_project_public_path')->deleteDirectory($deletePath);

    }

    //写真アップロード画面遷移
    function photo_upload(Request $request)
    {
        
        $UploadFileInfo = array();
       
        $key_code = $request->key_code;
    
        $key_code_split = $this->key_code_split($key_code);
        $date = $key_code_split["date"];
        $code = $key_code_split["code"];      

        try{

            //端末情報取得
            $termina_info = common::TerminalCheck($request);

            $photoget_t_info = photoget_t_model::withTrashed()
            ->where('date', '=', $date)  
            ->where('code', '=', $code)  
            ->first();            

            $Saved_Folder = $photoget_t_info->saved_folder;
                                       
            //get_upload_info関数に必要値を渡して写真のアップロード状況を取得
            $UploadFileInfo = $this->get_upload_info($date,$Saved_Folder);  


        } catch (Exception $e) {
            $Judge = false;
        }
        
        return view('photo_project/screen/photo_upload', compact('key_code','UploadFileInfo','termina_info'));        
    }

    //写真アップロード処理
    function photo_upload_execution(Request $request)
    {
        try{

            $all = $request->all();

            $key_code = $request->key_code;

            $key_code_split = $this->key_code_split($key_code);
            $date = $key_code_split["date"];
            $code = $key_code_split["code"];        

            $photoget_t_info = photoget_t_model::withTrashed()
            ->where('date', '=', $date)  
            ->where('code', '=', $code)  
            ->first();            

            $Saved_Folder = $photoget_t_info->saved_folder;            
            $date = $photoget_t_info->date;
            
            //get_path_info関数に必要値を渡して階層情報を取得
            $Saved_Path_Info = $this->get_path_info($date,$Saved_Folder);            

            //get_upload_info関数に必要値を渡して写真のアップロード状況を取得
            $Files = $this->get_upload_info($date,$Saved_Folder);  
            //既にアップロードされているfile総数を取得
            $ExistingFileCount = count($Files);

            //画面で選択したアップロードファイル
            $Upload_Files = $request->file('file');

            foreach($Upload_Files as $Count => $file){                
                            
                $Extension = $file->getClientOriginalExtension();

                $FileName = str_pad(($ExistingFileCount + ($Count + 1)), 4, 0, STR_PAD_LEFT) . "." . $Extension;

               
                $Public_SavePath =  $Saved_Path_Info["PublicPath_Photo"];
                
                //画像ファイルデータ取得
                $Image = File::get($file);

                //保存するファイルパス & ファイル名
                $upload_save_path = $Public_SavePath . $FileName;
                Storage::put($upload_save_path, $Image);   
            
            }            

            $ResultArray = array(
                "Result" => 'success',           
            );
            

        } catch (Exception $e) {

            $error_message =  $e->getMessage();

            Log::channel('error_log')->info("画像アップロードエラー【key_code:" . $key_code ."】" . $error_message);

            $ResultArray = array(
                "Result" => "error",
                "Message" => '',
            );
        }
        return response()->json(['ResultArray' => $ResultArray]);        
    }


    //$key_codeを日付とcodeに分解
    function key_code_split($key_code){

        //例：$key_code = 202201010001

        //8文字目まで日付
        //例：$date = 20220101
        $date = substr($key_code, 0, 8);

        //8文字目以降がコード
        //例：$code = 001
        $code = substr($key_code,8);

        $ReturnArray = [
            'date' => $date,
            'code' => $code,          
        ];

        return $ReturnArray;
    }

    //アップロードファイル格納フォルダ名作成    
    function make_saved_folder($length) {
        $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
        $saved_folder = null;
        for ($i = 0; $i < $length; $i++) {
            $saved_folder .= $str[rand(0, count($str) - 1)];
        }
        return $saved_folder;
    }

    //各階層の固定値取得処理
    function get_path_info($date = 0 , $Saved_Folder = 0){

        $date = str_replace('-', '', $date);
              
        $StoragePath_Photo = "storage/photo_project/". $date."/". $Saved_Folder ."/";
        $PublicPath_Photo = "public/photo_project/". $date."/". $Saved_Folder ."/";

        $StoragePath_QrCode = "storage/photo_project/" . $date. "/QrCode/";
        $PublicPath_QrCode = "public/photo_project/" . $date . "/QrCode/";

        $StoragePath_QrTicket = "storage/photo_project/" . $date. "/QrTicket/";        
        $PublicPath_QrTicket = "public/photo_project/" . $date. "/QrTicket/";

        $CreatePath_QrTicket = $date. "/QrTicket/";
        $CreatePath_QrCode = $date. "/QrCode/";       
        $CreatePath_Saved_Folder = $date. "/" . $Saved_Folder . "/";

        $StoragePath_QrTicket_Template = "storage/photo_project/QrTicket_Template/QR_Template.png";
        
        

        $ReturnArray = [
            'StoragePath_Photo' => $StoragePath_Photo,
            'PublicPath_Photo' => $PublicPath_Photo,
            'StoragePath_QrCode' => $StoragePath_QrCode,
            'PublicPath_QrCode' => $PublicPath_QrCode,            

            'StoragePath_QrTicket' => $StoragePath_QrTicket,
            'PublicPath_QrTicket' => $PublicPath_QrTicket,
            'StoragePath_QrTicket_Template' => $StoragePath_QrTicket_Template,

            'CreatePath_QrTicket' => $CreatePath_QrTicket,
            'CreatePath_QrCode' => $CreatePath_QrCode,
            'CreatePath_Saved_Folder' => $CreatePath_Saved_Folder,
        ];

        return $ReturnArray;
    }

    

    //写真のアップロード状況確認用処理
    function get_upload_info($date = 0 , $Saved_Folder = 0){


        $photo_info = array();

        //get_path_info関数に必要値を渡して階層情報を取得
        $Saved_Path_Info = $this->get_path_info($date,$Saved_Folder);            
        $Saved_Path = $Saved_Path_Info["StoragePath_Photo"];           
        

        //フォルダを確認し写真がアップロードされているか確認する為に情報取得
        $Files = glob(public_path($Saved_Path.'*.*'));
       
        foreach ($Files as $FilePath){

            $file = pathinfo($FilePath);            
            $FileName = $file['basename'];

            $PublicPath = asset($Saved_Path . $FileName);

            //配列にアップロードファイルパスとファイル名を格納            
            $Info = array('PublicPath' => $PublicPath , 'FileName' => $FileName);
            array_push($photo_info, $Info);
        }

        return $photo_info;
    }

}
