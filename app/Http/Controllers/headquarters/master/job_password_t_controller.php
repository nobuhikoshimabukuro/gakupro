<?php

namespace App\Http\Controllers\headquarters\master;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Original\common;
use App\Original\create_list;

use App\Models\staff_m_model;
use App\Models\staff_password_t_model;
use App\Models\subcategory_m_model;
use App\Models\job_password_t_model;
use App\Models\staff_with_project_t_model;

use App\Http\Requests\staff_m_request;



class job_password_t_controller extends Controller
{
    function index(Request $request)
    {

            


        //Session確認処理        
        if(!common::headquarters_session_confirmation()){
            //Session確認で戻り値が(true)時は管理のTop画面に遷移
            return redirect(route('headquarters.login'));            
        }

        //検索項目格納用配列
        $search_element_array = [
            'search_job_password_item_id' => $request->search_job_password_item_id
            ,'search_usage_flg' => $request->search_usage_flg
            ,'search_sale_flg' => $request->sale_flg            
            ,'search_sale_date' => $request->search_sale_date
            ,'search_seller' => $request->search_seller
        ];

          
        $job_password_t_list = job_password_t_model::select(

            'job_password_t.job_password_id as job_password_id',

            'job_password_connection_t.employer_id as employer_id',
            'employer_m.employer_name as employer_name',

            'job_password_connection_t.job_id as job_id',
            'job_information_t.id as job_information_id',
            'job_information_t.title as title',

            'job_password_connection_t.publish_start_date as publish_start_date',
            'job_password_connection_t.publish_end_date as publish_end_date',

            'job_password_t.job_password_item_id as job_password_item_id',
            'job_password_t.password as password',

            'job_password_t.usage_flg as usage_flg',
            'job_password_t.sale_flg as sale_flg',
           
            
            
            'job_password_t.created_at as created_at',

            'job_password_t.created_by as created_by',
            'created_by_info.staff_last_name as created_staff_last_name',
            'created_by_info.staff_first_name as created_staff_first_name',
            'created_by_info.staff_last_name_yomi as created_staff_last_name_yomi',
            'created_by_info.staff_first_name_yomi as created_staff_first_name_yomi',

            'job_password_t.sale_datetime as sale_datetime',
            'job_password_t.seller as seller',
            'seller_by_info.staff_last_name as seller_staff_last_name',
            'seller_by_info.staff_first_name as seller_staff_first_name',
            'seller_by_info.staff_last_name_yomi as seller_staff_last_name_yomi',
            'seller_by_info.staff_first_name_yomi as seller_staff_first_name_yomi',

         
         
        )        
        ->leftJoin('job_password_connection_t', function ($join) {
            $join->on('job_password_connection_t.job_password_id', '=', 'job_password_t.job_password_id');
        })
        ->leftJoin('employer_m', function ($join) {
            $join->on('employer_m.employer_id', '=', 'job_password_connection_t.employer_id');
        })
        ->leftJoin('job_information_t', function ($join) {
            $join->on('job_information_t.employer_id', '=', 'job_password_connection_t.employer_id')
            ->on('job_information_t.job_id', '=', 'job_password_connection_t.job_id');
        })
        ->leftJoin('staff_m as created_by_info', function ($join) {
            $join->on('created_by_info.staff_id', '=', 'job_password_t.created_by');
        })
        ->leftJoin('staff_m as seller_by_info', function ($join) {
            $join->on('seller_by_info.staff_id', '=', 'job_password_t.seller');
        })
        ->orderBy('job_password_t.job_password_id', 'asc');    

        
            

        if(!is_null($search_element_array['search_job_password_item_id'])){            
            $job_password_t_list = $job_password_t_list->where('job_password_t.job_password_item_id', '=', $search_element_array['search_job_password_item_id']);
        }

        if(!is_null($search_element_array['search_usage_flg'])){            
            $job_password_t_list = $job_password_t_list->where('job_password_t.usage_flg', '=', $search_element_array['search_usage_flg']);
        }

       

        $job_password_t_list = $job_password_t_list->paginate(env('paginate_count'));

        return view('headquarters/screen/master/job_password/index', compact('search_element_array','job_password_t_list'));
    }


    //  更新処理
    function save(Request $request)
    {

        $process_title = "求人公開用パスワード作成処理";

        $create_password_count = intval($request->create_password_count);
        $job_password_item_id = 1;
        
        
        
        $operator = session()->get('staff_id');

        if(is_null($operator)){

            $result_array = array(
                "Result" => "non_session",
                "Message" => $process_title."でエラーが発生しました。",
            );            

            session()->flash('staff_loginerror', '再度ログインお願い致します。');
            return response()->json(['result_array' => $result_array]);
        }
        
        try {

            for ($i = 1; $i <= $create_password_count; $i++) {

                $password = $this->create_password();                
                
                job_password_t_model::create(
                    [   
                        'password' => $password,                 
                        'job_password_item_id' => $job_password_item_id,                        
                        'created_by' => $operator,
                    ]
                );

            }             
    
        } catch (Exception $e) {

                        
            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            
            $result_array = array(
                "Result" => "error",
                "Message" => $process_title."でエラーが発生しました。",
            );
            

            return response()->json(['result_array' => $result_array]);
                                
        }

        $result_array = array(
            "Result" => "success",
            "Message" => '',
        );

        session()->flash('success', 'データを登録しました。');
        session()->flash('message-type', 'success');
        return response()->json(['result_array' => $result_array]);
    }

    function create_password()
    {        
        $create_password = "";

        $password_length = 10;

        while(true){         
            
            $create_password =  common::create_random_letters($password_length);
            
            $check_password = job_password_t_model::withTrashed()
            ->where('password', '=', $create_password)                        
            ->exists();

            if(!$check_password){
                //繰返しの強制終了
                break; 
            }            
        }
       
        return $create_password;
    }


    //  求人公開用パスワード販売時更新処理
    function sale_flg_change(Request $request)
    {

        $process_title = "求人公開用パスワード販売時更新処理";

        $job_password_id = intval($request->password_sale_change_job_password_id);
        $password_sale_flg = intval($request->password_sale_flg);
        
        $operator = session()->get('staff_id');

        
        // MySQLのdatetime形式に変換
        $sale_datetime = common::get_date(2);
        

        if(is_null($operator)){

            $result_array = array(
                "Result" => "non_session",
                "Message" => $process_title."でエラーが発生しました。",
            );            

            session()->flash('staff_loginerror', '再度ログインお願い致します。');
            return response()->json(['result_array' => $result_array]);            
        }
        
        try {

            if($password_sale_flg == 0){

                job_password_t_model::
                where('job_password_id', $job_password_id)                
                ->update(
                    [
                        'sale_flg' => 1,
                        'seller' => $operator,
                        'sale_datetime' => $sale_datetime,
                        'updated_by' => $operator,            
                    ]
                );         

            }else{

                job_password_t_model::
                where('job_password_id', $job_password_id)                
                ->update(
                    [
                        'sale_flg' => 0,
                        'seller' => null,
                        'sale_datetime' => null,
                        'updated_by' => $operator,            
                    ]
                );         


            }
            
           
            
    
        } catch (Exception $e) {

                        
            $error_message = $e->getMessage();
            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            
            $result_array = array(
                "Result" => "error",
                "Message" => $process_title."でエラーが発生しました。",
            );
            

            return response()->json(['result_array' => $result_array]);
                                
        }

        $result_array = array(
            "Result" => "success",
            "Message" => '',
        );

        session()->flash('success', '販売フラグを更新しました。');
        session()->flash('message-type', 'success');
        return response()->json(['result_array' => $result_array]);
    }


   
   
}
