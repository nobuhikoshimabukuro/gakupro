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
        if (Schema::hasTable('job_information_t')) {
            // テーブルが存在していればリターン
            return;
        }

        Schema::create('job_information_t', function (Blueprint $table) {

            $table
                ->increments('id')
                ->comment('連番');

            $table
                ->integer('employer_id')
                ->comment('雇用者ID');

            $table
                ->integer('job_id')
                ->comment('求人情報ID:会社IDと求人情報IDで複合キー');

            $table
                ->string('title', 200)
                ->nullable()
                ->comment('求人情報名目');

            $table
                ->string('work_location', 200)
                ->nullable()
                ->comment('勤務地');

            $table
                ->string('employment_status', 200)
                ->nullable()
                ->comment('雇用形態');

            $table
                ->string('working_time', 200)
                ->nullable()
                ->comment('就労時間');

            $table
                ->string('salary', 200)
                ->nullable()
                ->comment('給与');

            $table
                ->string('holiday', 200)
                ->nullable()
                ->comment('休日');

            $table
                ->string('manager_name', 200)
                ->nullable()
                ->comment('求人担当者名');

            $table
                ->string('tel', 20)
                ->nullable()
                ->comment('求人連絡TEL');

            $table
                ->string('fax', 20)
                ->nullable()
                ->comment('求人連絡FAX');

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
        DB::statement("ALTER TABLE job_information_t COMMENT '求人情報テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_information_t');
    }
};
