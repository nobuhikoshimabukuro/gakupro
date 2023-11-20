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
                ->comment('掲載フラグ:0 = 掲載しない、1 = 掲載する');

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
                ->comment('給与');

            $table                
                ->text('holiday')
                ->nullable()
                ->comment('休日');

            $table
                ->string('manager_name', 200)
                ->nullable()
                ->comment('求人担当者名');

            $table
                ->string('tel', 20)
                ->nullable()
                ->comment('求人連絡TEL');

            $table
                ->string('fax', 20)
                ->nullable()
                ->comment('求人連絡FAX');

            $table
                ->string('hp_url', 200)
                ->nullable()
                ->comment('HP_URL');

            $table
                ->string('job_image_folder_name', 200)
                ->nullable()
                ->comment('求人掲載用画像格納フォルダ名');

            $table
                ->string('mailaddress', 200)
                ->nullable()
                ->comment('メールアドレス');           

            $table
                ->text('application_requirements')
                ->nullable()
                ->comment('応募資格');
                           

        
            

            $table
                ->text('scout_statement')
                ->nullable()
                ->comment('求人スカウト文');

            $table
                ->text('remarks')
                ->nullable()
                ->comment('備考');

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
