<?php


namespace App\Http\Controllers\Headquarters\Master;
use App\Http\Controllers\Controller;

use App\Models\member_m_model;
use App\Models\staff_password_t_model;
use App\Models\subcategory_m_model;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Original\Common;
use App\Repositories\GenderList;
use App\Repositories\AuthorityList;
use Illuminate\Support\Facades\DB;

class member_m_controller extends Controller
{
    function index(Request $request)
    {
        $gender_list = GenderList::get();

        $authority_list = AuthorityList::get();      

        $operator_authority = session()->get('authority');

        $staff_list = member_m_model::select(

            'member_m.staff_id as staff_id',
            'member_m.staff_name as staff_name',
            'member_m.staff_name_yomi as staff_name_yomi',
            'member_m.nick_name as nick_name',

            'member_m.gender as gender',
            'genderinfo.subcategory_name as gender_name',

            'member_m.tel as tel',
            'member_m.mailaddress as mailaddress',

            'member_m.authority as authority',
            'authorityinfo.subcategory_name as authority_name',
       
            'member_m.deleted_at as deleted_at',

            'staff_password_t.id as password_id',
            'staff_password_t.login_id as login_id',
            'staff_password_t.password as encrypted_password',
        )
        ->leftJoin('subcategory_m as genderinfo', function ($join) {
            $join->on('genderinfo.subcategory_cd', '=', 'member_m.gender')
                 ->where('genderinfo.maincategory_cd', '=', '1');
            ;
        })
        ->leftJoin('subcategory_m as authorityinfo', function ($join) {
            $join->on('authorityinfo.subcategory_cd', '=', 'member_m.authority')
                ->where('authorityinfo.maincategory_cd', '=', '2');
            ;
        })     
        ->leftJoin('staff_password_t', function ($join) {
            $join->on('staff_password_t.staff_id', '=', 'member_m.staff_id')
                ->whereNull('staff_password_t.deleted_at');
            ;
        })       
        ->withTrashed()
        ->orderBy('member_m.staff_id', 'asc')        
        ->paginate(env('Paginate_Count'));


        foreach($staff_list as $info){

            //DBに登録されている暗号化したパスワードを平文に変更し再格納
            $encrypted_password = $info->encrypted_password;              
            $info->password = Common::decryption($info->encrypted_password);
        }
        
        return view('headquarters/screen/master/staff/index', compact('staff_list','gender_list','authority_list','operator_authority'));
    }
}
