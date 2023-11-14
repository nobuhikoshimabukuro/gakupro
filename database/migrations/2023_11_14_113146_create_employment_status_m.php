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
        if (Schema::hasTable('employment_status_m')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('employment_status_m', function (Blueprint $table) {

            $table
                ->increments('employment_status_id')
                ->comment('雇用形態ID:連番');

            $table                
                ->string('employment_status_name', 1000)
                ->comment('雇用形態名');

            $table
                ->integer('display_order')
                ->default(1)
                ->comment('並び順');

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
        DB::statement("ALTER TABLE employment_status_m COMMENT '雇用形態マスタ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employment_status_m');
    }
};
