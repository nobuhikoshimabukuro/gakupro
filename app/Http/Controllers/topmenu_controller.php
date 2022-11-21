<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Exception;

class topmenu_controller extends Controller
{
    function index()
    {        
        // Log::channel('normal_log')->info("normal_log");
        // Log::channel('error_log')->info("error_log");
        // Log::channel('emergency_log')->info("emergency_log");
        // Log::channel('database_backup_log')->info("database_backup_log");

        // $this->DataBase_BackUp();
        return view('headquarters/topmenu/index');
    }

    function master_index()
    {        
        return view('master/index');
    }     

    function DataBase_BackUp()
    {        

        $DB_DATABASE = env('DB_DATABASE');

        $ToDay = Carbon::now();

        //バックアップ用の新しいDB
        $NewDataBase = $DB_DATABASE . "_" . $ToDay->format('Ymd');

        $CreateDataBase_SQL = "
            CREATE DATABASE IF NOT EXISTS 
            " . $NewDataBase
        ;
            
        DB::connection('mysql')->update($CreateDataBase_SQL);

        //バックアップするDBの全テーブル情報を取得
        $SQL = "
            SELECT
            *
            FROM
            INFORMATION_SCHEMA.TABLES
            WHERE
            TABLE_SCHEMA = '" . $DB_DATABASE . "'"
        ;
                
        $AllTableInfo = DB::connection('mysql')->select($SQL);        

        //バックアップ対象外のテーブルを格納
        $NotApplicableTable = [
                'migrations'
               ,'personal_access_tokens'              
        ];

        foreach($AllTableInfo as $Info){

            try{

                $TABLE_NAME = $Info->TABLE_NAME;

                //バックアップ対象外のテーブル時は、次周
                if(in_array($TABLE_NAME, $NotApplicableTable)) {
                    continue;
                }

                //バックアップDBに既にテーブルがある時のテーブル削除
                $DropTable_SQL = "
                    DROP TABLE IF EXISTS " . $NewDataBase . "." . $TABLE_NAME
                ;
                
                DB::connection('mysql')->update($DropTable_SQL);

                //バックアップ元のDBからバックアップ先のDBに同じテーブル名で作成
                $CreateTable_SQL = "
                CREATE TABLE " . $NewDataBase . "." . $TABLE_NAME . 
                "AS SELECT * FROM " . $DB_DATABASE . "." . $TABLE_NAME
                ;
                
                Log::channel('database_backup_log')->info('DataBaseName【' . $NewDataBase . '】TableName【' . $TABLE_NAME . '】バックアップ成功');

                DB::connection('mysql')->update($CreateTable_SQL);

            } catch (Exception $e) {              

                $ErrorMessage = 'バックアップエラー!!TableName【'.$TABLE_NAME .'】'. $e->getMessage();
                
                Log::channel('database_backup_log')->info($ErrorMessage);               
            }
        
        }
       
    }
}
