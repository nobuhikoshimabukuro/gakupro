<?php

namespace App\Http\Controllers\Headquarters\Master;
use App\Http\Controllers\Controller;

use App\Models\staff_m_model;
use App\Models\subcategory_m_model;

use Illuminate\Http\Request;

class staff_m_controller extends Controller
{
    function index()
    {
        $gender_list = subcategory_m_model::select(
            'subcategory_cd as gender_cd',
            'subcategory_name as gender_name',
        )->where('maincategory_cd',1)
        ->orderBy('display_order', 'asc')
        ->get();

        $authority_list = subcategory_m_model::select(
            'subcategory_cd as authority_cd',
            'subcategory_name as authority_name',
        )->where('maincategory_cd',2)
        ->orderBy('display_order', 'asc')
        ->get();

        $staff_list = staff_m_model::select(

            'staff_m.staff_id as staff_id',
            'staff_m.staff_name as staff_name',
            'staff_m.staff_name_yomi as staff_name_yomi',
            'staff_m.nickname as nickname',

            'staff_m.gender as gender_cd',
            'genderinfo.subcategory_name as gender_name',

            'staff_m.tel as tel',
            'staff_m.mailaddress as mailaddress',

            'staff_m.authority as authority_cd',
            'authorityinfo.subcategory_name as authority_name',
       
        )
        ->leftJoin('subcategory_m as genderinfo', function ($join) {
            $join->on('genderinfo.subcategory_cd', '=', 'staff_m.gender')
                 ->where('genderinfo.maincategory_cd', '=', '1');
            ;
        })
        ->leftJoin('subcategory_m as authorityinfo', function ($join) {
            $join->on('authorityinfo.subcategory_cd', '=', 'staff_m.authority')
                ->where('authorityinfo.maincategory_cd', '=', '2');
            ;
        })       
        ->orderBy('staff_m.staff_id', 'asc')        
        ->get();

        
        return view('headquarters/screen/master/staff/index', compact('staff_list','gender_list','authority_list'));
    }
}
