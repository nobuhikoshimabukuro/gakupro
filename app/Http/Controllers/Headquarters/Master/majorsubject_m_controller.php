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

        $school_cd = $request->school_cd;
        $school_info = null;
        $majorsubject_m_list = array();

        if(!is_null($school_cd)){

            $school_info = school_m_model::select(

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
            ->withTrashed()       
            ->first();
    
            $majorsubject_m_list = majorsubject_m_model::select(
    
                'majorsubject_m.id as id',
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
            ->where('majorsubject_m.school_cd', '=', $school_cd)
            ->where('subcategory_m.maincategory_cd', '=', 2)        
            ->orderBy('majorsubject_m.school_cd', 'asc')        
            ->orderBy('majorsubject_m.majorsubject_cd', 'asc') 
            ->withTrashed()
            ->get();       

        }        
        return view('headquarters/screen/master/majorsubject/index', compact('school_info','majorsubject_m_list'));
    }



    //  論理削除処理
    function delete_or_restore(Request $request)
    {
        $delete_flg = intval($request->delete_flg);
        $id = intval($request->delete_id);
        $school_name = $request->delete_school_name;           
        $majorsubject_name = $request->delete_majorsubject_name;  

        try {

            
            if($delete_flg == 0){

                //論理削除
                majorsubject_m_model::
                where('id', $id)                
                ->delete();

                session()->flash('success', '[学校名 = ' . $school_name . ' 専攻名 = ' . $majorsubject_name . ']データを利用不可状態にしました');
            }else{    

                //論理削除解除
                majorsubject_m_model::
                where('id', $id)                
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
