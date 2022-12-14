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
        if (Schema::hasTable('employer_m')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('employer_m', function (Blueprint $table) {

            $table
                ->increments('employer_id')
                ->comment('雇用者ID:連番');

            $table
                ->integer('employer_division')
                ->comment('雇用者区分:分類マスタ参照');

            $table
                ->string('employer_name', 300)
                ->comment('雇用者名:法人名、個人事業主名、個人名など');

            $table
                ->string('employer_name_kana', 300)
                ->nullable()
                ->comment('雇用者名カナ');
                
            $table
                ->string('post_code', 10)
                ->nullable()
                ->comment('郵便番号');

            $table
                ->string('address1', 300)
                ->nullable()
                ->comment('住所1');

            $table
                ->string('address2', 300)
                ->nullable()
                ->comment('住所2');
                
            $table
                ->string('tel', 20)
                ->nullable()
                ->comment('電話番号');

            $table
                ->string('fax', 20)
                ->nullable()
                ->comment('電話番号');

            $table
                ->string('hp_url', 200)
                ->nullable()
                ->comment('HP_URL');

            $table
                ->string('mailaddress', 200)
                ->nullable()
                ->comment('メールアドレス');

                
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
        DB::statement("ALTER TABLE employer_m COMMENT '雇用者マスタ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employer_m');
    }
};