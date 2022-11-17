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
        if (Schema::hasTable('majorsubject_m')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('majorsubject_m', function (Blueprint $table) {

            $table
                ->increments('id')
                ->comment('連番');

            $table
                ->integer('school_cd')
                ->comment('学校コード');

            $table
                ->integer('majorsubject_cd')
                ->comment('専攻コード');

            $table
                ->string('majorsubject_name', 30)
                ->comment('専攻名');

            $table
                ->integer('studyperiod')
                ->nullable()
                ->comment('学習期間（月数単位）');

            $table
                ->text('Remarks')
                ->nullable()
                ->comment('備考');

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
        DB::statement("ALTER TABLE majorsubject_m COMMENT '学校別専攻マスタ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('majorsubject_m');
    }
};
