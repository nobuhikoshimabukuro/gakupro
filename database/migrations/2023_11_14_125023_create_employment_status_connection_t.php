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
        if (Schema::hasTable('employment_status_connection_t')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('employment_status_connection_t', function (Blueprint $table) {

            $table
                ->integer('employer_id')
                ->comment('雇用者ID');

            $table
                ->integer('job_id')
                ->comment('求人情報ID:会社IDと求人情報IDで複合キー');

            $table
                ->integer('employment_status_id')                
                ->comment('雇用形態ID');

            $table
                ->integer('salary_subcategory_cd')
                ->nullable()
                ->comment('給与中分類コード');

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

            $table->primary(['employer_id','job_id','employment_status_id'], 'employment_status_connection_t');

        });

        // ALTER 文を実行しテーブルにコメントを設定
        DB::statement("ALTER TABLE employment_status_connection_t COMMENT '雇用形態連結テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employment_status_connection_t');
    }
};
