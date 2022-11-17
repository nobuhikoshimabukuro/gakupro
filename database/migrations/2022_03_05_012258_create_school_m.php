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
        if (Schema::hasTable('school_m')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('school_m', function (Blueprint $table) {

            $table
                ->increments('school_cd')
                ->comment('学校コード:連番');

            $table
                ->integer('school_division')
                ->comment('学校区分:大分類マスタ参照');

            $table
                ->string('school_name', 50)
                ->comment('学校名');

            $table
                ->string('tel', 15)
                ->nullable()
                ->comment('学校電話番号');

            $table
                ->string('hp_url', 50)
                ->nullable()
                ->comment('学校HPのURL');

            $table
                ->string('mailaddress', 100)
                ->nullable()
                ->comment('学校メールアドレス');

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
        DB::statement("ALTER TABLE school_m COMMENT '学校マスタ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_m');
    }
};
