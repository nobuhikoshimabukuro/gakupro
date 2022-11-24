<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;

use Exception;
use Illuminate\Support\Facades\Log;

use App\Original\Common;

use App\Models\maincategory_m_model;
use App\Http\Requests\maincategory_m_request;

use Illuminate\Http\Request;





class maincategory_m_controller extends Controller
{
    
    function index()
    {
      

        $maincategory_m_list = maincategory_m_model::withTrashed()
            ->orderBy('maincategory_cd', 'asc')
            ->get();

        return view('headquarters/screen/master/maincategory/index', compact('maincategory_m_list'));
    }


    //  更新処理
    function save(maincategory_m_request $request)
    {

        $maincategory_cd = intval($request->maincategory_cd);
        $maincategory_name = $request->maincategory_name;

        try {
            maincategory_m_model::updateOrInsert(
                ['maincategory_cd' => $maincategory_cd],
    
                ['maincategory_name' => $maincategory_name]                
                
            );
    
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

    //  論理削除処理
    function delete(Request $request)
    {
        $delete_maincategory_cd = intval($request->delete_maincategory_cd);
        $delete_maincategory_name = $request->delete_maincategory_name;

        try {
            $mcon = maincategory_m_model::destroy($delete_maincategory_cd);
            session()->flash('success', '[大分類CD = ' . $delete_maincategory_cd . ' 大分類名 = ' . $delete_maincategory_name . ']データを利用不可状態にしました');
        } catch (Exception $e) {

            $ErrorTitle = '大分類マスタ利用不可処理時エラー';
            $ErrorMessage = $e->getMessage();
          
            Common::SendErrorMail($ErrorTitle,$ErrorMessage);

            $LogErrorMessage = $ErrorTitle .'::' .$ErrorMessage;
            Log::channel('error_log')->info($LogErrorMessage);
      
            session()->flash('error', '[大分類CD = ' . $delete_maincategory_cd . ' 大分類名 = ' . $delete_maincategory_name . ']データの利用不可処理時にエラー');            
        }


        return back();
    }

    //  論理削除取り消し処理
    function restore(Request $request)
    {
        $delete_maincategory_cd = intval($request->delete_maincategory_cd);
        $delete_maincategory_name = $request->delete_maincategory_name;

        try {
            $mcon = maincategory_m_model::where('maincategory_cd', $delete_maincategory_cd)->withTrashed()->get()->first();
            $mcon->restore();
            session()->flash('success', '[大分類CD = ' . $delete_maincategory_cd . ' 大分類名 = ' . $delete_maincategory_name . ']データの利用不可状態を解除しました');
        } catch (Exception $e) {

                        
            $ErrorTitle = '大分類マスタ利用不可解除処理時エラー';
            $ErrorMessage = $e->getMessage();
          
            Common::SendErrorMail($ErrorTitle,$ErrorMessage);

            $LogErrorMessage = $ErrorTitle .'::' .$ErrorMessage;
            Log::channel('error_log')->info($LogErrorMessage);

            session()->flash('error', '[大分類CD = ' . $delete_maincategory_cd . ' 大分類名 = ' . $delete_maincategory_name . ']データの利用不可解除時にエラー');            
        }

        return back();
    }

}
