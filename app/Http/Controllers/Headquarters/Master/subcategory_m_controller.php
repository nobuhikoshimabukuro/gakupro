<?php

namespace App\Http\Controllers\Headquarters\Master;
use App\Http\Controllers\Controller;
use App\Models\maincategory_m_model;
use App\Models\subcategory_m_model;
use App\Http\Requests\subcategory_m_request;

use Carbon\Carbon;

use Exception;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;



class subcategory_m_controller extends Controller
{
    function index(Request $request)
    {

        //検索項目格納用配列
        $SearchElementArray = [
            'search_maincategory_cd' => $request->search_maincategory_cd,
            'search_subcategory_name' => $request->search_subcategory_name,
        ];

        //プルダウン作成の為
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
        ->withTrashed();
        
        if(!is_null($SearchElementArray['search_maincategory_cd'])){
            $subcategory_m_list = $subcategory_m_list->where('subcategory_m.maincategory_cd', '=', $SearchElementArray['search_maincategory_cd']);
        }

        if(!is_null($SearchElementArray['search_subcategory_name'])){            
            $subcategory_m_list = $subcategory_m_list->where('subcategory_m.subcategory_name', 'like', '%' . $SearchElementArray['search_subcategory_name'] . '%');
        }

        $subcategory_m_list = $subcategory_m_list->paginate(env('Paginate_Count'));

        return view('headquarters/screen/master/subcategory/index', compact('SearchElementArray','subcategory_m_list','maincategory_m_list'));        
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

                //同様の登録がないかチェック
                //同じ大分類かつ中分類名が一致する場合はinfoする
                $existence_check = subcategory_m_model::
                where('maincategory_cd', $maincategory_cd)
                ->where('subcategory_name', $subcategory_name)
                ->exists();
                
                if($existence_check){

                    $ResultArray = array(
                        "Result" => "error",
                        "Message" => '選択した大分類で同じ中分類名が存在します。',
                    );    
                    return response()->json(['ResultArray' => $ResultArray]);
                }
                
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

                 //同様の登録がないかチェック
                //同じ大分類かつ中分類名が一致する場合はinfoする
                $existence_check = subcategory_m_model::
                where('maincategory_cd', $maincategory_cd)
                ->where('subcategory_cd', '<>',$subcategory_cd)
                ->where('subcategory_name', $subcategory_name)
                ->exists();
                

                if($existence_check){

                    $ResultArray = array(
                        "Result" => "error",
                        "Message" => '選択した大分類で同じ中分類名が存在します。',
                    );    
                    return response()->json(['ResultArray' => $ResultArray]);
                }




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

        try {

            
            if($delete_flg == 0){

                //論理削除
                subcategory_m_model::
                where('maincategory_cd', $maincategory_cd)
                ->where('subcategory_cd', $subcategory_cd)
                ->delete();

                session()->flash('success', '[大分類名 = ' . $maincategory_name . ' 中分類名 = ' . $subcategory_name . ']データを利用不可状態にしました');
            }else{    

                //論理削除解除
                subcategory_m_model::
                where('maincategory_cd', $maincategory_cd)
                ->where('subcategory_cd', $subcategory_cd)
                ->withTrashed()                
                ->restore();

                session()->flash('success', '[大分類名 = ' . $maincategory_name . ' 中分類名 = ' . $subcategory_name . ']データを利用可能状態にしました');
            }

        } catch (Exception $e) {

            $ErrorMessage = '【中分類マスタ利用状況変更処理時エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

            session()->flash('error', '[大分類名 = ' . $maincategory_name . ' 中分類 = ' . $subcategory_name . ']データの利用状況変更処理時エラー'); 
           
        }       

        return back();
    }

   
    // function status_change_prepare($delete_flg)
    // {

    //     $result = true;    

    //     $operator = 9999;        

    //     $datetime_now = Carbon::now()->toDateTimeString();
        
    //     $updated_at = $datetime_now;
    //     $updated_by = $operator;
    //     $deleted_at = null;
    //     $deleted_by = null;

    //     if($delete_flg == 0){          
    //         $deleted_at = $datetime_now;
    //         $deleted_by = $operator;
    //     }


    //     $ReturnArray = [
    //         'updated_at' => $updated_at,
    //         'updated_by' => $updated_by,
    //         'deleted_at' => $deleted_at,
    //         'deleted_by' => $deleted_by,            
    //     ];

    //     return $ReturnArray;
    // }


    

   
}
