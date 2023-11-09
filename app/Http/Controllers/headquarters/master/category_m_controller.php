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

use App\Models\maincategory_m_model;
use App\Models\subcategory_m_model;

class category_m_controller extends Controller
{
    function index(Request $request)
    {

        $maincategory_cd_array = [];
        //検索項目格納用配列
        $search_element_array = [
            'search_maincategory_cd' => $request->search_maincategory_cd,
            'search_maincategory_name' => $request->search_maincategory_name,            
            'search_subcategory_name' => $request->search_subcategory_name,
        ];

        $maincategory_m_list = maincategory_m_model::orderBy('maincategory_m.maincategory_cd', 'asc')        
        ->withTrashed();

        if(!is_null($search_element_array['search_maincategory_cd'])){
            $maincategory_m_list = $maincategory_m_list
            ->where('maincategory_m.maincategory_cd', '=', $search_element_array['search_maincategory_cd']);
        }

        if(!is_null($search_element_array['search_maincategory_name'])){
            $search_maincategory_name = $search_element_array["search_maincategory_name"];
     
            $maincategory_m_list = $maincategory_m_list
            ->where('maincategory_m.maincategory_name', 'LIKE', "%$search_maincategory_name%");
        }        

        $maincategory_m_list = $maincategory_m_list->paginate(30);

        foreach ($maincategory_m_list as $info) {
            $maincategory_cd_array[] = $info->maincategory_cd;
        }


        $subcategory_m_list = subcategory_m_model::select(
            
            'maincategory_m.maincategory_cd as maincategory_cd',
            'maincategory_m.maincategory_name as maincategory_name',
            'maincategory_m.display_order as maincategory_display_order',
            
            'subcategory_m.subcategory_cd as subcategory_cd',                        
            'subcategory_m.subcategory_name as subcategory_name',
            'subcategory_m.display_order as subcategory_display_order',            
            'subcategory_m.deleted_at as deleted_at',
        )
        ->leftJoin('maincategory_m', function ($join) {
            $join->on('subcategory_m.maincategory_cd', '=', 'maincategory_m.maincategory_cd');
        })
        ->orderBy('maincategory_m.display_order', 'asc')
        ->orderBy('subcategory_m.display_order', 'asc')
        ->whereNull('maincategory_m.deleted_at')
        ->withTrashed();


        if(count($maincategory_cd_array) > 0){
            $subcategory_m_list = $subcategory_m_list
            ->whereIn('maincategory_m.maincategory_cd', $maincategory_cd_array);
        }       

        if(!is_null($search_element_array['search_subcategory_name'])){
            $search_subcategory_name = $search_element_array["search_subcategory_name"];     
            $subcategory_m_list = $subcategory_m_list
            ->where('subcategory_m.subcategory_name', 'LIKE', "%$search_subcategory_name%");
        }       

        $subcategory_m_list = $subcategory_m_list->paginate(30);

        $maincategory_list = create_list::maincategory_list();

        return view('headquarters/screen/master/category/index', 
        compact('search_element_array','maincategory_list','maincategory_m_list','subcategory_m_list'));
        
    }


    function maincategory_save(Request $request)
    {
        $process_title = "大分類マスタ登録処理";
        $maincategory_cd = intval($request->maincategory_cd);
        $maincategory_name = $request->maincategory_name;
        $display_order = $request->maincategory_display_order;
        
        $operator = 9999;
        try {

            if($maincategory_cd == 0){            
                //新規登録処理
                maincategory_m_model::create(
                    [
                        'maincategory_name' => $maincategory_name,
                        'display_order' => $display_order,
                        'created_by' => $operator,                        
                    ]
                );            

            }else{
                //更新処理
                maincategory_m_model::
                where('maincategory_cd', $maincategory_cd)                
                ->update(
                    [
                        'maincategory_name' => $maincategory_name,
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

    function maincategory_delete_or_restore(Request $request)
    {        
        $delete_flg = intval($request->delete_maincategory_flg);
        $maincategory_cd = intval($request->delete_maincategory_cd);
        $maincategory_name = $request->delete_maincategory_name;

        if($delete_flg == 0){
            $process_title = "大分類マスタ削除処理";
        }else{
            $process_title = "大分類マスタ削除取消処理";
        }
        

        try {

            
            if($delete_flg == 0){

                //論理削除
                maincategory_m_model::
                where('maincategory_cd', $maincategory_cd)                
                ->delete();

                session()->flash('success', '[大分類名 = ' . $maincategory_name . ']データを利用不可状態にしました');
            }else{    

                //論理削除解除
                maincategory_m_model::
                where('maincategory_cd', $maincategory_cd)  
                ->withTrashed()                
                ->restore();
                session()->flash('success', '[大分類名 = ' . $maincategory_name . ']データを利用可能状態にしました');                
            }

        } catch (Exception $e) {

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            session()->flash('error', '[大分類名 = ' . $maincategory_name .']データの利用状況変更処理時エラー'); 
           
        }       

        return back();

    }

    function subcategory_save(Request $request)
    {
        $process_title = "中分類マスタ登録処理";
        $maincategory_cd = intval($request->maincategory_cd_for_sub);
        $subcategory_cd = intval($request->subcategory_cd);
        $subcategory_name = $request->subcategory_name;
        $display_order = $request->subcategory_display_order;
        
        $operator = 9999;
        try {

            if($subcategory_cd == 0){            
                //新規登録処理
                subcategory_m_model::create(
                    [
                        'maincategory_cd' => $maincategory_cd,
                        'subcategory_name' => $subcategory_name,
                        'display_order' => $display_order,
                        'created_by' => $operator,                        
                    ]
                );            

            }else{
                //更新処理
                subcategory_m_model::
                where('maincategory_cd', $maincategory_cd)
                ->where('subcategory_cd', $subcategory_cd)                
                ->update(
                    [
                        'maincategory_cd' => $maincategory_cd,
                        'subcategory_name' => $subcategory_name,
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

    function subcategory_delete_or_restore(Request $request)
    {

        $delete_flg = intval($request->delete_subcategory_flg);
        $maincategory_cd = intval($request->delete_maincategory_cd_for_sub);
        $subcategory_cd = intval($request->delete_subcategory_cd);
        $subcategory_name = $request->delete_subcategory_name;

        if($delete_flg == 0){
            $process_title = "中分類マスタ削除処理";
        }else{
            $process_title = "中分類マスタ削除取消処理";
        }
        

        try {

            
            if($delete_flg == 0){

                //論理削除
                subcategory_m_model::
                where('maincategory_cd', $maincategory_cd)    
                ->where('subcategory_cd', $subcategory_cd)                
                ->delete();

                session()->flash('success', '[中分類名 = ' . $subcategory_name . ']データを利用不可状態にしました');
            }else{    

                //論理削除解除
                subcategory_m_model::
                where('maincategory_cd', $maincategory_cd)    
                ->where('subcategory_cd', $subcategory_cd)  
                ->withTrashed()                
                ->restore();
                session()->flash('success', '[中分類名 = ' . $subcategory_name . ']データを利用可能状態にしました');                
            }

        } catch (Exception $e) {

            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            session()->flash('error', '[中分類名 = ' . $subcategory_name .']データの利用状況変更処理時エラー'); 
           
        }       

        return back();
        
    }
}
