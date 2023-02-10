<?php

namespace App\Http\Controllers\Headquarters\Master;
use App\Http\Controllers\Controller;
use App\Models\maincategory_m_model;
use App\Models\subcategory_m_model;
use App\Models\school_m_model;
use App\Models\majorsubject_m_model;

use App\Original\create_list;
use Illuminate\Http\Request;
use App\Http\Requests\school_m_request;

use Exception;
use Illuminate\Support\Facades\Log;

class school_m_controller extends Controller
{
    function index(Request $request)
    {

        //検索項目格納用配列
        $search_element_array = [
            'search_school_cd' => $request->search_school_cd,
            'search_school_division' => $request->search_school_division,
            'search_school_name' => $request->search_school_name           
        ];

        $school_division_list = create_list::school_division_list();
      
        $school_list = school_m_model::select(

            'school_m.school_cd as school_cd',
            'school_m.school_division as school_division',
            'school_division_info.subcategory_name as school_division_name',
            'school_m.school_name as school_name',
            'school_m.post_code as post_code',
            'school_m.address1 as address1',
            'school_m.address2 as address2',
            'school_m.tel as tel',
            'school_m.fax as fax',
            'school_m.hp_url as hp_url',
            'school_m.mailaddress as mailaddress',
            'school_m.remarks as remarks',
            
            'school_m.deleted_at as deleted_at',
        )
        ->leftJoin('subcategory_m as school_division_info', function ($join) {
            $join->on('school_division_info.subcategory_cd', '=', 'school_m.school_division')
                 ->where('school_division_info.maincategory_cd', '=', env('school_division_subcategory_cd'));
        })        
        ->orderBy('school_m.school_cd', 'asc') 
        ->withTrashed();       
        

        if(!is_null($search_element_array['search_school_cd'])){
            $school_list = $school_list->where('school_m.school_cd', '=', $search_element_array['search_school_cd']);
        }

        if(!is_null($search_element_array['search_school_division'])){
            $school_list = $school_list->where('school_m.school_division', '=', $search_element_array['search_school_division']);
        }
        
        if(!is_null($search_element_array["search_school_name"])){
            $school_list = $school_list->where('school_m.school_name', 'like', '%' . $search_element_array['search_school_name'] . '%');
        } 
      
        $school_list = $school_list->paginate(env('paginate_count'));    

        foreach($school_list as $info){

            $school_cd = $info->school_cd;

            $majorsubject_count = majorsubject_m_model::
            where('school_cd',$school_cd)
            ->withTrashed()
            ->count();       

            $info->majorsubject_count = $majorsubject_count;

        }
        

        
        
        return view('headquarters/screen/master/school/index', compact('search_element_array','school_list','school_division_list'));
    }


    //  更新処理
    function save(school_m_request $request)
    {

        $process_flg = intval($request->process_flg);

        $school_division = intval($request->school_division);      
        $school_cd = intval($request->school_cd);          
        $school_name = $request->school_name;
        $post_code = $request->post_code;
        $address1 = $request->address1;
        $address2 = $request->address2;
        $tel = $request->tel;
        $fax = $request->fax;
        $hp_url = $request->hp_url;
        $mailaddress = $request->mailaddress;
        $remarks = $request->remarks;       

        try {


            if($process_flg == 0){

         
                school_m_model::create(
                    [
                        'school_division' => $school_division,
                        'school_name' => $school_name,
                        'post_code' => $post_code,
                        'address1' => $address1,
                        'address2' => $address2,
                        'tel' => $tel,
                        'fax' => $fax,                        
                        'hp_url' => $hp_url,
                        'mailaddress' => $mailaddress,
                        'remarks' => $remarks,
                      
                    ]
                );

            }else{


                school_m_model::where('school_cd', $school_cd)                    
                ->update(
                    [
                        'school_division' => $school_division,
                        'school_name' => $school_name,
                        'post_code' => $post_code,
                        'address1' => $address1,
                        'address2' => $address2,
                        'tel' => $tel,
                        'fax' => $fax,                        
                        'hp_url' => $hp_url,
                        'mailaddress' => $mailaddress,
                        'remarks' => $remarks,                  
                    
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
    function delete_or_restore(Request $request)
    {
        $delete_flg = intval($request->delete_flg);
        $school_cd = intval($request->delete_school_cd);
        $school_name = $request->delete_school_name;           

        try {

            
            if($delete_flg == 0){

                //論理削除
                school_m_model::
                where('school_cd', $school_cd)                
                ->delete();

                session()->flash('success', '[学校名 = ' . $school_name. ']データを利用不可状態にしました');                
            }else{    

                //論理削除解除
                school_m_model::
                where('school_cd', $school_cd)                
                ->withTrashed()                
                ->restore();

                session()->flash('success', '[学校名 = ' . $school_name . ']データを利用可能状態にしました');                                
            }

        } catch (Exception $e) {

            $ErrorMessage = '【学校マスタ利用状況変更処理時エラー】' . $e->getMessage();            

            Log::channel('error_log')->info($ErrorMessage);

            session()->flash('error', '[学校名 = ' . $school_name . ']データの利用状況変更処理時エラー'); 
           
        }       

        return back();
    }

}
