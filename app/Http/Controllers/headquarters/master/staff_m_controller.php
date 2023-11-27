<?php

namespace App\Http\Controllers\headquarters\master;
use App\Http\Controllers\Controller;

use App\Models\staff_m_model;
use App\Models\staff_password_t_model;
use App\Models\subcategory_m_model;
use App\Models\project_m_model;
use App\Models\staff_with_project_t_model;

use App\Http\Requests\staff_m_request;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Original\common;
use App\Original\create_list;

use Illuminate\Support\Facades\DB;
class staff_m_controller extends Controller
{
    function index(Request $request)
    {

        //検索項目格納用配列
        $search_element_array = [
            'search_authority_cd' => $request->search_authority_cd,            
            'search_staff_name' => $request->search_staff_name,            
        ];

        $gender_list = create_list::gender_list();

        $authority_list = create_list::authority_list();      

        $operator_authority = session()->get('authority');

        $project_list = project_m_model::get();

        $staff_list = staff_m_model::select(

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

            'staff_password_t.id as password_id',
            'staff_password_t.login_id as login_id',
            'staff_password_t.password as encrypted_password',
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
        ->orderBy('staff_m.staff_id', 'asc');        

        if(!is_null($search_element_array['search_authority_cd'])){
            $staff_list = $staff_list->where('staff_m.authority', '=', $search_element_array['search_authority_cd']);
        }
        
        if(!is_null($search_element_array["search_staff_name"])){

            $search_staff_name = $search_element_array["search_staff_name"];
            $staff_list = $staff_list ->where(function($query) use ($search_staff_name) {

                $query->orWhere('staff_m.staff_last_name', 'like', "%$search_staff_name%")
                      ->orWhere('staff_m.staff_first_name', 'like', "%$search_staff_name%")
                      ->orWhere('staff_m.staff_last_name_yomi', 'like', "%$search_staff_name%")
                      ->orWhere('staff_m.staff_first_name_yomi', 'like', "%$search_staff_name%");
            });            
        } 


        $staff_list = $staff_list->paginate(env('paginate_count'));
     
        foreach($staff_list as $info){

            $password = "";
            if($info->encrypted_password != ""){            
                $password = common::decryption($info->encrypted_password);
            }
            //DBに登録されている暗号化したパスワードを平文に変更し再格納                    
            $info->password = $password;            
        }
        
        return view('headquarters/screen/master/staff/index', compact('staff_list','search_element_array','gender_list','authority_list','project_list'));
    }


    //  更新処理
    function save(staff_m_request $request)
    {
        $processflg = intval($request->processflg);
        $staff_id = intval($request->staff_id);

        
        $staff_last_name = $request->staff_last_name;
        $staff_first_name = $request->staff_first_name;
        $staff_last_name_yomi = $request->staff_last_name_yomi;
        $staff_first_name_yomi = $request->staff_first_name_yomi;
        
        $nick_name = $request->nick_name;        
        $gender = intval($request->gender);
        $tel = $request->tel;
        $mailaddress = $request->mailaddress;
        $authority = intval($request->authority);
        $remarks = $request->remarks;
                
        $operator = 9999;
        
        try {

            if($processflg == 0){
                               
                //新規登録処理                
                staff_m_model::create(
                    [
                        'staff_last_name' => $staff_last_name,
                        'staff_first_name' => $staff_first_name,
                        'staff_last_name_yomi' => $staff_last_name_yomi,
                        'staff_first_name_yomi' => $staff_first_name_yomi,
                        'nick_name' => $nick_name,
                        'gender' => $gender,
                        'tel' => $tel,
                        'mailaddress' => $mailaddress,
                        'authority' => $authority,
                        'remarks' => $remarks,
                        'created_by' => $operator,                        
                    ]
                );            


            }else{

                //更新処理
                staff_m_model::
                where('staff_id', $staff_id)                
                ->update(
                    [
                        'staff_last_name' => $staff_last_name,
                        'staff_first_name' => $staff_first_name,
                        'staff_last_name_yomi' => $staff_last_name_yomi,
                        'staff_first_name_yomi' => $staff_first_name_yomi,   
                        'nick_name' => $nick_name,
                        'gender' => $gender,
                        'tel' => $tel,
                        'mailaddress' => $mailaddress,
                        'authority' => $authority,
                        'remarks' => $remarks,
                        'updated_by' => $operator,                 
                    ]
                );
            }
    
        } catch (Exception $e) {            
            
            $ErrorMessage = '【スタッフマスタ登録エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

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

        session()->flash('success', 'データを登録しました。');
        session()->flash('message-type', 'success');
        return response()->json(['result_array' => $result_array]);
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
                      
                $result_array = array(
                    "Result" => "success",
                    "Message" => '',
                );

            }else{

                $result_array = array(
                    "Result" => "duplication_error",
                    "login_id_duplication" => $login_id_duplication,
                    "password_duplication" => $password_duplication,
                );

            }         


        } catch (Exception $e) {

            $ErrorMessage = '【スタッフマスタログイン情報確認エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

            $result_array = array(
                "Result" => "error",
                "Message" => $ErrorMessage,
            );           
         
        }  

        return response()->json(['result_array' => $result_array]);

    }

    // ログイン情報更新処理
    function login_info_update(request $request)
    {
        
        $id = intval($request->login_info_password_id);
        $staff_id = intval($request->login_info_staff_id);
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




    // プロジェクト情報取得処理
    function project_info_get(request $request)
    {
    
        try {

            $staff_id = intval($request->staff_id);

            $staff_with_project_list = staff_with_project_t_model::where('staff_with_project_t.staff_id', '=', $staff_id)->get();
            
            if(is_null($staff_with_project_list)){

                $message = "学校別専攻情報なし";
                $result_array = array(
                    "status" => "nodata",
                    "message" => $message
                );

            }else{
        

                $result_array = array(
                    "status" => "success",
                    "staff_with_project_list" =>  $staff_with_project_list
                );


            }


        } catch (Exception $e) {

            $ErrorMessage = '【スタッフ別プロジェクト情報データ取得エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

            $message = "データ取得エラー";
            $result_array = array(
                "status" => "error",
                "message" => $message
            );

        }
        

        return response()->json(['result_array' => $result_array]);

    }
    
    

    // プロジェクト情報更新処理
    function project_info_update(request $request)
    {
        
        
        $staff_id = intval($request->project_info_staff_id);
        $project_list = project_m_model::get();        

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

        session()->flash('success', 'データを更新しました。');
        session()->flash('message-type', 'success');
        return response()->json(['result_array' => $result_array]);

    }

}
