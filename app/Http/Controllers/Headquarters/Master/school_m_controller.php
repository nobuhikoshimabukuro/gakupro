<?php

namespace App\Http\Controllers\Headquarters\Master;
use App\Http\Controllers\Controller;
use App\Models\maincategory_m_model;
use App\Models\subcategory_m_model;
use App\Models\school_m_model;
use App\Models\majorsubject_m_model;

use Illuminate\Http\Request;

use Exception;

class school_m_controller extends Controller
{
    function index()
    {
        $school_division_list = subcategory_m_model::select(
            'subcategory_cd as school_division_cd',
            'subcategory_name as school_division_name',         
        )->where('maincategory_cd',3)
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
        ->withTrashed()       
        ->get();

        $majorsubject_m_list = majorsubject_m_model::select(

            'majorsubject_m.school_cd as school_cd',
            'majorsubject_m.majorsubject_cd as majorsubject_cd',
            'majorsubject_m.majorsubject_name as majorsubject_name',
            'majorsubject_m.studyperiod as studyperiod',
            'majorsubject_m.remarks as remarks',           
        )       
        ->orderBy('majorsubject_m.school_cd', 'asc')        
        ->orderBy('majorsubject_m.majorsubject_cd', 'asc') 
        ->withTrashed()
        ->get();        

        
        
        return view('headquarters/screen/master/school/index', compact('school_m_list','school_division_list','majorsubject_m_list'));
    }


    //  ????????????
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
            
            $ErrorMessage = '??????????????????????????????';

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

        session()->flash('success', '?????????????????????????????????');
        session()->flash('message-type', 'success');
        return response()->json(['ResultArray' => $ResultArray]);
    }

    //  ??????????????????
    function delete(Request $request)
    {
        $delete_subcategory_cd = intval($request->delete_subcategory_cd);
        $maincategory_name = $request->delete_maincategory_name;
        $subcategory_name = $request->delete_subcategory_name;
        try {
            $mcon = subcategory_m_model::destroy($delete_subcategory_cd);
            session()->flash('success', '[????????? = ' . $maincategory_name . ' ????????? = ' . $subcategory_name . ']?????????????????????????????????????????????');
        } catch (Exception $e) {

            $e->getMessage();            
            
            $ErrorMessage = '????????????????????????????????????????????????';

            session()->flash('error', '[????????? = ' . $maincategory_name . ' ????????? = ' . $subcategory_name . ']?????????????????????????????????????????????');            
        }


        return back();
    }

    //  ??????????????????????????????
    function restore(Request $request)
    {
        $delete_subcategory_cd = intval($request->delete_subcategory_cd);
        $maincategory_name = $request->delete_maincategory_name;
        $subcategory_name = $request->delete_subcategory_name;

        try {
            $mcon = subcategory_m_model::where('subcategory_cd', $delete_subcategory_cd)->withTrashed()->get()->first();
            $mcon->restore();
            session()->flash('success', '[????????? = ' . $maincategory_name . ' ????????? = ' . $subcategory_name . ']???????????????????????????????????????????????????');
        } catch (Exception $e) {

            $e->getMessage();            
            
            $ErrorMessage = '??????????????????????????????????????????????????????';
            
            session()->flash('error', '[????????? = ' . $maincategory_name . ' ????????? = ' . $subcategory_name . ']?????????????????????????????????????????????');            
        }

        return back();
    }
}
