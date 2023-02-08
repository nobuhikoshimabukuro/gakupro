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
                ->comment('学校区分:分類マスタ参照');

            $table
                ->string('school_name', 100)
                ->comment('学校名');
                
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
                ->comment('FAX');

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
