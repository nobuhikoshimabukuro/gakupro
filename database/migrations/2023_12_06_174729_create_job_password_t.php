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
        if (Schema::hasTable('job_password_t')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('job_password_t', function (Blueprint $table) {

            $table
                ->increments('job_password_id')
                ->comment('連番'); 

            $table
                ->integer('job_password_item_id')
                ->default(0)
                ->comment('パスワード商品の種類'); 

            $table                
                ->string('password', 1000)
                ->comment('求人公開用パスワード');
    
            $table
                ->integer('usage_flg')
                ->default(0)
                ->comment('パスワード利用有無:0 = 未使用、1 = 使用済み');

            $table
                ->integer('sale_flg')
                ->default(0)
                ->comment('販売フラグ:0 = 販売前、1 = 販売済');

            $table
                ->integer('seller')
                ->nullable()
                ->comment('販売者:スタッフID');

            $table
                ->dateTime('sale_datetime')
                ->nullable()
                ->comment('販売日時');

            $table
                ->dateTime('created_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'))
                ->comment('作成日時:自動生成');

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
        DB::statement("ALTER TABLE job_password_t COMMENT '求人パスワード管理テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_password_t');
    }
};
