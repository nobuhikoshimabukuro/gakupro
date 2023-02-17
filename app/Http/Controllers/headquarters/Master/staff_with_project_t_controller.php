<?php

namespace App\Http\Controllers\headquarters\master;
use App\Http\Controllers\Controller;

use App\Models\staff_m_model;
use App\Models\staff_password_t_model;
use App\Models\project_m_model;
use App\Models\staff_with_project_t_model;

use App\Http\Requests\staff_m_request;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Original\common;
use App\Original\create_list;

use Illuminate\Support\Facades\DB;
class staff_with_project_t_controller extends Controller
{
    function index(Request $request)
    {

        $staff_id = $request->staff_id;       

        $project_list = project_m_model::get();

        $staff_with_project_list = staff_with_project_t_model::select(

            'staff_with_project_t.project_id as project_id',
            'project_m.project_name as project_name',
            'project_m.remarks as project_remarks',

            'staff_with_project_t.staff_id as staff_id',
            'staff_m.staff_last_name as staff_last_name',
            'staff_m.staff_first_name as staff_first_name',
            'staff_m.staff_last_name_yomi as staff_last_name_yomi',
            'staff_m.staff_first_name_yomi as staff_first_name_yomi',
            
        )
        ->leftJoin('staff_m', function ($join) {
            $join->on('staff_with_project_t.staff_id', '=', 'staff_m.staff_id');                 
        })  
        ->leftJoin('project_m', function ($join) {
            $join->on('staff_with_project_t.project_id', '=', 'project_m.project_id');                 
        })        
        ->where('staff_with_project_t.staff_id', '=', $staff_id)
        ->orderBy('staff_with_project_t.project_id', 'asc')
        ->get();

      
        $staff_info = staff_m_model::select(

            'staff_m.staff_id as staff_id',
            'staff_m.staff_last_name as staff_last_name',
            'staff_m.staff_first_name as staff_first_name',
            'staff_m.staff_last_name_yomi as staff_last_name_yomi',
            'staff_m.staff_first_name_yomi as staff_first_name_yomi',
            'staff_m.nick_name as nick_name',
            'staff_m.gender as gender',
            'genderinfo.subcategory_name as gender_name',
            'staff_m.tel as tel',
            'staff_m.mailaddress as mailaddress',

            'staff_m.authority as authority',
            'authorityinfo.subcategory_name as authority_name',
       
            'staff_m.remarks as remarks',
            'staff_m.deleted_at as deleted_at',
        )
        ->leftJoin('subcategory_m as genderinfo', function ($join) {
            $join->on('genderinfo.subcategory_cd', '=', 'staff_m.gender')
                 ->where('genderinfo.maincategory_cd', '=', '1');            
        })
        ->leftJoin('subcategory_m as authorityinfo', function ($join) {
            $join->on('authorityinfo.subcategory_cd', '=', 'staff_m.authority')
                ->where('authorityinfo.maincategory_cd', '=', env('authority_subcategory_cd'));            
        })     
        ->leftJoin('staff_password_t', function ($join) {
            $join->on('staff_password_t.staff_id', '=', 'staff_m.staff_id')
                ->whereNull('staff_password_t.deleted_at');
            ;
        })       
        ->withTrashed()
        ->where('staff_m.staff_id', '=', $staff_id)
        ->first();

        
        
        return view('headquarters/screen/master/staff/staff_with_project', compact('project_list','staff_with_project_list','staff_info'));
    }


    //  更新処理
    function save(Request $request)
    {
        $project_list = project_m_model::get();
                
        $staff_id = $request->staff_id;

        $operator = 9999;
        
        try {
            
            DB::connection('mysql')->beginTransaction();
            //table:staff_with_projectの該当するデータを物理削除削除する（staff_idで制限）
            staff_with_project_t_model::where('staff_id', '=', $staff_id)->forceDelete();           

            foreach($project_list as $info){

                $project_id = $info->project_id;

                $target_name = "project_id_" . $project_id;

                $target_value = $request->$target_name;

                if($target_value == 1){

                     //新規登録処理                
                    staff_with_project_t_model::create(
                        [
                            'staff_id' => $staff_id,
                            'project_id' => $project_id,                        
                            'created_by' => $operator,                        
                        ]
                    );         

                }                       
            }

            DB::connection('mysql')->commit();
    
        } catch (Exception $e) {            
            
            DB::connection('mysql')->rollBack();
            
            $ErrorMessage = '【スタッフ毎プロジェクト管理テーブル更新エラー】' . $e->getMessage();            

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

        session()->flash('success', 'データを更新しました。');
        session()->flash('message-type', 'success');
        return response()->json(['ResultArray' => $ResultArray]);
    }

    //  論理削除処理
    function delete_or_restore(Request $request)
    {
        $delete_flg = intval($request->delete_flg);

        $staff_id = intval($request->delete_staff_id);
        $staff_name = $request->delete_staff_name;        

        try {

            
            if($delete_flg == 0){

                //論理削除
                staff_m_model::
                where('staff_id', $staff_id)                
                ->delete();
                   
                session()->flash('success', '[スタッフID = ' . $staff_id . ' スタッフ名 = ' . $staff_name . ']データを利用不可状態にしました');                                

            }else{    

                //論理削除解除
                staff_m_model::
                where('staff_id', $staff_id) 
                ->withTrashed()
                ->restore();

                session()->flash('success', '[スタッフID = ' . $staff_id . ' スタッフ名 = ' . $staff_name . ']データを利用可能状態にしました');                                
            }

        } catch (Exception $e) {

            $ErrorMessage = '【スタッフマスタ利用状況変更処理時エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

            session()->flash('error', '[スタッフID = ' . $staff_id . ' スタッフ名 = ' . $staff_name . ']データの利用状況変更処理時エラー'); 
           
        }       

        return back();
    }

    // ログイン情報重複確認処理
    function login_info_check(request $request){

        $staff_id = $request->staff_id;
        $login_id = $request->login_id;
        //画面で入力した平文パスワードを暗号化
        $password = common::encryption($request->password);
                
        try {

            $login_id_duplication = "";
            $password_duplication = "";

            //ログインIDでデータ重複チェック
            $login_id_check = staff_password_t_model::
            where('login_id', $login_id)   
            ->where('staff_id', '<>', $staff_id)              
            ->first();

            if(!is_null($login_id_check)){
                $login_id_duplication = "ログインID重複エラー";
            }

            //パスワード（暗号文）でデータ重複チェック
            $login_id_check = staff_password_t_model::
            where('password', $password)  
            ->where('staff_id', '<>', $staff_id)                    
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

            $ErrorMessage = '【スタッフマスタログイン情報確認エラー】' . $e->getMessage();            

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
        $staff_id = intval($request->logininfo_staff_id);
        $login_id = $request->login_id;
        //画面で入力した平文パスワードを暗号化
        $password = common::encryption($request->password);
        $operator = session()->get('staff_id');
        
        try {
    
            DB::connection('mysql')->beginTransaction();

            //スタッフIDで全てのデータの論理削除
            staff_password_t_model::
            where('staff_id', $staff_id)                    
            ->delete();

            //新規登録処理                
            staff_password_t_model::create(
                [
                    'staff_id' => $staff_id,                        
                    'login_id' => $login_id,     
                    'password' => $password,               
                    'created_by' => $operator,                        
                ]
            );          

            session()->flash('success', '[スタッフID = ' . $staff_id . ']のログイン情報を変更しました。');                

            DB::connection('mysql')->commit();

        } catch (Exception $e) {

            DB::connection('mysql')->rollBack();

            $ErrorMessage = '【ログイン情報変更処理時エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);
            
            session()->flash('error', '[スタッフID = ' . $staff_id . ']のログイン情報を変更時にエラーが発生しました。');                

        }  

        return back();

    }

}
