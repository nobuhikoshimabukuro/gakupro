<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use App\Models\maincategory_m_model;
use App\Models\subcategory_m_model;
use App\Http\Requests\subcategory_m_request;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

use Exception;

class subcategory_m_controller extends Controller
{
    function index()
    {
        $maincategory_m_list = maincategory_m_model::orderBy('maincategory_cd', 'asc')->get();

        $subcategory_m_list = subcategory_m_model::select(

            
            'subcategory_m.maincategory_cd as maincategory_cd',
            'maincategory_m.maincategory_name as maincategory_name',
            'subcategory_m.subcategory_cd as subcategory_cd',                        
            'subcategory_m.subcategory_name as subcategory_name',
            'subcategory_m.display_order as display_order',
            
            'subcategory_m.deleted_at as deleted_at',
        )
        ->leftJoin('maincategory_m', function ($join) {
            $join->on('subcategory_m.maincategory_cd', '=', 'maincategory_m.maincategory_cd');
        })
        ->orderBy('subcategory_m.maincategory_cd', 'asc')
        ->orderBy('subcategory_m.display_order', 'asc')
        ->withTrashed()->get();

        return view('headquarters/screen/master/subcategory/index', compact('subcategory_m_list','maincategory_m_list'));        
    }


    //  更新処理
    function save(request $request)
    {

        $processflg = intval($request->processflg);

        $maincategory_cd = intval($request->maincategory_cd);
        $subcategory_cd = intval($request->subcategory_cd);
        $subcategory_name = $request->subcategory_name;
        $display_order = intval($request->display_order);

        $operator = 9999;
        try {

            if($processflg == 0){
                //新規登録処理
                $subcategory_cd = subcategory_m_model::
                where('maincategory_cd', $maincategory_cd)
                ->max('subcategory_cd');

                if(is_null($subcategory_cd)){
                    $subcategory_cd = 1;
                }else{
                    $subcategory_cd++; 
                }
                
                subcategory_m_model::create(
                    [
                        'maincategory_cd' => $maincategory_cd,                        
                        'subcategory_cd' => $subcategory_cd,     
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
                        'subcategory_name' => $subcategory_name,
                        'display_order' => $display_order,  
                        'updated_by' => $operator,            
                    ]
                );
            }
    
        } catch (Exception $e) {            
            
            $ErrorMessage = '【中分類マスタ登録エラー】' . $e->getMessage();            

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

        session()->flash('success', 'データを登録しました。');
        session()->flash('message-type', 'success');
        return response()->json(['ResultArray' => $ResultArray]);
    }

    //  論理削除処理
    function delete_or_restore(Request $request)
    {
        $delete_flg = intval($request->delete_flg);

        $maincategory_cd = intval($request->delete_maincategory_cd);
        $subcategory_cd = intval($request->delete_subcategory_cd);

        $maincategory_name = $request->delete_maincategory_name;
        $subcategory_name = $request->delete_subcategory_name;

        $result = $this->delete_or_restore_process($maincategory_cd , $subcategory_cd , $delete_flg);

        if($result){

            if($delete_flg == 0){
                session()->flash('success', '[大分類 = ' . $maincategory_name . ' 中分類 = ' . $subcategory_name . ']データを利用不可状態にしました');                
            }else{    
                session()->flash('success', '[大分類 = ' . $maincategory_name . ' 中分類 = ' . $subcategory_name . ']データを利用可能状態にしました');                                
            }
            
        }else{
            session()->flash('error', '[大分類 = ' . $maincategory_name . ' 中分類 = ' . $subcategory_name . ']データの利用状況変更処理時エラー'); 
        }

        return back();
    }

    function delete_or_restore_process($maincategory_cd , $subcategory_cd , $delete_flg)
    {

        $result = true;      

        try {

            if($delete_flg == 0){

                subcategory_m_model::
                where('maincategory_cd', $maincategory_cd)
                ->where('subcategory_cd', $subcategory_cd)
                ->delete();

            }else{
                
                subcategory_m_model::
                where('maincategory_cd', $maincategory_cd)
                ->where('subcategory_cd', $subcategory_cd)
                ->restore();
              
            }
                

        } catch (Exception $e) {

            $result = false;           
            
            $ErrorMessage = '【中分類マスタ利用状況変更時エラー】' . $e->getMessage();

            Log::channel('error_log')->info($ErrorMessage);
        
        }       

        return $result;

    }


    

   
}
