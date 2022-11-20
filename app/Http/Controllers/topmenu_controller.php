<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class topmenu_controller extends Controller
{
    function index()
    {        
        return view('headquarters/topmenu/index');
    }

    function master_index()
    {        
        return view('master/index');
    }     

    function test()
    {        

        $DB_DATABASE = $APP_DEBUG = env('DB_DATABASE');

        $ToDay = Carbon::now();
        $LastYear = Carbon::now()->subYear(1);        

        $CheckDate1 = Carbon::now()->subDay(1);
        // $CheckDate1 = Carbon::now()->addDay(1);

        $SQL = "
            SELECT
            *
            FROM
            INFORMATION_SCHEMA.TABLES
            WHERE
            TABLE_SCHEMA = '" . $DB_DATABASE . "'"
        ;
        
        //請求マスタ情報を取得
        $AllTable = DB::connection('mysql')->select($SQL);  

        $AllTableNameArray = array();
        $BackUpTableNameArray = array();
        $DropTableNameArray = array();

        foreach($AllTable as $Info){

            $TABLE_NAME = $Info->TABLE_NAME;

            if ($TABLE_NAME == "migrations" || $TABLE_NAME == "personal_access_tokens"){
                continue;
            }

            $AllTableNameArray[] = $TABLE_NAME;

            if(strpos($TABLE_NAME,$ToDay->format('Y')) || strpos($TABLE_NAME,$LastYear->format('Y'))){
                $DropTableNameArray[] = $TABLE_NAME;
            }else{
                $BackUpTableNameArray[] = $TABLE_NAME;
            }
            
        
        }

        


        foreach($DropTableNameArray as $TableName){

            $Length = mb_strrpos($TableName, "_");

            if(is_numeric($Length)){

                $CheckDate2 = substr($TableName, $Length + 1);

                if(is_numeric($CheckDate2)){

                    if(intval($CheckDate1->format('Ymd')) > intval($CheckDate2)){

                        $Backup_SQL = "
                        DROP TABLE " . $TableName
                        ;
                            
                        DB::connection('mysql')->update($Backup_SQL); 
                    }
                }               
            }
        }
                       

        foreach($BackUpTableNameArray as $TableName){
            
            $Backup_TABLE_NAME = $TableName . "_" . $ToDay->format('Ymd');

            if(!in_array($Backup_TABLE_NAME, $AllTableNameArray)) {
                
                $Backup_SQL = "
                CREATE TABLE " . $Backup_TABLE_NAME . "            
                SELECT
                *
                FROM " . $DB_DATABASE . "." . $TableName
                ;
                    
                DB::connection('mysql')->update($Backup_SQL);
            }
        }
    }
}
