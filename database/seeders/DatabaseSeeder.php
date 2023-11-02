<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Original\common;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('project_m')->insert([
            
            [   
                'project_id' => '1',             
                'project_name' => 'PhotoProject',
                'remarks' => 'フォトプロジェクト',
                'created_by' => '9999',
            ],          

            [                  
                'project_id' => '2',             
                'project_name' => 'RecruitProject',
                'remarks' => 'リクルートプロジェクト',
                'created_by' => '9999',                
            ],          


        ]);   

        DB::table('maincategory_m')->insert([
            
            [
                'maincategory_cd' => 1,
                'maincategory_name' => '性別',
                'created_by' => '9999',
                
            ],

            [
                'maincategory_cd' => 2,
                'maincategory_name' => '権限',
                'created_by' => '9999',
                
            ],

            [
                'maincategory_cd' => 3,
                'maincategory_name' => '学校区分',
                'created_by' => '9999',
                
            ],

            [
                'maincategory_cd' => 4,
                'maincategory_name' => '雇用者区分',
                'created_by' => '9999',
                
            ],


        ]);     

        DB::table('subcategory_m')->insert([

            //性別
            [
                'maincategory_cd' => 1,
                'subcategory_cd' => 1,
                'subcategory_name' => '男性',
                'display_order' => 1,
                'created_by' => '9999',
                
            ],
            [
                'maincategory_cd' => 1,
                'subcategory_cd' => 2,
                'subcategory_name' => '女性',
                'display_order' => 2,
                'created_by' => '9999',
                
            ],
            [
                'maincategory_cd' => 1,
                'subcategory_cd' => 3,
                'subcategory_name' => '未選択',
                'display_order' => 3,
                'created_by' => '9999',
                
            ],

            //権限
            [
                'maincategory_cd' => 2,
                'subcategory_cd' => 1,
                'subcategory_name' => '一般',
                'display_order' => 1,
                'created_by' => '9999',
                
            ],
            [
                'maincategory_cd' => 2,
                'subcategory_cd' => 2,
                'subcategory_name' => '管理者',
                'display_order' => 2,
                'created_by' => '9999',
                
            ],
            [
                'maincategory_cd' => 2,
                'subcategory_cd' => 3,
                'subcategory_name' => 'システム管理者',
                'display_order' => 3,
                'created_by' => '9999',
                
            ],


            //学校区分
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 1,
                'subcategory_name' => '高校',
                'display_order' => 1,
                'created_by' => '9999',
                
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 2,
                'subcategory_name' => '高専',
                'display_order' => 2,
                'created_by' => '9999',
                
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 3,
                'subcategory_name' => '専門学校',
                'display_order' => 3,
                'created_by' => '9999',
                
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 4,
                'subcategory_name' => '職業訓練校',
                'display_order' => 3,
                'created_by' => '9999',
                
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 5,
                'subcategory_name' => '短期大学',
                'display_order' => 4,
                'created_by' => '9999',
                
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 6,
                'subcategory_name' => '大学',
                'display_order' => 5,
                'created_by' => '9999',
                
            ],

            //雇用者区分
            [
                'maincategory_cd' => 4,
                'subcategory_cd' => 1,
                'subcategory_name' => '株式会社',
                'display_order' => 1,
                'created_by' => '9999',
                
            ],
            [
                'maincategory_cd' => 4,
                'subcategory_cd' => 2,
                'subcategory_name' => '有限会社',
                'display_order' => 2,
                'created_by' => '9999',
                
            ],
            [
                'maincategory_cd' => 4,
                'subcategory_cd' => 3,
                'subcategory_name' => '個人事業主',
                'display_order' => 3,
                'created_by' => '9999',
                
            ],

            [
                'maincategory_cd' => 4,
                'subcategory_cd' => 4,
                'subcategory_name' => 'その他',
                'display_order' => 4,
                'created_by' => '9999',
                
            ],

        ]);     


        DB::table('staff_m')->insert([
            
            [                
                'staff_last_name' => '島袋',
                'staff_first_name' => '信彦',
                'staff_last_name_yomi' => 'シマブクロ',
                'staff_first_name_yomi' => 'ノブヒコ',                
                'nick_name' => 'のぶっち',
                'gender' => '1',
                'tel' => '090-1234-5678',
                'mailaddress' => '',
                'authority' => '3',
                'remarks' => '学生応援プロジェクト創始者、システム管理者',
                'created_by' => '9999',
                
            ],

            [
             
                'staff_last_name' => '崎原',
                'staff_first_name' => '悠磨',
                'staff_last_name_yomi' => 'サキハラ',
                'staff_first_name_yomi' => 'ユウマ',   
                'nick_name' => 'ゆううゆうう',
                'gender' => '1',
                'tel' => '090-1234-5678',
                'mailaddress' => '',
                'authority' => '3',
                'remarks' => '学生応援プロジェクト創始者、代表',
                'created_by' => '9999',
                
            ],          

            [
             
                'staff_last_name' => '一般',
                'staff_first_name' => '太郎',
                'staff_last_name_yomi' => 'イッパン',
                'staff_first_name_yomi' => 'タロウ',                
                'nick_name' => 'イッパン',
                'gender' => '1',
                'tel' => '090-1234-5678',
                'mailaddress' => '',
                'authority' => '1',
                'remarks' => '2023年12月入社',
                'created_by' => '9999',
                
            ],          

        ]);     

        DB::table('staff_password_t')->insert([
            
            [                
                'staff_id' => '1',
                'login_id' => '1',
                'password' => common::encryption("1"),        
                'created_by' => '9999',
                
            ],

            [                
                'staff_id' => '2',
                'login_id' => '2',
                'password' => common::encryption("2"),        
                'created_by' => '9999',
                
            ],   

            [                
                'staff_id' => '3',
                'login_id' => '3',
                'password' => common::encryption("3"),                  
                'created_by' => '9999',
                
            ],   

        ]);     

        
        DB::table('employer_m')->insert([
            
            [   
                'employer_id' => '1',             
                'employer_division' => '3',
                'employer_name' => '遊遊craft',
                'employer_name_kana' => 'ユウユウクラフト',
                'post_code' => '904-0000',
                'address1' => '沖縄県西原町1111',
                'address2' => 'ユウユウビル　102',
                'tel' => '098-000-0000',
                'fax' => '098-111-1111',
                'hp_url' => 'https://www.yahoo.co.jp/',
                'mailaddress' => 'test@gmail.com',
                'remarks' => '業種：生産業（家具作り）やWebシステム構築',
                'created_by' => '9999',
                
            ],          

        ]);    

        DB::table('employer_password_t')->insert([
            
            [   
                'employer_id' => '1',             
                'login_id' => '1',
                'password' => common::encryption("1"),
                'created_by' => '9999',
                
            ],          

        ]);   

        DB::table('job_information_t')->insert([
            
            [   
                'id' => '1',             
                'employer_id' => '1',
                'job_id' => '1',
                'title' => 'キッチンスタッフ',
                'work_location_prefectural_cd' => '47',
                'work_location_municipality_cd' => '47329',
                'employment_status' => 'アルバイト',
                'working_time' => '17：00～23：00',
                'salary' => '時給1000円',
                'holiday' => '週休2日、相談してください。',
                'manager_name' => '島袋',
                'tel' => '',
                'fax' => '',
                'hp_url' => '',
                'job_image_folder_name' => 'aaa',
                'mailaddress' => '',
                'remarks' => '調理技術向上を目指しながら働いてみませんか？',
                'application_requirements' => '',
                'publish_start_date' => '2023-11-01',
                'publish_end_date' => '2024-01-30',
                'created_by' => '9999',
                
            ],          

            [   
                'id' => '2',             
                'employer_id' => '1',
                'job_id' => '2',
                'title' => 'ガソリンスタンドスタッフ',
                'work_location_prefectural_cd' => '47',
                'work_location_municipality_cd' => '47329',
                'employment_status' => 'アルバイト',
                'working_time' => '17：00～23：00',
                'salary' => '時給1000円',
                'holiday' => '週休2日、相談してください。',
                'manager_name' => '島袋',
                'tel' => '',
                'fax' => '',
                'hp_url' => '',
                'job_image_folder_name' => 'bbb',
                'mailaddress' => '',
                'remarks' => '車の事を勉強しながらお金を稼いでみませんか？',
                'application_requirements' => '',
                'publish_start_date' => '2023-11-01',
                'publish_end_date' => '2024-01-30',
                'created_by' => '9999',
                
            ],          

            [   
                'id' => '3',             
                'employer_id' => '1',
                'job_id' => '3',
                'title' => 'コールセンタースタッフ',
                'work_location_prefectural_cd' => '47',
                'work_location_municipality_cd' => '47329',
                'employment_status' => '正社員',
                'working_time' => '10：00～23：00　シフト制',
                'salary' => '時給1000円',
                'holiday' => '週休2日、相談してください。',
                'manager_name' => '島袋',
                'tel' => '',
                'fax' => '',
                'hp_url' => '',
                'job_image_folder_name' => 'ccc',
                'mailaddress' => '',
                'remarks' => '家電に関するサポート窓口',
                'application_requirements' => '',
                'publish_start_date' => '2023-11-01',
                'publish_end_date' => '2024-01-30',
                'created_by' => '9999',
                
            ],          

            [   
                'id' => '4',             
                'employer_id' => '1',
                'job_id' => '4',
                'title' => '遊技場スタッフ',
                'work_location_prefectural_cd' => '47',
                'work_location_municipality_cd' => '47329',
                'employment_status' => '契約社員',
                'working_time' => '7：00～25：00　シフト制',
                'salary' => '時給1200円',
                'holiday' => '週休3日、相談してください。',
                'manager_name' => '島袋',
                'tel' => '',
                'fax' => '',
                'hp_url' => '',
                'job_image_folder_name' => 'ddd',
                'mailaddress' => '',
                'remarks' => '遊技場のスタッフ',
                'application_requirements' => '',
                'publish_start_date' => '2023-11-01',
                'publish_end_date' => '2024-01-30',
                'created_by' => '9999',
                
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
                
            ],

            [                
                'school_cd' => '1',
                'majorsubject_cd' => '2',
                'majorsubject_name' => 'デザイン専攻科→デジタルデザイン分野',               
                'studyperiod' => '24',              
                'remarks' => '入学から専門分野の学習が始まる。',
                'created_by' => '9999',
                
            ],

            [                
                'school_cd' => '1',
                'majorsubject_cd' => '3',
                'majorsubject_name' => 'デザインマスターズ科',               
                'studyperiod' => '12',              
                'remarks' => '全てのデザイン科目を学習するため、カメラに興味あって学習している生徒がいる可能性あり。',
                'created_by' => '9999',
                
            ],

            [                
                'school_cd' => '2',
                'majorsubject_cd' => '1',
                'majorsubject_name' => '写真デザイン科（2年）',               
                'studyperiod' => '24',              
                'remarks' => '昼間部（通学制）と「通信部」の2コースがある。HPを見た感じ写真に特化しているのがわかる。',
                'created_by' => '9999',
                
            ],

            [                
                'school_cd' => '2',
                'majorsubject_cd' => '2',
                'majorsubject_name' => '写真デザイン科（半年）',               
                'studyperiod' => '6',              
                'remarks' => '昼間部（通学制）と「通信部」の2コースがある。HPを見た感じ写真に特化しているのがわかる。',
                'created_by' => '9999',
                
            ],

            [                
                'school_cd' => '3',
                'majorsubject_cd' => '1',
                'majorsubject_name' => 'ブライダルリゾート科→フォトグラファー',               
                'studyperiod' => '24',              
                'remarks' => 'カメラの専門コースではなく、授業の一環でカメラの基礎を学習すると思われる。目指す職業でフォトグラファーがあるので、カメラマンを目指して入学する生徒もいる可能性あり。',
                'created_by' => '9999',
                
            ],

            [                
                'school_cd' => '4',
                'majorsubject_cd' => '1',
                'majorsubject_name' => '映像コース',               
                'studyperiod' => '36',              
                'remarks' => '中学卒業後に進学できる学校。カメラも扱うと思うが、主に映像だと思われる。',
                'created_by' => '9999',
                
            ],

           
        ]);     

        DB::table('member_m')->insert([
            
            [                
                'member_id' => '1',
                'member_last_name' => '学生',
                'member_first_name' => '太郎',
                'member_last_name_yomi' => 'ガクセイ',
                'member_first_name_yomi' => 'タロウ',
                'gender' => '1',
                'birthday' => '2005/02/09',
                'tel' => '080-1234-5678',
                'mailaddress' => 'test1@test.com',
                'school_cd' => '1',
                'majorsubject_cd' => '1',
                'admission_yearmonth' => '2022-04',
                'graduation_yearmonth' => '2024-03',
                'emergencycontact_relations' => '父親',
                'emergencycontact_tel' => '070-1234-5678',
                'remarks' => '備考テスト',
                'registration_status' => '1',                
                'created_by' => '9999',
                
            ], 
            
            [                
                'member_id' => '2',
                'member_last_name' => '学',
                'member_first_name' => '花子',
                'member_last_name_yomi' => 'ガク',
                'member_first_name_yomi' => 'ハナコ',
                'gender' => '2',
                'birthday' => '2005/02/09',
                'tel' => '080-1234-5678',
                'mailaddress' => 'test2@test.com',
                'school_cd' => '2',
                'majorsubject_cd' => '1',
                'admission_yearmonth' => '2022-04',
                'graduation_yearmonth' => '2024-03',
                'emergencycontact_relations' => '父親',
                'emergencycontact_tel' => '070-1234-5678',
                'remarks' => '備考テスト',
                'registration_status' => '1',                
                'created_by' => '9999',
                
            ], 

            [                
                'member_id' => '3',
                'member_last_name' => '島袋',
                'member_first_name' => '青年',
                'member_last_name_yomi' => 'シマブクロ',
                'member_first_name_yomi' => 'セイネン',
                'gender' => '1',
                'birthday' => '2005/02/09',
                'tel' => '080-1234-5678',
                'mailaddress' => 'test3@test.com',
                'school_cd' => '3',
                'majorsubject_cd' => '1',
                'admission_yearmonth' => '2022-04',
                'graduation_yearmonth' => '2024-03',
                'emergencycontact_relations' => '父親',
                'emergencycontact_tel' => '070-1234-5678',
                'remarks' => '備考テスト',
                'registration_status' => '1',                
                'created_by' => '9999',
                
            ], 

        ]);     

        DB::table('member_password_t')->insert([
            
            [                
                'member_id' => '1',
                'mailaddress' => 'test1@test.com',
                'password' => common::encryption("1"),        
                'created_by' => '9999',
                
            ],

            [                
                'member_id' => '2',
                'mailaddress' => 'test2@test.com',
                'password' => common::encryption("2"),        
                'created_by' => '9999',
                
            ],   

            [                
                'member_id' => '3',
                'mailaddress' => 'test3@test.com',
                'password' => common::encryption("3"),                  
                'created_by' => '9999',
                
            ],   

        ]);     

        DB::table('photoget_t')->insert([
            
            [                
                'date' => '20230101',
                'code' => '001',
                'password' => common::encryption("4483"),        
                'with_password_flg' => 1,
                'saved_folder' => '001_U3K5K5ia0u',
                'qr_code_name' => 'QrCode_20230101001.png',
                'url' => 'https://yu-yu-craft.com/photo_project/password_entry?key_code=20230101001&cipher=f9aTzbYxbS',
                'cipher' => 'f9aTzbYxbS',
                'created_by' => '9999',
                
            ],

            [                
                'date' => '20230101',
                'code' => '002',
                'password' => common::encryption("4672"),        
                'with_password_flg' => 1,
                'saved_folder' => '002_pziOIxfuQ0',
                'qr_code_name' => 'QrCode_20230101002.png',
                'url' => 'https://yu-yu-craft.com/photo_project/password_entry?key_code=20230101002&cipher=nueP3NU5qz',
                'cipher' => 'nueP3NU5qz',
                'created_by' => '9999',
                
            ],

            [                
                'date' => '20230101',
                'code' => '003',
                'password' => common::encryption("3465"),        
                'with_password_flg' => 1,
                'saved_folder' => '003_pg1yvctpLd',
                'qr_code_name' => 'QrCode_20230101003.png',
                'url' => 'https://yu-yu-craft.com/photo_project/password_entry?key_code=20230101003&cipher=rapMR45zeH',
                'cipher' => 'rapMR45zeH',
                'created_by' => '9999',
                
            ],

            [                
                'date' => '20230101',
                'code' => '004',
                'password' => common::encryption("4039"),        
                'with_password_flg' => 1,
                'saved_folder' => '004_5JwBsIe0nM',
                'qr_code_name' => 'QrCode_20230101004.png',
                'url' => 'https://yu-yu-craft.com/photo_project/password_entry?key_code=20230101004&cipher=KTmzVEwbJK',
                'cipher' => 'KTmzVEwbJK',
                'created_by' => '9999',
                
            ],

            [                
                'date' => '20230101',
                'code' => '005',
                'password' => common::encryption("8294"),        
                'with_password_flg' => 1,
                'saved_folder' => '005_YZNGdzFKO3',
                'qr_code_name' => 'QrCode_20230101005.png',
                'url' => 'https://yu-yu-craft.com/photo_project/password_entry?key_code=20230101005&cipher=FwRSK6fRN9',
                'cipher' => 'FwRSK6fRN9',
                'created_by' => '9999',
                
            ],

            [                
                'date' => '20230101',
                'code' => '006',
                'password' => common::encryption("2133"),        
                'with_password_flg' => 1,
                'saved_folder' => '006_UYflcQeRS7',
                'qr_code_name' => 'QrCode_20230101006.png',
                'url' => 'https://yu-yu-craft.com/photo_project/password_entry?key_code=20230101006&cipher=ywxPzN9acK',
                'cipher' => 'ywxPzN9acK',
                'created_by' => '9999',
                
            ],

            [                
                'date' => '20230101',
                'code' => '007',
                'password' => common::encryption("7515"),        
                'with_password_flg' => 1,
                'saved_folder' => '007_tS9KBVa1ka',
                'qr_code_name' => 'QrCode_20230101007.png',
                'url' => 'https://yu-yu-craft.com/photo_project/password_entry?key_code=20230101007&cipher=btVJtWF9dJ',
                'cipher' => 'btVJtWF9dJ',
                'created_by' => '9999',
                
            ],

            [                
                'date' => '20230101',
                'code' => '008',
                'password' => common::encryption("6646"),        
                'with_password_flg' => 1,
                'saved_folder' => '008_INVkmYsrpa',
                'qr_code_name' => 'QrCode_20230101008.png',
                'url' => 'https://yu-yu-craft.com/photo_project/password_entry?key_code=20230101008&cipher=tytUrzfySw',
                'cipher' => 'tytUrzfySw',
                'created_by' => '9999',
                
            ],
           
        ]);     

        
        // 求人補足大分類マスタ
        $index = 0;
        DB::table('job_supplement_maincategory_m')->insert([
            
            [                
                'job_supplement_maincategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_name' => '働く期間',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            

            [                
                'job_supplement_maincategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_name' => 'シフトや休日',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_maincategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_name' => '会社の特徴',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_maincategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_name' => '求める人材',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_maincategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_name' => '待遇',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_maincategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_name' => '応募・面接',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],          

        ]);


        // 求人補足大分類マスタ
        $index = 0;
        DB::table('job_supplement_subcategory_m')->insert([
            
            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 1,
                'job_supplement_subcategory_name' => '超短期(1~7日',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 1,
                'job_supplement_subcategory_name' => '短期(1ヶ月以内)',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 1,
                'job_supplement_subcategory_name' => '短期(3ヶ月以内)',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 1,
                'job_supplement_subcategory_name' => '短期(6ヶ月以内)',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 1,
                'job_supplement_subcategory_name' => '季節限定',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '短時間(1日4h以内)',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '夜21時以降スタート',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '完全週休2日制',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '土日休み',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '年間休日120日以上',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => 'フレックスタイム制',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '週1、2日~OK',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => 'シフト自由・相談OK',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '土日のみ勤務',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '残業ほぼなし(月10時間以下)',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '子育てママ活躍中',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => 'ミドル(40代・50代)活躍中',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => 'シニア(60代以上)活躍中',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '副業・WワークOK',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '在宅・テレワーク',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '学生10名以上勤務',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '社員100名以上',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '女性管理職20%以上',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '創業20年以上',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => 'ベンチャー企業',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '駅徒歩5分以内',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '転勤無し',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '未経験歓迎',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => 'ブランクOK',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '高校生OK',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '専門・大学生OK',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '新卒歓迎(3月卒予定)',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '第二新卒歓迎(卒後3年以内)',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => 'I・Uターン者歓迎',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '扶養控除内OK',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => 'マネジメント経験',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '経験者・キャリア募集',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '資格が活かせる',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '語学力が活かせる・身につく',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '交通費支給',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '駐車場有',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '送迎有',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '髪型・ピアス・ネイルOK',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '私服OK',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '制服有',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '社宅・寮有',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '食事(手当)有',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '産休・育休',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '介護休',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '託児所有・託児所近く',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '社員登用制度有',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '資格取得支援制度有',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '賞与有',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '日払いor週払い有',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '赴任旅費支給',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '受動喫煙防止策有',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => '入社祝い金あり',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => '友達同士の応募OK',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => '募集人数30人以上',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => '履歴書不要',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => '出張面接可能',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => 'WEB・電話面接OK',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => 'オープニングスタッフ募集',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => '職場見学OK',
                'display_order' => $index,
                'created_by' => '9999',
                
            ],
            

               

        ]);

        if(env('APP_DEBUG')){

            DB::table('job_supplement_connection_t')->insert([
                
                [                
                    'employer_id' => '1',
                    'job_id' => '1',
                    'job_supplement_subcategory_cd' => '1',                
                ],

                [                
                    'employer_id' => '1',
                    'job_id' => '1',
                    'job_supplement_subcategory_cd' => '25',                
                ],

                [                
                    'employer_id' => '1',
                    'job_id' => '1',
                    'job_supplement_subcategory_cd' => '29',                
                ],


                [                
                    'employer_id' => '1',
                    'job_id' => '2',
                    'job_supplement_subcategory_cd' => '2',
                ],

                [                
                    'employer_id' => '1',
                    'job_id' => '2',
                    'job_supplement_subcategory_cd' => '26',
                ],

                [                
                    'employer_id' => '1',
                    'job_id' => '1',
                    'job_supplement_subcategory_cd' => '30',                
                ],

            ]);    
        }

    }
}
