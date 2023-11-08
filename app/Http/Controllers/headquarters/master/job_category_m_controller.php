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
use App\Models\job_subcategory_m_model;

class job_category_m_controller extends Controller
{
    function index(Request $request)
    {

        $job_maincategory_cd_array = [];
        //検索項目格納用配列
        $search_element_array = [
            'search_job_maincategory_cd' => $request->search_job_maincategory_cd,
            'search_job_maincategory_name' => $request->search_job_maincategory_name,            
            'search_job_subcategory_name' => $request->search_job_subcategory_name,
        ];

        $job_maincategory_m_list = job_maincategory_m_model::orderBy('job_maincategory_m.job_maincategory_cd', 'asc')        
        ->withTrashed();

        if(!is_null($search_element_array['search_job_maincategory_cd'])){
            $job_maincategory_m_list = $job_maincategory_m_list
            ->where('job_maincategory_m.job_maincategory_cd', '=', $search_element_array['search_job_maincategory_cd']);
        }

        if(!is_null($search_element_array['search_job_maincategory_name'])){
            $search_job_maincategory_name = $search_element_array["search_job_maincategory_name"];
     
            $job_maincategory_m_list = $job_maincategory_m_list
            ->where('job_maincategory_m.job_maincategory_name', 'LIKE', "%$search_job_maincategory_name%");
        }        

        $job_maincategory_m_list = $job_maincategory_m_list->paginate(30);

        foreach ($job_maincategory_m_list as $info) {
            $job_maincategory_cd_array[] = $info->job_maincategory_cd;
        }


        $job_subcategory_m_list = job_subcategory_m_model::select(
            
            'job_maincategory_m.job_maincategory_cd as job_maincategory_cd',
            'job_maincategory_m.job_maincategory_name as job_maincategory_name',
            'job_maincategory_m.display_order as job_maincategory_display_order',
            
            'job_subcategory_m.job_subcategory_cd as job_subcategory_cd',                        
            'job_subcategory_m.job_subcategory_name as job_subcategory_name',
            'job_subcategory_m.display_order as job_subcategory_display_order',            
            'job_subcategory_m.deleted_at as deleted_at',
        )
        ->leftJoin('job_maincategory_m', function ($join) {
            $join->on('job_subcategory_m.job_maincategory_cd', '=', 'job_maincategory_m.job_maincategory_cd');
        })
        ->orderBy('job_maincategory_m.display_order', 'asc')
        ->orderBy('job_subcategory_m.display_order', 'asc')
        ->whereNull('job_maincategory_m.deleted_at')
        ->withTrashed();


        if(count($job_maincategory_cd_array) > 0){
            $job_subcategory_m_list = $job_subcategory_m_list
            ->whereIn('job_maincategory_m.job_maincategory_cd', $job_maincategory_cd_array);
        }       

        if(!is_null($search_element_array['search_job_subcategory_name'])){
            $search_job_subcategory_name = $search_element_array["search_job_subcategory_name"];     
            $job_subcategory_m_list = $job_subcategory_m_list
            ->where('job_subcategory_m.job_subcategory_name', 'LIKE', "%$search_job_subcategory_name%");
        }       

        $job_subcategory_m_list = $job_subcategory_m_list->paginate(30);

        $job_maincategory_list = create_list::job_maincategory_list();

        return view('headquarters/screen/master/job_category/index', 
        compact('search_element_array','job_maincategory_list','job_maincategory_m_list','job_subcategory_m_list'));
        
    }


    function job_maincategory_save(Request $request)
    {
        $process_title = "職種大分類マスタ登録処理";
        $job_maincategory_cd = intval($request->job_maincategory_cd);
        $job_maincategory_name = $request->job_maincategory_name;
        $display_order = $request->job_maincategory_display_order;
        
        $operator = 9999;
        try {

            if($job_maincategory_cd == 0){            
                //新規登録処理
                job_maincategory_m_model::create(
                    [
                        'job_maincategory_name' => $job_maincategory_name,
                        'display_order' => $display_order,
                        'created_by' => $operator,                        
                    ]
                );            

            }else{
                //更新処理
                job_maincategory_m_model::
                where('job_maincategory_cd', $job_maincategory_cd)                
                ->update(
                    [
                        'job_maincategory_name' => $job_maincategory_name,
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

    function job_maincategory_delete_or_restore(Request $request)
    {        
        $delete_flg = intval($request->delete_job_maincategory_flg);
        $job_maincategory_cd = intval($request->delete_job_maincategory_cd);
        $job_maincategory_name = $request->delete_job_maincategory_name;

        if($delete_flg == 0){
            $process_title = "職種大分類マスタ削除処理";
        }else{
            $process_title = "職種大分類マスタ削除取消処理";
        }
        

        try {

            
            if($delete_flg == 0){

                //論理削除
                job_maincategory_m_model::
                where('job_maincategory_cd', $job_maincategory_cd)                
                ->delete();

                session()->flash('success', '[職種大分類名 = ' . $job_maincategory_name . ']データを利用不可状態にしました');
            }else{    

                //論理削除解除
                job_maincategory_m_model::
                where('job_maincategory_cd', $job_maincategory_cd)  
                ->withTrashed()                
                ->restore();
                session()->flash('success', '[職種大分類名 = ' . $job_maincategory_name . ']データを利用可能状態にしました');                
            }

        } catch (Exception $e) {

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            session()->flash('error', '[職種大分類名 = ' . $job_maincategory_name .']データの利用状況変更処理時エラー'); 
           
        }       

        return back();

    }

    function job_subcategory_save(Request $request)
    {
        $process_title = "職種中分類マスタ登録処理";
        $job_maincategory_cd = intval($request->job_maincategory_cd_for_sub);
        $job_subcategory_cd = intval($request->job_subcategory_cd);
        $job_subcategory_name = $request->job_subcategory_name;
        $display_order = $request->job_subcategory_display_order;
        
        $operator = 9999;
        try {

            if($job_subcategory_cd == 0){            
                //新規登録処理
                job_subcategory_m_model::create(
                    [
                        'job_maincategory_cd' => $job_maincategory_cd,
                        'job_subcategory_name' => $job_subcategory_name,
                        'display_order' => $display_order,
                        'created_by' => $operator,                        
                    ]
                );            

            }else{
                //更新処理
                job_subcategory_m_model::
                where('job_subcategory_cd', $job_subcategory_cd)                
                ->update(
                    [
                        'job_maincategory_cd' => $job_maincategory_cd,
                        'job_subcategory_name' => $job_subcategory_name,
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

    function job_subcategory_delete_or_restore(Request $request)
    {

        $delete_flg = intval($request->delete_job_subcategory_flg);
        $job_subcategory_cd = intval($request->delete_job_subcategory_cd);
        $job_subcategory_name = $request->delete_job_subcategory_name;

        if($delete_flg == 0){
            $process_title = "職種中分類マスタ削除処理";
        }else{
            $process_title = "職種中分類マスタ削除取消処理";
        }
        

        try {

            
            if($delete_flg == 0){

                //論理削除
                job_subcategory_m_model::
                where('job_subcategory_cd', $job_subcategory_cd)                
                ->delete();

                session()->flash('success', '[職種中分類名 = ' . $job_subcategory_name . ']データを利用不可状態にしました');
            }else{    

                //論理削除解除
                job_subcategory_m_model::
                where('job_subcategory_cd', $job_subcategory_cd)  
                ->withTrashed()                
                ->restore();
                session()->flash('success', '[職種中分類名 = ' . $job_subcategory_name . ']データを利用可能状態にしました');                
            }

        } catch (Exception $e) {

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            session()->flash('error', '[職種中分類名 = ' . $job_subcategory_name .']データの利用状況変更処理時エラー'); 
           
        }       

        return back();
        
    }
}
