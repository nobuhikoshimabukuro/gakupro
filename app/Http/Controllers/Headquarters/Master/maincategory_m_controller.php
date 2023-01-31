<?php

namespace App\Http\Controllers\Headquarters\Master;
use App\Http\Controllers\Controller;

use Exception;
use Illuminate\Support\Facades\Log;

use App\Original\Common;

use App\Models\maincategory_m_model;
use App\Http\Requests\maincategory_m_request;

use Illuminate\Http\Request;





class maincategory_m_controller extends Controller
{
    
    function index(Request $request)
    {
        //検索項目格納用配列
        $SearchElementArray = [
            'search_maincategory_name' => $request->search_maincategory_name                   
        ];

        $maincategory_m_list = maincategory_m_model::withTrashed()->orderBy('maincategory_cd', 'asc');
            

        if(!is_null($SearchElementArray['search_maincategory_name'])){            
            $maincategory_m_list = $maincategory_m_list->where('maincategory_m.maincategory_name', 'like', '%' . $SearchElementArray['search_maincategory_name'] . '%');
        }

        $maincategory_m_list = $maincategory_m_list->paginate(env('Paginate_Count'));

        return view('headquarters/screen/master/maincategory/index', compact('SearchElementArray','maincategory_m_list'));
    }


    //  更新処理
    function save(maincategory_m_request $request)
    {

        $maincategory_cd = intval($request->maincategory_cd);
        $maincategory_name = $request->maincategory_name;

        $operator = 9999;
        try {

            if($maincategory_cd == 0){            
                //新規登録処理
                maincategory_m_model::create(
                    [
                        'maincategory_name' => $maincategory_name,
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
                        'updated_by' => $operator,            
                    ]
                );

            }         
    
        } catch (Exception $e) {

                        
            $ErrorTitle = '大分類マスタ登録エラー';
            $ErrorMessage = $e->getMessage();
                      
            Common::SendErrorMail($ErrorTitle,$ErrorMessage);

            $LogErrorMessage = $ErrorTitle .'::' .$ErrorMessage;
            Log::channel('error_log')->info($LogErrorMessage);

            $ResultArray = array(
                "Result" => "error",
                "Message" => $ErrorTitle,
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

   
    // 論理削除処理
    function delete_or_restore(Request $request)
    {
        $delete_flg = intval($request->delete_flg);

        $maincategory_cd = intval($request->delete_maincategory_cd);
        $maincategory_name = $request->delete_maincategory_name;
        
        $operator = 9999;

        try {
            if($delete_flg == 0){

                //論理削除
                maincategory_m_model::
                where('maincategory_cd', $maincategory_cd)                
                ->delete();

                session()->flash('success', '[大分類名 = ' . $maincategory_name .']データを利用不可状態にしました');                
            }else{    

                //論理削除解除
                maincategory_m_model::
                where('maincategory_cd', $maincategory_cd)                
                ->withTrashed()                
                ->restore();

                session()->flash('success', '[大分類名 = ' . $maincategory_name . ']データを利用可能状態にしました');                                
            }

        } catch (Exception $e) {

            $ErrorMessage = '【大分類マスタ利用状況変更処理時エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

            session()->flash('error', '[大分類名 = ' . $maincategory_name . ']データの利用状況変更処理時エラー'); 
           
        }       

        return back();
    }



}
