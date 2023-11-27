<?php

namespace App\Http\Controllers\headquarters\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Exception;
use Illuminate\Support\Facades\Log;

use App\Original\common;

use App\Models\job_password_item_m_model;




class job_password_item_m_controller extends Controller
{
    function index(Request $request)
    {
        //検索項目格納用配列
        $search_element_array = [
            'search_job_password_item_name' => $request->search_job_password_item_name
            ,'search_job_password_item_name' => $request->search_job_password_item_name
        ];

        $job_password_item_m_list = job_password_item_m_model::withTrashed()->orderBy('job_password_item_id', 'asc');
            

        if(!is_null($search_element_array['search_job_password_item_name'])){            
            $job_password_item_m_list = $job_password_item_m_list->where('job_password_item_m.job_password_item_name', 'like', '%' . $search_element_array['search_job_password_item_name'] . '%');
        }

        $job_password_item_m_list = $job_password_item_m_list->paginate(env('paginate_count'));

        return view('headquarters/screen/master/job_password_item/index', compact('search_element_array','job_password_item_m_list'));
    }


    //  更新処理
    function save(Request $request)
    {

        $process_title = "求人パスワード商品マスタ登録処理";
        $job_password_item_id = intval($request->job_password_item_id);
        $job_password_item_name = $request->job_password_item_name;
        $price = intval($request->price);
        $added_date = intval($request->added_date);
        $sales_start_date = $request->sales_start_date;
        $sales_end_date = $request->sales_end_date;

        $remarks = $request->remarks;

        $operator = 9999;

        try {

            if($job_password_item_id == 0){

                //新規登録処理
                job_password_item_m_model::create(
                    [
                        'job_password_item_name' => $job_password_item_name,
                        'price' => $price,
                        'added_date' => $added_date,
                        'sales_start_date' => $sales_start_date,
                        'sales_end_date' => $sales_end_date,                        
                        'remarks' => $remarks,
                        'created_by' => $operator,
                    ]
                );    

            }else{

                //更新処理
                job_password_item_m_model::
                where('job_password_item_id', $job_password_item_id)                
                ->update(
                    [
                        'job_password_item_name' => $job_password_item_name,
                        'price' => $price,
                        'added_date' => $added_date,
                        'sales_start_date' => $sales_start_date,
                        'sales_end_date' => $sales_end_date,                        
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

        $job_password_item_id = intval($request->delete_job_password_item_id);
        $job_password_item_name = $request->delete_job_password_item_name;
        
        if($delete_flg == 0){
            $process_title = "求人パスワード商品マスタ削除処理";
        }else{
            $process_title = "求人パスワード商品マスタ削除取消処理";
        }

        $operator = 9999;

        try {
            if($delete_flg == 0){

                //論理削除
                job_password_item_m_model::
                where('job_password_item_id', $job_password_item_id)                
                ->delete();

                session()->flash('success', '[求人パスワード商品名 = ' . $job_password_item_name .']データを利用不可状態にしました');        
            }else{    

                //論理削除解除
                job_password_item_m_model::
                where('job_password_item_id', $job_password_item_id)                
                ->withTrashed()                
                ->restore();

                session()->flash('success', '[求人パスワード商品名 = ' . $job_password_item_name . ']データを利用可能状態にしました');                        
            }

        } catch (Exception $e) {

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            session()->flash('error', '[求人パスワード商品名 = ' . $job_password_item_name .']データの利用状況変更処理時エラー'); 
           
        }   

        return back();
    }
}
