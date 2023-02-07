<?php

namespace App\Http\Controllers\Headquarters\Master;
use App\Http\Controllers\Controller;
use App\Models\maincategory_m_model;
use App\Models\subcategory_m_model;
use App\Models\school_m_model;
use App\Models\majorsubject_m_model;


use Illuminate\Http\Request;

use Exception;
use Illuminate\Support\Facades\Log;

class majorsubject_m_controller extends Controller
{
    function index(Request $request)
    {

        
        $majorsubject_m_list = array();

        
        //検索項目格納用配列
        $SearchElementArray = [
            'search_school_division' => $request->search_school_division,
            'search_school_cd' => $request->search_school_cd,
            'search_school_name' => $request->search_school_name,
            'search_majorsubject_name' => $request->search_majorsubject_name
        ];

        
        //プルダウン作成の為

        $school_division_list = subcategory_m_model::select(
            'subcategory_cd as school_division_cd',
            'subcategory_name as school_division_name',         
        )->where('maincategory_cd',3)
        ->orderBy('display_order', 'asc')        
        ->get();

        $school_m_list = school_m_model::select(

            'school_m.school_cd as school_cd',
            'school_m.school_name as school_name',
            'school_m.school_division as school_division',
            'school_m.deleted_at as deleted_at',
        )        
        ->orderBy('school_m.school_cd', 'asc')          
        ->get();
       

              
        $majorsubject_m_list = majorsubject_m_model::select(
            'majorsubject_m.school_cd as school_cd',
            'school_m.school_name as school_name',
            'school_m.school_division as school_division',
            'subcategory_m.subcategory_name as school_division_name',
            'majorsubject_m.majorsubject_cd as majorsubject_cd',
            'majorsubject_m.majorsubject_name as majorsubject_name',
            'majorsubject_m.studyperiod as studyperiod',
            'majorsubject_m.remarks as remarks',
            'majorsubject_m.deleted_at as deleted_at',
        )       
        ->leftJoin('school_m', function ($join) {
            $join->on('school_m.school_cd', '=', 'majorsubject_m.school_cd');
        })
        ->leftJoin('subcategory_m', function ($join) {
            $join->on('school_m.school_division', '=', 'subcategory_m.subcategory_cd');
        })       
        ->withTrashed()
        ->where('subcategory_m.maincategory_cd', '=', 3)        
        ->orderBy('majorsubject_m.school_cd', 'asc')        
        ->orderBy('majorsubject_m.majorsubject_cd', 'asc') ;
        
        if(!is_null($SearchElementArray['search_school_division'])){
            $majorsubject_m_list = $majorsubject_m_list->where('school_m.school_division', '=', $SearchElementArray['search_school_division']);
        }
        
        if(!is_null($SearchElementArray['search_school_cd'])){
            $majorsubject_m_list = $majorsubject_m_list->where('majorsubject_m.school_cd', '=', $SearchElementArray['search_school_cd']);
        }
        
        if(!is_null($SearchElementArray["search_school_name"])){
            $majorsubject_m_list = $majorsubject_m_list->where('school_m.school_name', 'like', '%' . $SearchElementArray['search_school_name'] . '%');
        } 
        
        if(!is_null($SearchElementArray["search_majorsubject_name"])){
            $majorsubject_m_list = $majorsubject_m_list->where('majorsubject_m.majorsubject_name', 'like', '%' . $SearchElementArray['search_majorsubject_name'] . '%');            
        } 

        $majorsubject_m_list = $majorsubject_m_list->paginate(env('Paginate_Count'));
      
        
        return view('headquarters/screen/master/majorsubject/index', compact('SearchElementArray','school_division_list','school_m_list','majorsubject_m_list'));
    }


    //  更新処理
    function save(request $request)
    {

        $processflg = intval($request->processflg);

        $school_cd = intval($request->school_cd);
        $majorsubject_cd = intval($request->majorsubject_cd);
        $majorsubject_name = $request->majorsubject_name;
        $studyperiod = intval($request->studyperiod);
        $remarks = $request->remarks;

        $operator = 9999;
        
        try {

            if($processflg == 0){

                //新規登録処理
                $max_majorsubject_cd = majorsubject_m_model::
                where('school_cd', $school_cd)                
                ->max('majorsubject_cd');
            
                if(is_null($max_majorsubject_cd)){
                    $majorsubject_cd = 1;
                }else{
                    $majorsubject_cd = $max_majorsubject_cd + 1; 
                }
                
                majorsubject_m_model::create(
                    [
                        'school_cd' => $school_cd,                        
                        'majorsubject_cd' => $majorsubject_cd,     
                        'majorsubject_name' => $majorsubject_name,
                        'studyperiod' => $studyperiod,
                        'remarks' => $remarks,
                        'created_by' => $operator,
                        
                    ]
                );            

            }else{
                
                //更新処理
                majorsubject_m_model::
                where('school_cd', $school_cd)
                ->where('majorsubject_cd', $majorsubject_cd)
                ->update(
                    [
                        'majorsubject_name' => $majorsubject_name,
                        'studyperiod' => $studyperiod,
                        'remarks' => $remarks,
                        'created_by' => $operator,          
                    ]
                );
            }
    
        } catch (Exception $e) {            
            
            $ErrorMessage = '【学校別専攻マスタ登録エラー】' . $e->getMessage();            

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
        $school_cd = intval($request->delete_school_cd);
        $majorsubject_cd = intval($request->delete_majorsubject_cd);
        $school_name = $request->delete_school_name;           
        $majorsubject_name = $request->delete_majorsubject_name;  

        try {

            
            if($delete_flg == 0){

                //論理削除
                majorsubject_m_model::
                where('school_cd', $school_cd)
                ->where('majorsubject_cd', $majorsubject_cd)
                ->delete();

                session()->flash('success', '[学校名 = ' . $school_name . ' 専攻名 = ' . $majorsubject_name . ']データを利用不可状態にしました');
            }else{    

                //論理削除解除
                majorsubject_m_model::
                where('school_cd', $school_cd)
                ->where('majorsubject_cd', $majorsubject_cd)
                ->withTrashed()                
                ->restore();

                session()->flash('success', '[学校名 = ' . $school_name . ' 専攻名 = ' . $majorsubject_name . ']データを利用可能状態にしました');
            }

        } catch (Exception $e) {

            $ErrorMessage = '【専攻マスタ利用状況変更処理時エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

            session()->flash('success', '[学校名 = ' . $school_name . ' 専攻名 = ' . $majorsubject_name . ']データの利用状況変更処理時エラー');            
           
        }       

        return back();
    }








}
