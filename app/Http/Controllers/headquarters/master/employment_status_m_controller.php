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

use App\Models\job_maincategory_m_model;
use App\Models\employment_status_m_model;

class employment_status_m_controller extends Controller
{
    function index(Request $request)
    {
        //検索項目格納用配列
        $search_element_array = [
            'search_employment_status_name' => $request->search_employment_status_name                   
        ];

        $employment_status_m_list = employment_status_m_model::withTrashed()->orderBy('employment_status_id', 'asc');
            

        if(!is_null($search_element_array['search_employment_status_name'])){            
            $employment_status_m_list = $employment_status_m_list->where('employment_status_m.employment_status_name', 'like', '%' . $search_element_array['search_employment_status_name'] . '%');
        }

        $employment_status_m_list = $employment_status_m_list->paginate(env('paginate_count'));

        return view('headquarters/screen/master/employment_status/index', compact('search_element_array','employment_status_m_list'));
    }


    //  更新処理
    function save(Request $request)
    {

        $process_title = "雇用形態マスタ登録処理";
        $employment_status_id = intval($request->employment_status_id);
        $employment_status_name = $request->employment_status_name;
        $display_order = $request->display_order;

        $operator = 9999;
        try {

            if($employment_status_id == 0){            
                //新規登録処理
                employment_status_m_model::create(
                    [
                        'employment_status_name' => $employment_status_name,
                        'display_order' => $display_order,
                        'created_by' => $operator,                        
                    ]
                );            

            }else{
                //更新処理
                employment_status_m_model::
                where('employment_status_id', $employment_status_id)                
                ->update(
                    [
                        'employment_status_name' => $employment_status_name,  
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

   
    // 論理削除処理
    function delete_or_restore(Request $request)
    {
        $delete_flg = intval($request->delete_flg);

        $employment_status_id = intval($request->delete_employment_status_id);
        $employment_status_name = $request->delete_employment_status_name;
        
        if($delete_flg == 0){
            $process_title = "雇用形態マスタ削除処理";
        }else{
            $process_title = "雇用形態マスタ削除取消処理";
        }

        $operator = 9999;

        try {
            if($delete_flg == 0){

                //論理削除
                employment_status_m_model::
                where('employment_status_id', $employment_status_id)                
                ->delete();

                session()->flash('success', '[雇用形態 = ' . $employment_status_name .']データを利用不可状態にしました');                
            }else{    

                //論理削除解除
                employment_status_m_model::
                where('employment_status_id', $employment_status_id)                
                ->withTrashed()                
                ->restore();

                session()->flash('success', '[雇用形態 = ' . $employment_status_name . ']データを利用可能状態にしました');                                
            }

        } catch (Exception $e) {

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            session()->flash('error', '[雇用形態 = ' . $employment_status_name .']データの利用状況変更処理時エラー'); 
           
        }   

        return back();
    }
}
