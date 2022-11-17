<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use App\Models\maincategory_m_model;
use App\Models\subcategory_m_model;
use App\Models\school_m_model;

use Illuminate\Http\Request;

use Exception;

class school_m_controller extends Controller
{
    function index()
    {
        $school_division_list = subcategory_m_model::select(
            'subcategory_cd as school_division_cd',
            'subcategory_name as school_division_name',         
        )->where('maincategory_cd',2)
        ->orderBy('display_order', 'asc')
        ->get();

        $school_m_list = school_m_model::select(

            'school_m.school_cd as school_cd',
            'school_m.school_division as school_division',
            'subcategory_m.subcategory_name as school_division_name',
            'school_m.school_name as school_name',
            'school_m.tel as tel',
            'school_m.hp_url as hp_url',
            'school_m.mailaddress as mailaddress',
            'school_m.deleted_at as deleted_at',
        )
        ->leftJoin('subcategory_m', function ($join) {
            $join->on('school_m.school_division', '=', 'subcategory_m.subcategory_cd');
        })
        ->where('maincategory_cd',2)
        ->orderBy('school_m.school_cd', 'asc')        
        ->get();

        return view('master/school/index', compact('school_m_list','school_division_list'));
    }


    //  更新処理
    function save(request $request)
    {

        $school_cd = intval($request->school_cd);

        $school_division = intval($request->school_division);        
        $school_name = $request->school_name;
        $tel = $request->tel;
        $hp_url = $request->hp_url;
        $mailaddress = $request->mailaddress;        

        try {


            if($school_cd == 0){

         
                school_m_model::create(
                    [
                        'school_division' => $school_division,
                        'school_name' => $school_name,
                        'tel' => $tel,
                        'hp_url' => $hp_url,
                        'mailaddress' => $mailaddress,
                      
                    ]
                );

            }else{


                school_m_model::where('school_cd', $school_cd)                    
                ->update(
                    [
                        'school_division' => $school_division,
                        'school_name' => $school_name,
                        'hp_url' => $hp_url,
                        'mailaddress' => $mailaddress,                  
                    
                    ]
                );

            
            }
          
    
        } catch (Exception $e) {

            $a = $e->getMessage();
            
            $ErrorMessage = '学校マスタ登録エラー';

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
