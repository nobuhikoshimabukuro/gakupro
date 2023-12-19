<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Original\common;
use Carbon\Carbon;
use League\Csv\Reader;

// ・マイグレーション実行 既存Table削除し再作成後シードも実行
// php artisan migrate:fresh --database=mysql --seed
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Storage::disk('recruit_project_public_path')->deleteDirectory("job_image");
       
        common::create_address_m();

        DB::table('maincategory_m')->insert([
            
            [
                'maincategory_cd' => 1,
                'maincategory_name' => '性別',
                'display_order' => 1,
                'created_by' => '1',   
            ],

            [
                'maincategory_cd' => 2,
                'maincategory_name' => '権限',
                'display_order' => 2,
                'created_by' => '1',
                
            ],

            [
                'maincategory_cd' => 3,
                'maincategory_name' => '学校区分',
                'display_order' => 3,
                'created_by' => '1',
                
            ],

            [
                'maincategory_cd' => 4,
                'maincategory_name' => '雇用者区分',
                'display_order' => 4,
                'created_by' => '1',
                
            ],


        ]);     

        DB::table('subcategory_m')->insert([

            //性別
            [
                'maincategory_cd' => 1,
                'subcategory_cd' => 1,
                'subcategory_name' => '男性',
                'display_order' => 1,
                'created_by' => '1',
                
            ],
            [
                'maincategory_cd' => 1,
                'subcategory_cd' => 2,
                'subcategory_name' => '女性',
                'display_order' => 2,
                'created_by' => '1',
                
            ],
            [
                'maincategory_cd' => 1,
                'subcategory_cd' => 3,
                'subcategory_name' => '未選択',
                'display_order' => 3,
                'created_by' => '1',
                
            ],

            //権限
            [
                'maincategory_cd' => 2,
                'subcategory_cd' => 1,
                'subcategory_name' => '一般',
                'display_order' => 1,
                'created_by' => '1',
                
            ],
            [
                'maincategory_cd' => 2,
                'subcategory_cd' => 2,
                'subcategory_name' => '管理者',
                'display_order' => 2,
                'created_by' => '1',
                
            ],
            [
                'maincategory_cd' => 2,
                'subcategory_cd' => 3,
                'subcategory_name' => 'システム管理者',
                'display_order' => 3,
                'created_by' => '1',
                
            ],


            //学校区分
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 1,
                'subcategory_name' => '高校',
                'display_order' => 1,
                'created_by' => '1',
                
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 2,
                'subcategory_name' => '高専',
                'display_order' => 2,
                'created_by' => '1',
                
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 3,
                'subcategory_name' => '専門学校',
                'display_order' => 3,
                'created_by' => '1',
                
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 4,
                'subcategory_name' => '職業訓練校',
                'display_order' => 3,
                'created_by' => '1',
                
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 5,
                'subcategory_name' => '短期大学',
                'display_order' => 4,
                'created_by' => '1',
                
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 6,
                'subcategory_name' => '大学',
                'display_order' => 5,
                'created_by' => '1',
                
            ],

            //雇用者区分
            [
                'maincategory_cd' => 4,
                'subcategory_cd' => 1,
                'subcategory_name' => '株式会社',
                'display_order' => 1,
                'created_by' => '1',
                
            ],
            [
                'maincategory_cd' => 4,
                'subcategory_cd' => 2,
                'subcategory_name' => '有限会社',
                'display_order' => 2,
                'created_by' => '1',
                
            ],
            [
                'maincategory_cd' => 4,
                'subcategory_cd' => 3,
                'subcategory_name' => '個人事業主',
                'display_order' => 3,
                'created_by' => '1',
                
            ],

            [
                'maincategory_cd' => 4,
                'subcategory_cd' => 4,
                'subcategory_name' => 'その他',
                'display_order' => 4,
                'created_by' => '1',
                
            ],

        ]);     


        DB::table('staff_m')->insert([
            
          
            [                
                'staff_id' => 1,
                'staff_last_name' => '島袋',
                'staff_first_name' => '信彦',
                'staff_last_name_yomi' => 'シマブクロ',
                'staff_first_name_yomi' => 'ノブヒコ',
                'nick_name' => 'のぶっち',
                'gender' => '1',
                'tel' => '090-1234-5678',
                'mailaddress' => '',
                'authority' => '3',
                'remarks' => 'システム管理者',
                'created_by' => '1',
                
            ],

            [
                'staff_id' => 2,
                'staff_last_name' => '崎原',
                'staff_first_name' => '悠磨',
                'staff_last_name_yomi' => 'サキハラ',
                'staff_first_name_yomi' => 'ユウマ',   
                'nick_name' => 'ゆううゆうう',
                'gender' => '1',
                'tel' => '090-1234-5678',
                'mailaddress' => '',
                'authority' => '3',
                'remarks' => '代表',
                'created_by' => '1',
                
            ], 

            [
                'staff_id' => 3,
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
                'created_by' => '1',
                
            ], 

        ]);     

        DB::table('staff_password_t')->insert([
            
            [                
                'staff_id' => '1',
                'login_id' => '1',
                'password' => common::encryption("1"),        
                'created_by' => '1',
                
            ],

            [                
                'staff_id' => '2',
                'login_id' => '2',
                'password' => common::encryption("2"),        
                'created_by' => '1',
                
            ],   

            [                
                'staff_id' => '3',
                'login_id' => '3',
                'password' => common::encryption("3"),  
                'created_by' => '1',
                
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

                'employer_description' => '私達は求職者と雇用主とのミスマッチを改善し、
                より高いクォリティのマッチングができることを目指しております！
                転職の無料相談や履歴書の作成指導、
                面接トレーニング、教育研修（ビジネスマナー等）の実施、
                その他子育て支援、再就職支援など、
                更なるキャリアアップのための支援アドバイスの実施など、
                長年培ってきた人材ビジネスのノウハウを活かし、
                「雇用にかかわるトータルサービス」 を提供しています！
                
                ◆【安定した職場環境♪　安心の福利厚生♪　未経験OKでスキルが身に付ける♪　を重視の方】
                ☆未経験者歓迎！
                ☆優良企業で安定したお仕事に就きたい、スキルを高めたい方向け♪
                ☆自分に合う会社なら、後々直接雇用になりたいと考えている方!
                ☆長期で安定した職に就きたい！　など
                ◆皆様のご希望にマッチしたお仕事をご紹介いたします！
                
                
                ☆早い者勝ちのおすすめジョブです！
                ☆綺麗なトイレ、広々とした休憩室など安心の環境設備！
                ☆県内各地に営業所を持つ企業の本社でのお仕事です！
                ☆長年培ってきたノウハウがあり安心してスキルを身に付けられます!
                ☆自分に合う会社なら、後々直接雇用になりたいと考えている方向き！
                ☆20～30代の男女が活躍中！
                ☆即日から勤務OKの求人です。
                ☆お気軽にお声掛けください。',

                'remarks' => '20代～30代男女活躍中！                             
                県内優良企業です！                
                「人輝く 企業 未来」を次はあなたが創ります。
                コム沖縄では人気のお仕事を幅広く取り扱っております！
                各種社会保険・交通費支給・有給休暇有！の求人など！(条件による）
                事務系、作業系、ドライバー、医療系、販売、etc･･･
                あなたの「魅力」「ポテンシャル」「可能性」を引き出し、
                ピッタリなお仕事をご紹介します！
                ',
                'created_by' => '1',
                
            ], 

        ]);    

        DB::table('employer_password_t')->insert([
            
            [   
                'employer_id' => '1',
                'login_id' => '1',
                'password' => common::encryption("1"),
                'created_by' => '1',
                
            ], 

        ]);   

        DB::table('job_information_t')->insert([
            
            [   
                'id' => '1',
                'employer_id' => '1',
                'job_id' => '1',
                'title' => '事務スタッフ',
                'sub_title' => '【急募】事務スタッフ！ 高時給1,100円！',
                'work_location_prefectural_cd' => '47',
                'work_location_municipality_cd' => '47329',   
                'working_time' => '17：00～23：00',

                'salary' => '正社員：月給15万円～
アルバイト：時給900円～',

                'holiday' => '週休2日～
相談可能',

                'manager_name' => '島袋',
                'tel' => '',
                'fax' => '',
                'hp_url' => '',
                'job_image_folder_name' => 'qrstuvwEFH',
                'mailaddress' => '',                

                'scout_statement' => '20代～30代男女活躍中！
県内優良企業です！
「人輝く 企業 未来」を次はあなたが創ります。
コム沖縄では人気のお仕事を幅広く取り扱っております！
各種社会保険・交通費支給・有給休暇有！の求人など！(条件による）
事務系、作業系、ドライバー、医療系、販売、etc･･･
あなたの「魅力」「ポテンシャル」「可能性」を引き出し、
ピッタリなお仕事をご紹介します！',

                'remarks' => '調理技術向上を目指しながら働いてみませんか？',
                'application_requirements' => '',
                'created_by' => '1',
                
            ], 

        ]); 

        
        DB::table('job_password_item_m')->insert([
            
            [   
                'job_password_item_id' => '1',
                'job_password_item_name' => 'サイト開設スペシャル365日間プラン',
                'price' => 0,       
                'added_date' => '365',
                'sales_start_date' => '2022-01-01',
                'sales_end_date' => '2999-12-31',                
                'remarks' => '求人サイト開設時に求人数を増やすためのプラン',
                'created_by' => '1',   
            ],

            [   
                'job_password_item_id' => '2',
                'job_password_item_name' => '求人新規登録時3日間プラン',
                'price' => 0,
                'added_date' => '3',
                'sales_start_date' => '2022-01-01',
                'sales_end_date' => '2999-12-31',       
                'remarks' => '求人新規登録日の翌日から3日間求人公開を行える',
                'created_by' => '1',   
            ],

            [   
                'job_password_item_id' => '3',
                'job_password_item_name' => '求人公開7日間追加プラン',       
                'price' => 1980,
                'added_date' => '7',
                'sales_start_date' => '2022-01-01',
                'sales_end_date' => '2999-12-31',       
                'remarks' => '求人公開パスワードを購入して頂き、認証後で公開日の範囲を7日間加算できるプラン',
                'created_by' => '1',
                
            ],

            [   
                'job_password_item_id' => '4',
                'job_password_item_name' => '求人公開14日間追加プラン',
                'price' => 2980,
                'added_date' => '14',
                'sales_start_date' => '2022-01-01',
                'sales_end_date' => '2999-12-31',       
                'remarks' => '求人公開パスワードを購入して頂き、認証後で公開日の範囲を14日間加算できるプラン',
                'created_by' => '1',
                
            ],

            [   
                'job_password_item_id' => '5',
                'job_password_item_name' => '求人公開28日間追加プラン',
                'price' => 4980,
                'added_date' => '28',
                'sales_start_date' => '2022-01-01',
                'sales_end_date' => '2999-12-31',       
                'remarks' => '求人公開パスワードを購入して頂き、認証後で公開日の範囲を28日間加算できるプラン',
                'created_by' => '1',
                
            ],


        ]);   

        // 当日の日付を取得
        $today = Carbon::now();

        $today_f = $today;
        $add_Date1 = $today;
        $add_Date2 = $today;
        // 14日後の日付を計算
        $today_f = $today_f->format('Y-m-d');        
        $add_Date1 = $add_Date1->addDays(7)->format('Y-m-d');   
        $add_Date2 = $add_Date2->addDays(28)->format('Y-m-d');

        DB::table('job_password_t')->insert([
            
            [
                'job_password_id' => '1',
                'job_password_item_id' => '3',
                'password' => '0123456789',
                'usage_flg' => '1',
                'sale_flg' => '1',         
                'seller' => '1',
                'sale_datetime' => $today_f,
                'created_by' => '1',
                
            ],
        ]);   

     


        DB::table('job_password_connection_t')->insert([
            
            [   
                'employer_id' => '1',
                'job_id' => '1',
                'job_password_id' => '1',
                'branch_number' => '1',
                'publish_start_date' => $today_f,
                'publish_end_date' => $add_Date1,
                'created_by' => '1',
                
            ],

                    


        ]);   


        // 雇用形態マスタ
        $index = 0;
        DB::table('employment_status_m')->insert([
            
            [                
                'employment_status_id' => $index = $index + 1,
                'employment_status_name' => '正社員',
                'display_order' => $index,
                'created_by' => '1',   
            ],

            [                
                'employment_status_id' => $index = $index + 1,
                'employment_status_name' => '契約社員',
                'display_order' => $index,
                'created_by' => '1',   
            ],

            [                
                'employment_status_id' => $index = $index + 1,
                'employment_status_name' => 'アルバイト',
                'display_order' => $index,
                'created_by' => '1',   
            ],

            [                
                'employment_status_id' => $index = $index + 1,
                'employment_status_name' => 'パート',
                'display_order' => $index,
                'created_by' => '1',   
            ],

            [                
                'employment_status_id' => $index = $index + 1,
                'employment_status_name' => '派遣社員',
                'display_order' => $index,
                'created_by' => '1',   
            ],

            [                
                'employment_status_id' => $index = $index + 1,
                'employment_status_name' => '紹介予定派遣',
                'display_order' => $index,
                'created_by' => '1',   
            ],

            [                
                'employment_status_id' => $index = $index + 1,
                'employment_status_name' => '嘱託社員',
                'display_order' => $index,
                'created_by' => '1',   
            ],

            [                
                'employment_status_id' => $index = $index + 1,
                'employment_status_name' => '業務委託',
                'display_order' => $index,
                'created_by' => '1',   
            ],

                     

        ]);



        // 給与大分類マスタ
        $index = 0;
        DB::table('salary_maincategory_m')->insert([
            
            [                
                'salary_maincategory_cd' => $index = $index + 1,
                'salary_maincategory_name' => '時給',
                'display_order' => $index,
                'created_by' => '1',
            ],

            [                
                'salary_maincategory_cd' => $index = $index + 1,
                'salary_maincategory_name' => '日給',
                'display_order' => $index,
                'created_by' => '1',
            ],

            [                
                'salary_maincategory_cd' => $index = $index + 1,
                'salary_maincategory_name' => '月給',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'salary_maincategory_cd' => $index = $index + 1,
                'salary_maincategory_name' => '年俸',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

        ]);

        // 給与中分類マスタ
        $salary_data = common::create_salary_data();

        foreach ($salary_data as $index => $info){

            DB::table('salary_subcategory_m')->insert([
            
                [                
                    'salary_subcategory_cd' => $info["salary_subcategory_cd"],
                    'salary_maincategory_cd' => $info["salary_maincategory_cd"],
                    'salary' => $info["salary"],
                    'display_order' => $info["display_order"],
                    'created_by' => '1',
                    
                ]
            ]);

        }
        
        DB::table('employment_status_connection_t')->insert([
            
            [                
                'employer_id' => 1,
                'job_id' => 1,
                'employment_status_id' => 1,
                'salary_maincategory_cd' => 3,
                'salary_subcategory_cd' => 42,
                'created_by' => '1',
                
            ],

            [                
                'employer_id' => 1,
                'job_id' => 1,
                'employment_status_id' => 3,
                'salary_maincategory_cd' => 1,
                'salary_subcategory_cd' => 6,
                'created_by' => '1',
                
            ],

        ]);

        
        // 職種大分類マスタ
        $index = 0;
        DB::table('job_maincategory_m')->insert([
            
            [                
                'job_maincategory_cd' => $index = $index + 1,
                'job_maincategory_name' => 'IT関連',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_maincategory_cd' => $index = $index + 1,
                'job_maincategory_name' => 'コールセンター',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_maincategory_cd' => $index = $index + 1,
                'job_maincategory_name' => '飲食店',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

        ]);

        // 職種中分類マスタ
        $index = 0;
        DB::table('job_subcategory_m')->insert([
            
            [                
                'job_subcategory_cd' => $index = $index + 1,
                'job_maincategory_cd' => 1,
                'job_subcategory_name' => 'プログラマー',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_subcategory_cd' => $index = $index + 1,
                'job_maincategory_cd' => 1,
                'job_subcategory_name' => 'SE',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_subcategory_cd' => $index = $index + 1,
                'job_maincategory_cd' => 1,
                'job_subcategory_name' => 'Webデザイナー',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_subcategory_cd' => $index = $index + 1,
                'job_maincategory_cd' => 2,
                'job_subcategory_name' => '受信のみ',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_subcategory_cd' => $index = $index + 1,
                'job_maincategory_cd' => 2,
                'job_subcategory_name' => '受信・発信',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_subcategory_cd' => $index = $index + 1,
                'job_maincategory_cd' => 2,
                'job_subcategory_name' => '電話営業',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_subcategory_cd' => $index = $index + 1,
                'job_maincategory_cd' => 3,
                'job_subcategory_name' => 'キッチン',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_subcategory_cd' => $index = $index + 1,
                'job_maincategory_cd' => 3,
                'job_subcategory_name' => 'ホール',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_subcategory_cd' => $index = $index + 1,
                'job_maincategory_cd' => 3,
                'job_subcategory_name' => '店長候補',
                'display_order' => $index,
                'created_by' => '1',
                
            ],
    

        ]);

        
        // 求人補足大分類マスタ
        $index = 0;
        DB::table('job_supplement_maincategory_m')->insert([
            
            [                
                'job_supplement_maincategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_name' => '働く期間',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            

            [                
                'job_supplement_maincategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_name' => 'シフトや休日',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_maincategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_name' => '会社の特徴',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_maincategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_name' => '求める人材',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_maincategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_name' => '待遇',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_maincategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_name' => '応募・面接',
                'display_order' => $index,
                'created_by' => '1',
                
            ], 

        ]);


        // 求人補足中分類マスタ
        $index = 0;
        DB::table('job_supplement_subcategory_m')->insert([
            
            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 1,
                'job_supplement_subcategory_name' => '超短期(1~7日)',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 1,
                'job_supplement_subcategory_name' => '短期(1ヶ月以内)',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 1,
                'job_supplement_subcategory_name' => '短期(3ヶ月以内)',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 1,
                'job_supplement_subcategory_name' => '短期(6ヶ月以内)',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 1,
                'job_supplement_subcategory_name' => '季節限定',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '短時間(1日4h以内)',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '夜21時以降スタート',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '完全週休2日制',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '土日休み',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '年間休日120日以上',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => 'フレックスタイム制',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '週1、2日~OK',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => 'シフト自由・相談OK',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '土日のみ勤務',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 2,
                'job_supplement_subcategory_name' => '残業ほぼなし(月10時間以下)',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '子育てママ活躍中',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => 'ミドル(40代・50代)活躍中',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => 'シニア(60代以上)活躍中',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '副業・WワークOK',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '在宅・テレワーク',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '学生10名以上勤務',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '社員100名以上',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '女性管理職20%以上',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '創業20年以上',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => 'ベンチャー企業',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '駅徒歩5分以内',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 3,
                'job_supplement_subcategory_name' => '転勤無し',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '未経験歓迎',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => 'ブランクOK',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '高校生OK',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '専門・大学生OK',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '新卒歓迎(3月卒予定)',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '第二新卒歓迎(卒後3年以内)',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => 'I・Uターン者歓迎',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '扶養控除内OK',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => 'マネジメント経験',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '経験者・キャリア募集',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '資格が活かせる',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 4,
                'job_supplement_subcategory_name' => '語学力が活かせる・身につく',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '交通費支給',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '駐車場有',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '送迎有',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '髪型・ピアス・ネイルOK',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '私服OK',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '制服有',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '社宅・寮有',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '食事(手当)有',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '産休・育休',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '介護休',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '託児所有・託児所近く',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '社員登用制度有',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '資格取得支援制度有',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '賞与有',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '日払いor週払い有',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '赴任旅費支給',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 5,
                'job_supplement_subcategory_name' => '受動喫煙防止策有',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => '入社祝い金あり',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => '友達同士の応募OK',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => '募集人数30人以上',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => '履歴書不要',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => '出張面接可能',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => 'WEB・電話面接OK',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => 'オープニングスタッフ募集',
                'display_order' => $index,
                'created_by' => '1',
                
            ],

            [                
                'job_supplement_subcategory_cd' => $index = $index + 1,
                'job_supplement_maincategory_cd' => 6,
                'job_supplement_subcategory_name' => '職場見学OK',
                'display_order' => $index,
                'created_by' => '1',
                
            ],
            

               

        ]);

        if(env('data_base_insert_flg')){

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
                'created_by' => '1',
                
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
                'created_by' => '1',
                
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
                'created_by' => '1',
                
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
                'created_by' => '1',
                
            ],        
        ]);     

        DB::table('majorsubject_m')->insert([
            
            [                
                'school_cd' => '1',
                'majorsubject_cd' => '1',
                'majorsubject_name' => '総合デザイン科→デジタルデザイン分野（２年次から）',  
                'studyperiod' => '36', 
                'remarks' => '１年次はグラフィック、デザイン、マンガ、ファッションの基礎。２年次から自分の適性にあった専門分野を選択。',
                'created_by' => '1',
                
            ],

            [                
                'school_cd' => '1',
                'majorsubject_cd' => '2',
                'majorsubject_name' => 'デザイン専攻科→デジタルデザイン分野',  
                'studyperiod' => '24', 
                'remarks' => '入学から専門分野の学習が始まる。',
                'created_by' => '1',
                
            ],

            [                
                'school_cd' => '1',
                'majorsubject_cd' => '3',
                'majorsubject_name' => 'デザインマスターズ科',  
                'studyperiod' => '12', 
                'remarks' => '全てのデザイン科目を学習するため、カメラに興味あって学習している生徒がいる可能性あり。',
                'created_by' => '1',
                
            ],

            [                
                'school_cd' => '2',
                'majorsubject_cd' => '1',
                'majorsubject_name' => '写真デザイン科（2年）',  
                'studyperiod' => '24', 
                'remarks' => '昼間部（通学制）と「通信部」の2コースがある。HPを見た感じ写真に特化しているのがわかる。',
                'created_by' => '1',
                
            ],

            [                
                'school_cd' => '2',
                'majorsubject_cd' => '2',
                'majorsubject_name' => '写真デザイン科（半年）',  
                'studyperiod' => '6', 
                'remarks' => '昼間部（通学制）と「通信部」の2コースがある。HPを見た感じ写真に特化しているのがわかる。',
                'created_by' => '1',
                
            ],

            [                
                'school_cd' => '3',
                'majorsubject_cd' => '1',
                'majorsubject_name' => 'ブライダルリゾート科→フォトグラファー',  
                'studyperiod' => '24', 
                'remarks' => 'カメラの専門コースではなく、授業の一環でカメラの基礎を学習すると思われる。目指す職業でフォトグラファーがあるので、カメラマンを目指して入学する生徒もいる可能性あり。',
                'created_by' => '1',
                
            ],

            [                
                'school_cd' => '4',
                'majorsubject_cd' => '1',
                'majorsubject_name' => '映像コース',  
                'studyperiod' => '36', 
                'remarks' => '中学卒業後に進学できる学校。カメラも扱うと思うが、主に映像だと思われる。',
                'created_by' => '1',
                
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
                'created_by' => '1',
                
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
                'created_by' => '1',
                
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
                'created_by' => '1',
                
            ], 

        ]);     

        DB::table('member_password_t')->insert([
            
            [                
                'member_id' => '1',
                'mailaddress' => 'test1@test.com',
                'password' => common::encryption("1"),        
                'created_by' => '1',
                
            ],

            [                
                'member_id' => '2',
                'mailaddress' => 'test2@test.com',
                'password' => common::encryption("2"),        
                'created_by' => '1',
                
            ],   

            [                
                'member_id' => '3',
                'mailaddress' => 'test3@test.com',
                'password' => common::encryption("3"),  
                'created_by' => '1',
                
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
                'created_by' => '1',
                
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
                'created_by' => '1',
                
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
                'created_by' => '1',
                
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
                'created_by' => '1',
                
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
                'created_by' => '1',
                
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
                'created_by' => '1',
                
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
                'created_by' => '1',
                
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
                'created_by' => '1',
                
            ],
           
        ]);     


        DB::table('project_m')->insert([
            
            [   
                'project_id' => '1',
                'project_name' => 'PhotoProject',
                'remarks' => 'フォトプロジェクト',
                'created_by' => '1',
            ], 

            [                  
                'project_id' => '2',
                'project_name' => 'RecruitProject',
                'remarks' => 'リクルートプロジェクト',
                'created_by' => '1',
            ], 


        ]);   

    }
}
