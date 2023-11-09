<?php

namespace App\Http\Controllers\headquarters\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use App\Original\common;
use App\Original\create_list;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

use App\Models\address_m_model;

use App\Models\salary_maincategory_m_model;
use App\Models\salary_subcategory_m_model;

class salary_category_m_controller extends Controller
{
    function index(Request $request)
    {

        $salary_maincategory_cd_array = [];
        //検索項目格納用配列
        $search_element_array = [
            'search_salary_maincategory_cd' => $request->search_salary_maincategory_cd,
            'search_salary_maincategory_name' => $request->search_salary_maincategory_name,            
            'search_salary' => $request->search_salary,
        ];

        $salary_maincategory_m_list = salary_maincategory_m_model::orderBy('salary_maincategory_m.salary_maincategory_cd', 'asc')        
        ->withTrashed();

        if(!is_null($search_element_array['search_salary_maincategory_cd'])){
            $salary_maincategory_m_list = $salary_maincategory_m_list
            ->where('salary_maincategory_m.salary_maincategory_cd', '=', $search_element_array['search_salary_maincategory_cd']);
        }

        if(!is_null($search_element_array['search_salary_maincategory_name'])){
            $search_salary_maincategory_name = $search_element_array["search_salary_maincategory_name"];
     
            $salary_maincategory_m_list = $salary_maincategory_m_list
            ->where('salary_maincategory_m.salary_maincategory_name', 'LIKE', "%$search_salary_maincategory_name%");
        }        

        $salary_maincategory_m_list = $salary_maincategory_m_list->paginate(30);

        foreach ($salary_maincategory_m_list as $info) {
            $salary_maincategory_cd_array[] = $info->salary_maincategory_cd;
        }


        $salary_subcategory_m_list = salary_subcategory_m_model::select(
            
            'salary_maincategory_m.salary_maincategory_cd as salary_maincategory_cd',
            'salary_maincategory_m.salary_maincategory_name as salary_maincategory_name',
            'salary_maincategory_m.display_order as salary_maincategory_display_order',
            
            'salary_subcategory_m.salary_subcategory_cd as salary_subcategory_cd',                        
            'salary_subcategory_m.salary as salary',
            'salary_subcategory_m.display_order as salary_subcategory_display_order',            
            'salary_subcategory_m.deleted_at as deleted_at',
        )
        ->leftJoin('salary_maincategory_m', function ($join) {
            $join->on('salary_subcategory_m.salary_maincategory_cd', '=', 'salary_maincategory_m.salary_maincategory_cd');
        })
        ->orderBy('salary_maincategory_m.display_order', 'asc')
        ->orderBy('salary_subcategory_m.display_order', 'asc')
        ->whereNull('salary_maincategory_m.deleted_at')
        ->withTrashed();


        if(count($salary_maincategory_cd_array) > 0){
            $salary_subcategory_m_list = $salary_subcategory_m_list
            ->whereIn('salary_maincategory_m.salary_maincategory_cd', $salary_maincategory_cd_array);
        }       

        if(!is_null($search_element_array['search_salary'])){
            $search_salary = $search_element_array["search_salary"];     
            $salary_subcategory_m_list = $salary_subcategory_m_list
            ->where('salary_subcategory_m.salary', 'LIKE', "%$search_salary%");
        }       

        $salary_subcategory_m_list = $salary_subcategory_m_list->paginate(30);

        $salary_maincategory_list = create_list::salary_maincategory_list();

        return view('headquarters/screen/master/salary_category/index', 
        compact('search_element_array','salary_maincategory_list','salary_maincategory_m_list','salary_subcategory_m_list'));
        
    }


    function salary_maincategory_save(Request $request)
    {
        $process_title = "給与大分類マスタ登録処理";
        $salary_maincategory_cd = intval($request->salary_maincategory_cd);
        $salary_maincategory_name = $request->salary_maincategory_name;
        $display_order = $request->salary_maincategory_display_order;
        
        $operator = 9999;
        try {

            if($salary_maincategory_cd == 0){            
                //新規登録処理
                salary_maincategory_m_model::create(
                    [
                        'salary_maincategory_name' => $salary_maincategory_name,
                        'display_order' => $display_order,
                        'created_by' => $operator,                        
                    ]
                );            

            }else{
                //更新処理
                salary_maincategory_m_model::
                where('salary_maincategory_cd', $salary_maincategory_cd)                
                ->update(
                    [
                        'salary_maincategory_name' => $salary_maincategory_name,
                        'display_order' => $display_order,                     
                        'updated_by' => $operator,            
                    ]
                );

            }         
    
        } catch (Exception $e) {

                        
            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            
            $result_array = array(
                "Result" => "error",
                "Message" => $process_title."でエラーが発生しました。",
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

    function salary_maincategory_delete_or_restore(Request $request)
    {        
        $delete_flg = intval($request->delete_salary_maincategory_flg);
        $salary_maincategory_cd = intval($request->delete_salary_maincategory_cd);
        $salary_maincategory_name = $request->delete_salary_maincategory_name;

        if($delete_flg == 0){
            $process_title = "給与大分類マスタ削除処理";
        }else{
            $process_title = "給与大分類マスタ削除取消処理";
        }
        

        try {

            
            if($delete_flg == 0){

                //論理削除
                salary_maincategory_m_model::
                where('salary_maincategory_cd', $salary_maincategory_cd)                
                ->delete();

                session()->flash('success', '[給与大分類名 = ' . $salary_maincategory_name . ']データを利用不可状態にしました');
            }else{    

                //論理削除解除
                salary_maincategory_m_model::
                where('salary_maincategory_cd', $salary_maincategory_cd)  
                ->withTrashed()                
                ->restore();
                session()->flash('success', '[給与大分類名 = ' . $salary_maincategory_name . ']データを利用可能状態にしました');                
            }

        } catch (Exception $e) {

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            session()->flash('error', '[給与大分類名 = ' . $salary_maincategory_name .']データの利用状況変更処理時エラー'); 
           
        }       

        return back();

    }

    function salary_subcategory_save(Request $request)
    {
        $process_title = "給与中分類マスタ登録処理";
        $salary_maincategory_cd = intval($request->salary_maincategory_cd_for_sub);
        $salary_subcategory_cd = intval($request->salary_subcategory_cd);
        $salary = $request->salary;
        $display_order = $request->salary_subcategory_display_order;
        
        $operator = 9999;
        try {

            if($salary_subcategory_cd == 0){            
                //新規登録処理
                salary_subcategory_m_model::create(
                    [
                        'salary_maincategory_cd' => $salary_maincategory_cd,
                        'salary' => $salary,
                        'display_order' => $display_order,
                        'created_by' => $operator,                        
                    ]
                );            

            }else{
                //更新処理
                salary_subcategory_m_model::
                where('salary_subcategory_cd', $salary_subcategory_cd)                
                ->update(
                    [
                        'salary_maincategory_cd' => $salary_maincategory_cd,
                        'salary' => $salary,
                        'display_order' => $display_order,
                        'updated_by' => $operator,            
                    ]
                );

            }         
    
        } catch (Exception $e) {

                        
            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            
            $result_array = array(
                "Result" => "error",
                "Message" => $process_title."でエラーが発生しました。",
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

    function salary_subcategory_delete_or_restore(Request $request)
    {

        $delete_flg = intval($request->delete_salary_subcategory_flg);
        $salary_subcategory_cd = intval($request->delete_salary_subcategory_cd);
        $salary = $request->delete_salary;

        if($delete_flg == 0){
            $process_title = "給与中分類マスタ削除処理";
        }else{
            $process_title = "給与中分類マスタ削除取消処理";
        }
        

        try {

            
            if($delete_flg == 0){

                //論理削除
                salary_subcategory_m_model::
                where('salary_subcategory_cd', $salary_subcategory_cd)                
                ->delete();

                session()->flash('success', '[給与中分類名 = ' . $salary . ']データを利用不可状態にしました');
            }else{    

                //論理削除解除
                salary_subcategory_m_model::
                where('salary_subcategory_cd', $salary_subcategory_cd)  
                ->withTrashed()                
                ->restore();
                session()->flash('success', '[給与中分類名 = ' . $salary . ']データを利用可能状態にしました');                
            }

        } catch (Exception $e) {

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            session()->flash('error', '[給与中分類名 = ' . $salary .']データの利用状況変更処理時エラー'); 
           
        }       

        return back();
        
    }
}
