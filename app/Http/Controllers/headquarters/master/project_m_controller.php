<?php

namespace App\Http\Controllers\headquarters\master;
use App\Http\Controllers\Controller;

use Exception;
use Illuminate\Support\Facades\Log;

use App\Original\common;

use App\Models\project_m_model;
use App\Http\Requests\project_m_request;

use Illuminate\Http\Request;


class project_m_controller extends Controller
{
    
    function index(Request $request)
    {
        //検索項目格納用配列
        $search_element_array = [
            'search_project_name' => $request->search_project_name                   
        ];

        $project_m_list = project_m_model::withTrashed()->orderBy('project_id', 'asc');
            

        if(!is_null($search_element_array['search_project_name'])){            
            $project_m_list = $project_m_list->where('project_m.project_name', 'like', '%' . $search_element_array['search_project_name'] . '%');
        }

        $project_m_list = $project_m_list->paginate(env('paginate_count'));

        return view('headquarters/screen/master/project/index', compact('search_element_array','project_m_list'));
    }


    //  更新処理
    function save(Request $request)
    {

        $process_title = "プロジェクトマスタ登録処理";
        $project_id = intval($request->project_id);
        $project_name = $request->project_name;
        $remarks = $request->remarks;

        $operator = 9999;
        try {

            if($project_id == 0){            
                //新規登録処理
                project_m_model::create(
                    [
                        'project_name' => $project_name,
                        'remarks' => $remarks,
                        'created_by' => $operator,                        
                    ]
                );            

            }else{
                //更新処理
                project_m_model::
                where('project_id', $project_id)                
                ->update(
                    [
                        'project_name' => $project_name,  
                        'remarks' => $remarks,                      
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

        $project_id = intval($request->delete_project_id);
        $project_name = $request->delete_project_name;
        
        if($delete_flg == 0){
            $process_title = "プロジェクトマスタ削除処理";
        }else{
            $process_title = "プロジェクトマスタ削除取消処理";
        }

        $operator = 9999;

        try {
            if($delete_flg == 0){

                //論理削除
                project_m_model::
                where('project_id', $project_id)                
                ->delete();

                session()->flash('success', '[プロジェクト名 = ' . $project_name .']データを利用不可状態にしました');                
            }else{    

                //論理削除解除
                project_m_model::
                where('project_id', $project_id)                
                ->withTrashed()                
                ->restore();

                session()->flash('success', '[プロジェクト名 = ' . $project_name . ']データを利用可能状態にしました');                                
            }

        } catch (Exception $e) {

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            session()->flash('error', '[プロジェクト名 = ' . $project_name .']データの利用状況変更処理時エラー'); 
           
        }   

        return back();
    }



}
