<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('maincategory_m')->insert([
            
            [
                'maincategory_cd' => 1,
                'maincategory_name' => '性別',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [
                'maincategory_cd' => 2,
                'maincategory_name' => '権限',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [
                'maincategory_cd' => 3,
                'maincategory_name' => '学校区分',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [
                'maincategory_cd' => 4,
                'maincategory_name' => '雇用者区分',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],


        ]);     

        DB::table('subcategory_m')->insert([

            //性別
            [
                'maincategory_cd' => 1,
                'subcategory_cd' => 1,
                'subcategory_name' => '未選択',
                'display_order' => 1,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],
            [
                'maincategory_cd' => 1,
                'subcategory_cd' => 2,
                'subcategory_name' => '男性',
                'display_order' => 2,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],
            [
                'maincategory_cd' => 1,
                'subcategory_cd' => 3,
                'subcategory_name' => '女性',
                'display_order' => 3,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            //権限
            [
                'maincategory_cd' => 2,
                'subcategory_cd' => 1,
                'subcategory_name' => '一般',
                'display_order' => 1,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],
            [
                'maincategory_cd' => 2,
                'subcategory_cd' => 2,
                'subcategory_name' => '管理者',
                'display_order' => 2,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],
            [
                'maincategory_cd' => 2,
                'subcategory_cd' => 3,
                'subcategory_name' => 'システム管理者',
                'display_order' => 3,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],


            //学校区分
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 1,
                'subcategory_name' => '高校',
                'display_order' => 1,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 2,
                'subcategory_name' => '高専',
                'display_order' => 2,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 3,
                'subcategory_name' => '専門学校',
                'display_order' => 3,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 4,
                'subcategory_name' => '職業訓練校',
                'display_order' => 3,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 5,
                'subcategory_name' => '短期大学',
                'display_order' => 4,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 6,
                'subcategory_name' => '大学',
                'display_order' => 5,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            //雇用者区分
            [
                'maincategory_cd' => 4,
                'subcategory_cd' => 1,
                'subcategory_name' => '株式会社',
                'display_order' => 1,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],
            [
                'maincategory_cd' => 4,
                'subcategory_cd' => 2,
                'subcategory_name' => '有限会社',
                'display_order' => 2,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],
            [
                'maincategory_cd' => 4,
                'subcategory_cd' => 3,
                'subcategory_name' => '個人事業主',
                'display_order' => 3,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [
                'maincategory_cd' => 4,
                'subcategory_cd' => 4,
                'subcategory_name' => 'その他',
                'display_order' => 4,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

        ]);     


        DB::table('staff_m')->insert([
            
            [                
                'staff_name' => '島袋　信彦',
                'staff_name_yomi' => 'シマブクロ　ノブヒコ',
                'nick_name' => 'のぶっち',
                'gender' => '1',
                'tel' => '090-1234-5678',
                'mailaddress' => '',
                'authority' => '3',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [
             
                'staff_name' => '崎原　悠磨',
                'staff_name_yomi' => 'サキハラ　ユウマ',
                'nick_name' => 'ゆううゆうう',
                'gender' => '1',
                'tel' => '090-1234-5678',
                'mailaddress' => '',
                'authority' => '3',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],          

        ]);     

        DB::table('staff_password_t')->insert([
            
            [                
                'staff_id' => '1',
                'login_id' => '1',
                'password' => '1',               
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [                
                'staff_id' => '2',
                'login_id' => '2',
                'password' => '2',               
                'created_by' => '9999',
                'updated_by' => '9999',
            ],   

        ]);     


        DB::table('employer_m')->insert([
            
            [   
                'employer_id' => '1',             
                'employer_division' => '3',
                'employer_name' => '遊遊craft',
                'employer_name_kana' => 'ユウユウクラフト',
                'post_code' => '9040000',
                'address1' => '沖縄県西原町1111',
                'address2' => 'ユウユウビル　102',
                'tel' => '098-000-0000',
                'fax' => '098-111-1111',
                'hp_url' => 'https://www.yahoo.co.jp/',
                'mailaddress' => 'test@gmail.com',
                'remarks' => '業種：生産業（家具作り）やWebシステム構築',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],          

        ]);    

        DB::table('employer_password_t')->insert([
            
            [   
                'employer_id' => '1',             
                'login_id' => '1',
                'password' => '1',                
                'created_by' => '9999',
                'updated_by' => '9999',
            ],          

        ]);   




        DB::table('school_m')->insert([
            
            [                
                'school_cd' => '1',
                'school_division' => '3',
                'school_name' => 'インターナショナルデザインアカデミー',               
                'post_code' => '901-2131',
                'address1' => '沖縄県浦添市牧港1-60-14',
                'address2' => '',
                'tel' => '',
                'fax' => '',
                'hp_url' => 'https://www.ida.ac.jp/',
                'mailaddress' => '',               
                'remarks' => '',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [                
                'school_cd' => '2',
                'school_division' => '3',
                'school_name' => '沖縄写真デザイン工芸学校',               
                'post_code' => '900-0014',
                'address1' => '沖縄県那覇市松尾2-1-13',
                'address2' => '',
                'tel' => '',
                'fax' => '',
                'hp_url' => 'https://www.ryubi-opd.com/',
                'mailaddress' => '',               
                'remarks' => '',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [                
                'school_cd' => '3',
                'school_division' => '3',
                'school_name' => '沖縄ブライダルモード学園',               
                'post_code' => '904-0102',
                'address1' => '沖縄県中頭郡北谷町伊平2丁目4番5',
                'address2' => '',
                'tel' => '',
                'fax' => '',
                'hp_url' => 'https://www.bmg.ac.jp/',
                'mailaddress' => '',               
                'remarks' => '',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [                
                'school_cd' => '4',
                'school_division' => '3',
                'school_name' => '沖縄ラフ＆ピース専門学校',               
                'post_code' => '900-0014',
                'address1' => '沖縄県那覇市松尾2-1-29',
                'address2' => '',
                'tel' => '',
                'fax' => '',
                'hp_url' => 'https://laughandpeace.ac.jp/',
                'mailaddress' => '',               
                'remarks' => '',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],        
        ]);     

        DB::table('majorsubject_m')->insert([
            
            [                
                'school_cd' => '1',
                'majorsubject_cd' => '1',
                'majorsubject_name' => '総合デザイン科→デジタルデザイン分野（２年次から）',               
                'studyperiod' => '36',              
                'remarks' => '１年次はグラフィック、デザイン、マンガ、ファッションの基礎。２年次から自分の適性にあった専門分野を選択。',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [                
                'school_cd' => '1',
                'majorsubject_cd' => '2',
                'majorsubject_name' => 'デザイン専攻科→デジタルデザイン分野',               
                'studyperiod' => '24',              
                'remarks' => '入学から専門分野の学習が始まる。',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [                
                'school_cd' => '1',
                'majorsubject_cd' => '3',
                'majorsubject_name' => 'デザインマスターズ科',               
                'studyperiod' => '12',              
                'remarks' => '全てのデザイン科目を学習するため、カメラに興味あって学習している生徒がいる可能性あり。',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [                
                'school_cd' => '2',
                'majorsubject_cd' => '1',
                'majorsubject_name' => '写真デザイン科（2年）',               
                'studyperiod' => '24',              
                'remarks' => '昼間部（通学制）と「通信部」の2コースがある。HPを見た感じ写真に特化しているのがわかる。',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [                
                'school_cd' => '2',
                'majorsubject_cd' => '2',
                'majorsubject_name' => '写真デザイン科（半年）',               
                'studyperiod' => '6',              
                'remarks' => '昼間部（通学制）と「通信部」の2コースがある。HPを見た感じ写真に特化しているのがわかる。',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [                
                'school_cd' => '3',
                'majorsubject_cd' => '1',
                'majorsubject_name' => 'ブライダルリゾート科→フォトグラファー',               
                'studyperiod' => '24',              
                'remarks' => 'カメラの専門コースではなく、授業の一環でカメラの基礎を学習すると思われる。目指す職業でフォトグラファーがあるので、カメラマンを目指して入学する生徒もいる可能性あり。',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

            [                
                'school_cd' => '4',
                'majorsubject_cd' => '1',
                'majorsubject_name' => '映像コース',               
                'studyperiod' => '36',              
                'remarks' => '中学卒業後に進学できる学校。カメラも扱うと思うが、主に映像だと思われる。',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],

           
        ]);     

    }
}
