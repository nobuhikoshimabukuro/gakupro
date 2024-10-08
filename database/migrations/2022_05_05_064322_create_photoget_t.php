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
        if (Schema::hasTable('photoget_t')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('photoget_t', function (Blueprint $table) {

            $table
                ->increments('id')
                ->comment('連番');

            $table
                ->string('date', 8)
                ->nullable()
                ->comment('開催日:yyyymmdd');
            
            $table
                ->string('code', 4)
                ->nullable()
                ->comment('写真取得用コード');

            $table                
                ->string('password', 1000)
                ->nullable()
                ->comment('認証用パスワード');

            $table
                ->integer('with_password_flg')
                ->nullable()
                ->comment('パスワード必要フラグ:写真取得時パスワード必要か判断する');

            $table
                ->string('saved_folder', 100)
                ->nullable()
                ->comment('写真保存フォルダ名:code + ランダム文字列');

            $table
                ->string('qr_code_name', 100)
                ->nullable()
                ->comment('QRコードのファイル名');

         
            $table
                ->string('url', 100)
                ->nullable()
                ->comment('作成されたurl');

            $table
                ->string('cipher', 1000)
                ->nullable()
                ->comment('暗号文');

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
        DB::statement("ALTER TABLE photoget_t COMMENT '写真取得用テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photoget_t');
    }
};
