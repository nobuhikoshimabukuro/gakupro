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
                'subcategory_name' => '短期大学',
                'display_order' => 4,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],
            [
                'maincategory_cd' => 3,
                'subcategory_cd' => 5,
                'subcategory_name' => '大学',
                'display_order' => 5,
                'created_by' => '9999',
                'updated_by' => '9999',
            ],


        ]);     


        DB::table('staff_m')->insert([
            
            [                
                'staff_name' => '島袋　信彦',
                'staff_name_yomi' => 'シマブクロ　ノブヒコ',
                'nickname' => 'のぶっち',
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
                'nickname' => 'ゆううゆうう',
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

    }
}
