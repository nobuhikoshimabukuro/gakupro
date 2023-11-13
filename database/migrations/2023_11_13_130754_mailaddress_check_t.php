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
        if (Schema::hasTable('mailaddress_check_t')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('mailaddress_check_t', function (Blueprint $table) {

            $table
                ->increments('id')
                ->comment('連番');

            $table                
                ->string('key_code', 100)
                ->comment('キーコード');

            $table
                ->string('cipher', 1000)
                ->nullable()
                ->comment('暗号文');

            $table                
                ->string('password', 1000)
                ->comment('認証用パスワード');
                
            $table
                ->string('mailaddress', 100)
                ->comment('メールアドレス');

    
            $table
                ->integer('check_count')
                ->default(0)
                ->comment('認証回数(初期値=0)');

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
        DB::statement("ALTER TABLE mailaddress_check_t COMMENT 'メールアドレス認証用テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailaddress_check_t');
    }
};
