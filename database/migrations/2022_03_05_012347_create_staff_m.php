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
        if (Schema::hasTable('staff_m')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('staff_m', function (Blueprint $table) {

            $table
                ->increments('staff_id')
                ->comment('スタッフID:連番');

            $table
                ->string('staff_name', 50)
                ->comment('スタッフ氏名');

            $table
                ->string('staff_name_yomi', 50)
                ->nullable()
                ->comment('氏名（フリガナ）:全角カタカナ');

            $table
                ->string('nickname', 50)
                ->nullable()
                ->comment('スタッフニックネーム');
            
            $table
                ->integer('gender')
                ->nullable()
                ->comment('性別:中分類マスタを参照');

            $table
                ->string('tel', 15)
                ->nullable()
                ->comment('連絡用電話番号');

            $table
                ->string('mailaddress', 100)
                ->nullable()
                ->comment('連絡用メールアドレス');

            $table
                ->integer('authority')
                ->default(0)
                ->comment('権限:中分類マスタを参照');

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
        DB::statement("ALTER TABLE staff_m COMMENT 'スタッフマスタ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_m');
    }
};
