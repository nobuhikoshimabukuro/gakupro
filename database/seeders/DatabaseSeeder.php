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
                'maincategory_name' => '学校区分',
                'created_by' => '9999',
                'updated_by' => '9999',
            ],
        ]);     

        DB::table('subcategory_m')->insert([

            //
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
        ]);     

    }
}
