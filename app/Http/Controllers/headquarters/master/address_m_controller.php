<?php

namespace App\Http\Controllers\headquarters\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;


use App\Models\address_m_model;

class address_m_controller extends Controller
{
    function index(Request $request)
    {

        //検索項目格納用配列
        $search_element_array = [
            'search_prefectural_cd' => $request->search_prefectural_cd,
            'search_prefectural_name' => $request->search_prefectural_name,
            'search_municipality_cd' => $request->search_municipality_cd,
            'search_municipality_name' => $request->search_municipality_name,
        ];

        $address_m_list = address_m_model::orderBy('address_m.prefectural_cd', 'asc')
        ->orderBy('address_m.municipality_cd', 'asc')
        ->withTrashed();

        if(!is_null($search_element_array['search_prefectural_cd'])){
            $address_m_list = $address_m_list->where('address_m.prefectural_cd', '=', $search_element_array['search_prefectural_cd']);
        }

        if(!is_null($search_element_array['search_prefectural_name'])){
     
            $search_prefectural_name = $search_element_array["search_prefectural_name"];

            $address_m_list = $address_m_list->where(function ($query) use ($search_prefectural_name) {
                $query->where('prefectural_name', 'LIKE', "%$search_prefectural_name%")
                    ->orWhere('prefectural_name_kana', 'LIKE', "%$search_prefectural_name%");
            });

        }

        if(!is_null($search_element_array['search_municipality_cd'])){
            $address_m_list = $address_m_list->where('address_m.municipality_cd', '=', $search_element_array['search_municipality_cd']);
        }

        if(!is_null($search_element_array['search_municipality_name'])){
     
            $search_municipality_name = $search_element_array["search_municipality_name"];

            $address_m_list = $address_m_list->where(function ($query) use ($search_municipality_name) {
                $query->where('municipality_name', 'LIKE', "%$search_municipality_name%")
                    ->orWhere('municipality_name_kana', 'LIKE', "%$search_municipality_name%");
            });

        }


        $address_m_list = $address_m_list->paginate(30);

        return view('headquarters/screen/master/address/index', compact('search_element_array','address_m_list'));
        
    }

    //  更新処理
    function save(Request $request)
    {

        $process_title = "【住所マスタ更新処理】";
       
        
        try {

            // ファイルを取得
            $file = $request->file('csv_file');

            // ファイルの拡張子を取得しファイル名を生成
            $file_name = "address." . $file->getClientOriginalExtension();

            $csv_path = "public/csv/address/";
            $csv_full_path = $csv_path . $file_name;
            
            
            //過去のCSVを削除
            Storage::deleteDirectory($csv_path);

            // 新しいCSV保存フォルダを作成
            Storage::makeDirectory($csv_path);            
            // CSVファイルを保存
            $file->storeAs($csv_path , $file_name);

            if (Storage::exists($csv_full_path)){

                //今回取得したCSVを保存パス
                $csv_full_path = Storage_path('app/' . $csv_full_path);
                // CSVファイルを読み込み
                $csv = Reader::createFromPath($csv_full_path, 'r');

                try {

                    DB::connection('mysql')->beginTransaction();

                    //Table初期化
                    address_m_model::truncate();

                    foreach ($csv as $row) {

                        $municipality_cd = $row[0];
                        $municipality_name = $row[1];
                        $municipality_name_kana = $row[2];
                        $prefectural_cd = $row[3];
                        $prefectural_name = $row[4];
                        $prefectural_name_kana = $row[5];
                        
                        address_m_model::insert(
                            [
                                'prefectural_cd' => $prefectural_cd,                        
                                'prefectural_name' => $prefectural_name,     
                                'prefectural_name_kana' => $prefectural_name_kana,
                                'municipality_cd' => $municipality_cd,
                                'municipality_name' => $municipality_name,
                                'municipality_name_kana' => $municipality_name_kana,
                                
                            ]
                        );        

                    }

                    DB::connection('mysql')->commit();


                } catch (Exception $e) {  

                    DB::connection('mysql')->rollBack();

                    $error_message = "住所データ登録処理時エラー";

                    Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");
    
                    $result_array = array(
                    "Result" => "error",
                    "Message" => $error_message,
                    );
                }

            }else{


                $error_message = "住所CSV保存処理時エラー";

                Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");
    
                $result_array = array(
                    "Result" => "error",
                    "Message" => $error_message,
                );
    
                return response()->json(['result_array' => $result_array]);

            }

    
        } catch (Exception $e) {            
            
            $error_message = $e->getMessage();            

            Log::channel('error_log')->info($process_title . "error_message【" . $error_message ."】");

            $result_array = array(
                "Result" => "error",
                "Message" => $error_message,
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
}
