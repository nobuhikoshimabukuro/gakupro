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
        if (Schema::hasTable('member_m')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('member_m', function (Blueprint $table) {

            $table
                ->increments('member_id')
                ->comment('学生メンバーID:連番');

            $table
                ->string('member_name', 100)
                ->comment('氏名');

            $table
                ->string('member_name_yomi', 100)
                ->nullable()
                ->comment('氏名（フリガナ）:全角カタカナ');

            $table
                ->integer('gender')
                ->nullable()
                ->comment('性別:中分類マスタを参照');
                
            $table
                ->date('birthday')
                ->nullable()
                ->comment('誕生日');

            $table
                ->string('tel', 15)
                ->nullable()
                ->comment('電話番号');

            $table
                ->string('mailaddress', 100)
                ->nullable()
                ->comment('メールアドレス');

            $table
                ->integer('school_cd')
                ->nullable()
                ->comment('学校コード');

            $table
                ->integer('majorsubject_cd')
                ->nullable()
                ->comment('専攻コード');

            $table
                ->string('admission_yearmonth', 7)
                ->nullable()
                ->comment('入学年月:形式(yyyy/mm)');

            $table
                ->string('graduation_yearmonth', 7)
                ->nullable()
                ->comment('予定卒業年月:形式(yyyy/mm)');           

            $table
                ->string('emergencycontact_relations', 30)
                ->nullable()
                ->comment('緊急連絡先相手との続柄');

            $table
                ->string('emergencycontact_tel', 30)
                ->nullable()
                ->comment('緊急連絡先番号');

            $table
                ->text('remarks')
                ->nullable()
                ->comment('備考');

            $table
                ->integer('registration_status')
                ->default(0)
                ->comment('登録状況:1=本登録 2=卒業');

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
        DB::statement("ALTER TABLE member_m COMMENT 'メンバーマスタ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_m');
    }
};
