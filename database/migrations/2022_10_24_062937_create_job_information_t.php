<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('job_information_t')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('job_information_t', function (Blueprint $table) {

            $table
                ->increments('id')
                ->comment('連番');

            $table
                ->integer('employer_id')
                ->comment('雇用者ID');

            $table
                ->integer('job_id')
                ->comment('求人情報ID:会社IDと求人情報IDで複合キー');

            $table
                ->integer('publish_flg')
                ->default(1)
                ->comment('公開フラグ:0 = 公開しない、1 = 公開する');

            $table
                ->string('title', 200)    
                ->nullable()            
                ->comment('求人情報タイトル');

            $table
                ->string('sub_title', 200)    
                ->nullable()            
                ->comment('求人情報名目サブタイトル');

            $table
                ->string('work_location_prefectural_cd', 2)                
                ->nullable()
                ->comment('勤務地_都道府県CD');

            $table
                ->string('work_location_municipality_cd', 10)                
                ->nullable()
                ->comment('勤務地_市区町村CD');

            

            $table                
                ->text('working_time')
                ->nullable()
                ->comment('就労時間');

            $table                
                ->text('salary')
                ->nullable()
                ->comment('給与情報:[employment_status_connection_t]にて雇用形態別給与設定可能');

            $table                
                ->text('holiday')
                ->nullable()
                ->comment('休日情報');

            

            $table
                ->string('hp_url', 200)
                ->nullable()
                ->comment('HP_URL');

            $table
                ->string('job_image_folder_name', 200)
                ->nullable()
                ->comment('求人公開用画像格納フォルダ名');

            
                
            $table
                ->text('Job_duties')
                ->nullable()
                ->comment('仕事内容');

            $table
                ->text('application_requirements')
                ->nullable()
                ->comment('応募資格');

            $table
                ->text('application_process')
                ->nullable()
                ->comment('応募方法');

            $table
                ->string('mailaddress', 200)
                ->nullable()
                ->comment('応募用メールアドレス');        

            $table
                ->string('tel', 20)
                ->nullable()
                ->comment('応募用TEL');

            $table
                ->string('fax', 20)
                ->nullable()
                ->comment('応募用FAX');

            $table
                ->text('scout_statement')
                ->nullable()
                ->comment('求人スカウト文');

            $table
                ->text('remarks')
                ->nullable()
                ->comment('備考');


            $table
                ->text('free_word')
                ->nullable()
                ->comment('求人検索用のフリーワード');

            $table
                ->integer('created_by')
                ->nullable()
                ->comment('作成者');

            $table
                ->dateTime('updated_at')
                ->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))
                ->comment('更新日時:自動生成');

            $table
                ->integer('updated_by')
                ->nullable()
                ->comment('更新者');

            $table
                ->dateTime('deleted_at')
                ->nullable()
                ->comment('削除日時');

            $table
                ->integer('deleted_by')
                ->nullable()
                ->comment('削除者');
        });

        // ALTER 文を実行しテーブルにコメントを設定
        DB::statement("ALTER TABLE job_information_t COMMENT '求人情報テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_information_t');
    }
};
