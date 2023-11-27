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
        if (Schema::hasTable('job_password_item_m')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('job_password_item_m', function (Blueprint $table) {

            $table
                ->increments('job_password_item_id')
                ->comment('求人パスワード商品ID:連番');

            $table
                ->string('job_password_item_name', 100)
                ->comment('求人パスワード商品名');

            $table
                ->integer('price')                
                ->comment('求人パスワード料金');

            $table
                ->integer('Added_date')                
                ->comment('求人公開の追加日');

            $table
                ->date('sales_start_date')                
                ->comment('求人パスワード商品販売開始日');

            $table
                ->date('sales_end_date')                
                ->comment('求人パスワード商品販売終了日');

            $table
                ->text('remarks')
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
        DB::statement("ALTER TABLE job_password_item_m COMMENT '求人パスワード商品マスタ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_password_item_m');
    }
};
