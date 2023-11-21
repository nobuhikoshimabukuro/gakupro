<?php

namespace App\Http\Controllers\headquarters\master;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

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
            'search_product_type' => $request->search_product_type
            ,'search_usage_flg' => $request->search_usage_flg
            ,'search_sold_flg' => $request->sold_flg
            ,'search_date_range' => $request->search_date_range
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

            'job_password_t.product_type as product_type',
            'job_password_t.password as password',

            'job_password_t.usage_flg as usage_flg',
            'job_password_t.sold_flg as sold_flg',
            DB::raw("
                CASE
                    WHEN job_password_t.usage_flg = '1' 
                        THEN '使用済み'
                    ELSE '未使用'
                END as usage_status,

                CASE
                    WHEN job_password_t.sold_flg = '1' 
                        THEN '販売済'
                    ELSE '販売前'
                END as sold_status
            "),

            
            'job_password_t.date_range as date_range',
            'job_password_t.created_at as created_at',

            'job_password_t.created_by as created_by',

            DB::raw("
                 CONCAT(staff_m.staff_last_name, '　', staff_m.staff_first_name) AS created_by_name
                ,CONCAT(staff_m.staff_last_name_yomi, '　', staff_m.staff_first_name_yomi) AS created_by_name_yom
            "),
         
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
        ->leftJoin('staff_m', function ($join) {
            $join->on('staff_m.staff_id', '=', 'job_password_t.created_by');
        })
        ->orderBy('job_password_t.job_password_id', 'asc');    

        
            

        if(!is_null($search_element_array['search_product_type'])){            
            $job_password_t_list = $job_password_t_list->where('job_password_t.product_type', '=', $search_element_array['search_product_type']);
        }

        if(!is_null($search_element_array['search_usage_flg'])){            
            $job_password_t_list = $job_password_t_list->where('job_password_t.usage_flg', '=', $search_element_array['search_usage_flg']);
        }

        if(!is_null($search_element_array['search_date_range'])){            
            $job_password_t_list = $job_password_t_list->where('job_password_t.date_range', '=', $search_element_array['search_date_range']);
        }

        $job_password_t_list = $job_password_t_list->paginate(env('Paginate_Count'));

        return view('headquarters/screen/master/job_password/index', compact('search_element_array','job_password_t_list'));
    }


    //  更新処理
    function save(Request $request)
    {

        $process_title = "求人公開用パスワード作成処理";

        $create_password_count = intval($request->create_password_count);
        $product_type = 1;
        $date_range = 14;
        
        
        $created_by = session()->get('staff_id');

        if(is_null($created_by)){

            $result_array = array(
                "Result" => "non_session",
                "Message" => $process_title."でエラーが発生しました。",
            );            

            return response()->json(['result_array' => $result_array]);
        }
        
        try {

            for ($i = 1; $i <= $create_password_count; $i++) {

                $password = $this->create_password();                
                
                job_password_t_model::create(
                    [   
                        'password' => $password,                 
                        'product_type' => $product_type,
                        'date_range' => $date_range,
                        'created_by' => $created_by,
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
   
   
}
