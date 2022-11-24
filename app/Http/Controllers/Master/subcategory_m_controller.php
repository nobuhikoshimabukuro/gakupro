<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use App\Models\maincategory_m_model;
use App\Models\subcategory_m_model;
use App\Http\Requests\subcategory_m_request;

use Illuminate\Http\Request;

use Exception;

class subcategory_m_controller extends Controller
{
    function index()
    {
        $maincategory_m_list = maincategory_m_model::orderBy('maincategory_cd', 'asc')->get();

        $subcategory_m_list = subcategory_m_model::select(

            'subcategory_m.subcategory_cd as subcategory_cd',
            'subcategory_m.maincategory_cd as maincategory_cd',
            'maincategory_m.maincategory_name as maincategory_name',
            'subcategory_m.display_order as display_order',
            'subcategory_m.subcategory_name as subcategory_name',
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

        $subcategory_cd = intval($request->subcategory_cd);

        $maincategory_cd = intval($request->maincategory_cd);                
        $subcategory_name = $request->subcategory_name;
        $display_order = intval($request->display_order);

        try {


            subcategory_m_model::updateOrInsert(
                ['subcategory_cd' => $subcategory_cd],
    
                [
                    'maincategory_cd' => $maincategory_cd,                        
                    'subcategory_name' => $subcategory_name,
                    'display_order' => $display_order,
                  
                ]
            );


    
        } catch (Exception $e) {

            $e->getMessage();
            
            $ErrorMessage = '中分類マスタ登録エラー';

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
    function delete(Request $request)
    {
        $delete_subcategory_cd = intval($request->delete_subcategory_cd);
        $maincategory_name = $request->delete_maincategory_name;
        $subcategory_name = $request->delete_subcategory_name;
        try {
            $mcon = subcategory_m_model::destroy($delete_subcategory_cd);
            session()->flash('success', '[大分類 = ' . $maincategory_name . ' 中分類 = ' . $subcategory_name . ']データを利用不可状態にしました');
        } catch (Exception $e) {

            $e->getMessage();            
            
            $ErrorMessage = '中分類マスタ利用不可処理時エラー';

            session()->flash('error', '[大分類 = ' . $maincategory_name . ' 中分類 = ' . $subcategory_name . ']データの利用不可処理時にエラー');            
        }


        return back();
    }

    //  論理削除取り消し処理
    function restore(Request $request)
    {
        $delete_subcategory_cd = intval($request->delete_subcategory_cd);
        $maincategory_name = $request->delete_maincategory_name;
        $subcategory_name = $request->delete_subcategory_name;

        try {
            $mcon = subcategory_m_model::where('subcategory_cd', $delete_subcategory_cd)->withTrashed()->get()->first();
            $mcon->restore();
            session()->flash('success', '[大分類 = ' . $maincategory_name . ' 中分類 = ' . $subcategory_name . ']データの利用不可状態を解除しました');
        } catch (Exception $e) {

            $e->getMessage();            
            
            $ErrorMessage = '中分類マスタ利用不可解除処理時エラー';
            
            session()->flash('error', '[大分類 = ' . $maincategory_name . ' 中分類 = ' . $subcategory_name . ']データの利用不可解除時にエラー');            
        }

        return back();
    }
}
