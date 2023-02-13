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
        if (Schema::hasTable('staff_with_project_t')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('staff_with_project_t', function (Blueprint $table) {

            $table
                ->integer('staff_id')
                ->comment('スタッフID');

            $table
                ->integer('project_id')
                ->comment('プロジェクトID');

           
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

            $table->primary(['staff_id','project_id'], 'staff_with_project_t');
        });

        // ALTER 文を実行しテーブルにコメントを設定
        DB::statement("ALTER TABLE staff_with_project_t COMMENT 'スタッフ毎プロジェクト管理テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_with_project_t');
    }
};
