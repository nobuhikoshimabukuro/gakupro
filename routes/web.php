<?php

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Route;

use App\Original\get_data;
use App\Original\create_list;

use App\Http\Controllers\headquarters\master\project_m_controller;
use App\Http\Controllers\headquarters\master\category_m_controller;
use App\Http\Controllers\headquarters\master\maincategory_m_controller;
use App\Http\Controllers\headquarters\master\subcategory_m_controller;
use App\Http\Controllers\headquarters\master\staff_m_controller;
use App\Http\Controllers\headquarters\master\staff_with_project_t_controller;
use App\Http\Controllers\headquarters\master\school_m_controller;
use App\Http\Controllers\headquarters\master\majorsubject_m_controller;
use App\Http\Controllers\headquarters\master\member_m_controller;
use App\Http\Controllers\headquarters\master\address_m_controller;
use App\Http\Controllers\headquarters\master\job_category_m_controller;
use App\Http\Controllers\headquarters\master\job_supplement_m_controller;
use App\Http\Controllers\headquarters\master\job_password_t_controller;
use App\Http\Controllers\headquarters\master\job_password_item_m_controller;
use App\Http\Controllers\headquarters\master\salary_category_m_controller;
use App\Http\Controllers\headquarters\master\employment_status_m_controller;

use App\Http\Controllers\hp\hp_controller;

use App\Http\Controllers\headquarters\headquarters_controller;
use App\Http\Controllers\photo_project\photo_project_controller;
use App\Http\Controllers\recruit_project\recruit_project_controller;

use App\Http\Controllers\member\member_controller;



//website  Start

Route::get('/', [hp_controller::class, 'index'])->name('hp.index');
Route::get('job_information_detail', [hp_controller::class, 'job_information_detail'])->name('hp.job_information_detail');
Route::get('job_information', [hp_controller::class, 'job_information'])->name('hp.job_information');
Route::get('job_information_set_search_value', [hp_controller::class, 'job_information_set_search_value'])->name('hp.job_information_set_search_value');
Route::get('message_to_employers', [hp_controller::class, 'message_to_employers'])->name('hp.message_to_employers');
Route::get('message_to_students', [hp_controller::class, 'message_to_students'])->name('hp.message_to_students');

Route::get('get_job_count', [hp_controller::class, 'get_job_count'])->name('hp.get_job_count');

Route::post('pseudo_job_information', [hp_controller::class, 'pseudo_job_information'])->name('hp.pseudo_job_information');



//website  End




Route::get('headquarters/test', [headquarters_controller::class, 'test'])->name('headquarters.test');
Route::get('headquarters/test1', [headquarters_controller::class, 'test1'])->name('headquarters.test1');
Route::get('headquarters/test2', [headquarters_controller::class, 'test2'])->name('headquarters.test2');


Route::post('headquarters/pdf_test', [headquarters_controller::class, 'pdf_test'])->name('headquarters.pdf_test');


//本部  Start

Route::get('headquarters/phpinfo', [headquarters_controller::class, 'phpinfo'])->name('headquarters.phpinfo');

Route::get('headquarters/top', [headquarters_controller::class, 'index'])->name('headquarters.index');
Route::get('headquarters/login', [headquarters_controller::class, 'login'])->name('headquarters.login');
Route::get('headquarters/logout', [headquarters_controller::class, 'logout'])->name('headquarters.logout');
Route::post('headquarters/login_password_check', [headquarters_controller::class, 'login_password_check'])->name('headquarters.login_password_check');


Route::get('headquarters/master', [headquarters_controller::class, 'master_index'])->name('master.index');
Route::get('headquarters/recruit_project', [headquarters_controller::class, 'recruit_project_index'])->name('recruit_project.index');
Route::get('headquarters/photo_project', [headquarters_controller::class, 'photo_project_index'])->name('photo_project.index');
Route::get('headquarters/member', [headquarters_controller::class, 'member_index'])->name('member.index');



//大分類/中分類マスタ
Route::get('headquarters/master/category/', [category_m_controller::class, 'index'])->name('master.category');
Route::post('headquarters/master/category/maincategory_save', [category_m_controller::class, 'maincategory_save'])->name('master.maincategory.save');
Route::post('headquarters/master/category/maincategory_delete_or_restore', [category_m_controller::class, 'maincategory_delete_or_restore'])->name('master.maincategory.delete_or_restore');
Route::post('headquarters/master/category/subcategory_save', [category_m_controller::class, 'subcategory_save'])->name('master.subcategory.save');
Route::post('headquarters/master/category/subcategory_delete_or_restore', [category_m_controller::class, 'subcategory_delete_or_restore'])->name('master.subcategory.delete_or_restore');

//住所マスタ
Route::get('headquarters/master/address/', [address_m_controller::class, 'index'])->name('master.address');
Route::post('headquarters/master/address/save', [address_m_controller::class, 'save'])->name('master.address.save');

//雇用形態マスタ
Route::get('headquarters/master/employment_status/index', [employment_status_m_controller::class, 'index'])->name('master.employment_status');
Route::post('headquarters/master/employment_status/save', [employment_status_m_controller::class, 'save'])->name('master.employment_status.save');
Route::post('headquarters/master/employment_status/delete_or_restore', [employment_status_m_controller::class, 'delete_or_restore'])->name('master.employment_status.delete_or_restore');

//求人補足マスタ
Route::get('headquarters/master/job_supplement/', [job_supplement_m_controller::class, 'index'])->name('master.job_supplement');
Route::post('headquarters/master/job_supplement/job_supplement_maincategory_save', [job_supplement_m_controller::class, 'job_supplement_maincategory_save'])->name('master.job_supplement_maincategory.save');
Route::post('headquarters/master/job_supplement/job_supplement_maincategory_delete_or_restore', [job_supplement_m_controller::class, 'job_supplement_maincategory_delete_or_restore'])->name('master.job_supplement_maincategory.delete_or_restore');
Route::post('headquarters/master/job_supplement/job_supplement_subcategory_save', [job_supplement_m_controller::class, 'job_supplement_subcategory_save'])->name('master.job_supplement_subcategory.save');
Route::post('headquarters/master/job_supplement/job_supplement_subcategory_delete_or_restore', [job_supplement_m_controller::class, 'job_supplement_subcategory_delete_or_restore'])->name('master.job_supplement_subcategory.delete_or_restore');

//職種マスタ
Route::get('headquarters/master/job_category/', [job_category_m_controller::class, 'index'])->name('master.job_category');
Route::post('headquarters/master/job_category/job_maincategory_save', [job_category_m_controller::class, 'job_maincategory_save'])->name('master.job_maincategory.save');
Route::post('headquarters/master/job_category/job_maincategory_delete_or_restore', [job_category_m_controller::class, 'job_maincategory_delete_or_restore'])->name('master.job_maincategory.delete_or_restore');
Route::post('headquarters/master/job_category/job_subcategory_save', [job_category_m_controller::class, 'job_subcategory_save'])->name('master.job_subcategory.save');
Route::post('headquarters/master/job_category/job_subcategory_delete_or_restore', [job_category_m_controller::class, 'job_subcategory_delete_or_restore'])->name('master.job_subcategory.delete_or_restore');

//給与マスタ
Route::get('headquarters/master/salary_category/', [salary_category_m_controller::class, 'index'])->name('master.salary_category');
Route::post('headquarters/master/salary_category/salary_maincategory_save', [salary_category_m_controller::class, 'salary_maincategory_save'])->name('master.salary_maincategory.save');
Route::post('headquarters/master/salary_category/salary_maincategory_delete_or_restore', [salary_category_m_controller::class, 'salary_maincategory_delete_or_restore'])->name('master.salary_maincategory.delete_or_restore');
Route::post('headquarters/master/salary_category/salary_subcategory_save', [salary_category_m_controller::class, 'salary_subcategory_save'])->name('master.salary_subcategory.save');
Route::post('headquarters/master/salary_category/salary_subcategory_delete_or_restore', [salary_category_m_controller::class, 'salary_subcategory_delete_or_restore'])->name('master.salary_subcategory.delete_or_restore');

//求人公開パスワードテーブル
Route::get('headquarters/master/job_password/', [job_password_t_controller::class, 'index'])->name('master.job_password');
Route::post('headquarters/master/job_password/save', [job_password_t_controller::class, 'save'])->name('master.job_password.save');
Route::post('headquarters/master/job_password/sale_flg_change', [job_password_t_controller::class, 'sale_flg_change'])->name('master.job_password.sale_flg_change');

//求人パスワード商品マスタ
Route::get('headquarters/master/job_password_item/', [job_password_item_m_controller::class, 'index'])->name('master.job_password_item');
Route::post('headquarters/master/job_password_item/save', [job_password_item_m_controller::class, 'save'])->name('master.job_password_item.save');
Route::post('headquarters/master/job_password_item/delete_or_restore', [job_password_item_m_controller::class, 'delete_or_restore'])->name('master.job_password_item.delete_or_restore');

//プロジェクトマスタ
Route::get('headquarters/master/project/', [project_m_controller::class, 'index'])->name('master.project');
Route::post('headquarters/master/project/save', [project_m_controller::class, 'save'])->name('master.project.save');
Route::post('headquarters/master/project/delete_or_restore', [project_m_controller::class, 'delete_or_restore'])->name('master.project.delete_or_restore');

//スタッフマスタ
Route::get('headquarters/master/staff/', [staff_m_controller::class, 'index'])->name('master.staff');
Route::post('headquarters/master/staff/save', [staff_m_controller::class, 'save'])->name('master.staff.save');
Route::post('headquarters/master/staff/delete_or_restore', [staff_m_controller::class, 'delete_or_restore'])->name('master.staff.delete_or_restore');
Route::get('headquarters/master/staff/login_info_check', [staff_m_controller::class, 'login_info_check'])->name('master.staff.login_info_check');
Route::post('headquarters/master/staff/login_info_update', [staff_m_controller::class, 'login_info_update'])->name('master.staff.login_info_update');
Route::get('headquarters/master/staff/project_info_get', [staff_m_controller::class, 'project_info_get'])->name('master.staff.project_info_get');
Route::post('headquarters/master/staff/project_info_update', [staff_m_controller::class, 'project_info_update'])->name('master.staff.project_info_update');
Route::get('headquarters/master/staff/staff_with_project', [staff_with_project_t_controller::class, 'index'])->name('master.staff_with_project');
Route::post('headquarters/master/staff/staff_with_project/save', [staff_with_project_t_controller::class, 'save'])->name('master.staff_with_project.save');

//学校マスタ
Route::get('headquarters/master/school/', [school_m_controller::class, 'index'])->name('master.school');
Route::post('headquarters/master/school/save', [school_m_controller::class, 'save'])->name('master.school.save');
Route::post('headquarters/master/school/delete_or_restore', [school_m_controller::class, 'delete_or_restore'])->name('master.school.delete_or_restore');

//専攻マスタ
Route::get('headquarters/master/majorsubject/index', [majorsubject_m_controller::class, 'index'])->name('master.majorsubject');
Route::post('headquarters/master/majorsubject/save', [majorsubject_m_controller::class, 'save'])->name('master.majorsubject.save');
Route::post('headquarters/master/majorsubject/delete_or_restore', [majorsubject_m_controller::class, 'delete_or_restore'])->name('master.majorsubject.delete_or_restore');

//メンバーマスタ
Route::get('headquarters/master/member/', [member_m_controller::class, 'index'])->name('master.member');
Route::post('headquarters/master/member/save', [member_m_controller::class, 'save'])->name('master.member.save');
Route::post('headquarters/master/member/delete_or_restore', [member_m_controller::class, 'delete_or_restore'])->name('master.member.delete_or_restore');
Route::get('headquarters/master/member/login_info_check', [member_m_controller::class, 'login_info_check'])->name('master.member.login_info_check');
Route::post('headquarters/master/member/login_info_update', [member_m_controller::class, 'login_info_update'])->name('master.member.login_info_update');



//データ取得関連
Route::get('get_data/school_list_get', [get_data::class, 'school_list_get'])->name('get_data.school_list_get');
Route::get('get_data/majorsubject_list_get', [get_data::class, 'majorsubject_list_get'])->name('get_data.majorsubject_list_get');
Route::get('get_data/school_info_get', [get_data::class, 'school_info_get'])->name('get_data.school_info_get');
Route::get('get_data/majorsubject_info_get', [get_data::class, 'majorsubject_info_get'])->name('get_data.majorsubject_info_get');

Route::get('create_list/municipality_list_ajax', [create_list::class, 'municipality_list_ajax'])->name('create_list.municipality_list_ajax');
Route::get('create_list/salary_sabcategory_list_ajax', [create_list::class, 'salary_sabcategory_list_ajax'])->name('create_list.salary_sabcategory_list_ajax');

//本部  End




//メンバー  Start








Route::get('member/top', [member_controller::class, 'top'])->name('member.top');
Route::get('member/login', [member_controller::class, 'login'])->name('member.login');
Route::get('member/logout', [member_controller::class, 'logout'])->name('member.logout');
Route::post('member/login_password_check', [member_controller::class, 'login_password_check'])->name('member.login_password_check');

Route::get('member/mailaddress_temporary_registration', [member_controller::class, 'mailaddress_temporary_registration'])->name('member.mailaddress_temporary_registration');
Route::post('member/mailaddress_temporary_registration_process', [member_controller::class, 'mailaddress_temporary_registration_process'])->name('member.mailaddress_temporary_registration_process');

Route::get('member/mailaddress_approval', [member_controller::class, 'mailaddress_approval'])->name('member.mailaddress_approval');
Route::post('member/mailaddress_approval_check', [member_controller::class, 'mailaddress_approval_check'])->name('member.mailaddress_approval_check');

// Route::get('member/member_information_confirmation', [member_controller::class, 'member_information_confirmation'])->name('member.member_information_confirmation');

Route::get('member/information_register', [member_controller::class, 'information_register'])->name('member.information_register');
Route::post('member/information_save', [member_controller::class, 'information_save'])->name('member.information_save');
// Route::post('member/member_information_update', [member_controller::class, 'member_information_update'])->name('member.member_information_update');

// Route::get('member/member_information_after_registration', [member_controller::class, 'member_information_after_registration'])->name('member.member_information_after_registration');


//メンバー  End


//写真プロジェクト  Start
Route::get('photo_project/info', [photo_project_controller::class, 'info'])->name('photo_project.info');

Route::get('photo_project/password_entry', [photo_project_controller::class, 'password_entry'])->name('photo_project.password_entry');
Route::post('photo_project/password_check', [photo_project_controller::class, 'password_check'])->name('photo_project.password_check');

Route::get('photo_project/photo_upload', [photo_project_controller::class, 'photo_upload'])->name('photo_project.photo_upload');
Route::post('photo_project/photo_upload_execution', [photo_project_controller::class, 'photo_upload_execution'])->name('photo_project.photo_upload_execution');

Route::get('photo_project/create_qrcode', [photo_project_controller::class, 'create_qrcode'])->name('photo_project.create_qrcode');
Route::post('photo_project/create_qrcode_execution', [photo_project_controller::class, 'create_qrcode_execution'])->name('photo_project.create_qrcode_execution');
Route::get('photo_project/qrcode_download', [photo_project_controller::class, 'qrcode_download'])->name('photo_project.qrcode_download');

Route::post('photo_project/photo_confirmation', [photo_project_controller::class, 'photo_confirmation'])->name('photo_project.photo_confirmation');
Route::get('photo_project/photo_confirmation', [photo_project_controller::class, 'qr_announce_transition'])->name('photo_project.qr_announce_transition');

Route::post('photo_project/with_password_flg_change', [photo_project_controller::class, 'with_password_flg_change'])->name('photo_project.with_password_flg_change');

Route::post('photo_project/batch_download', [photo_project_controller::class, 'batch_download'])->name('photo_project.batch_download');
//写真プロジェクト  End




//リクルートプロジェクト  Start
Route::get('recruit_project/mailaddress_temporary_registration', [recruit_project_controller::class, 'mailaddress_temporary_registration'])->name('recruit_project.mailaddress_temporary_registration');
Route::post('recruit_project/mailaddress_temporary_registration_process', [recruit_project_controller::class, 'mailaddress_temporary_registration_process'])->name('recruit_project.mailaddress_temporary_registration_process');

Route::get('recruit_project/mailaddress_approval', [recruit_project_controller::class, 'mailaddress_approval'])->name('recruit_project.mailaddress_approval');
Route::post('recruit_project/mailaddress_approval_check', [recruit_project_controller::class, 'mailaddress_approval_check'])->name('recruit_project.mailaddress_approval_check');

Route::get('recruit_project/login', [recruit_project_controller::class, 'login'])->name('recruit_project.login');
Route::get('recruit_project/logout', [recruit_project_controller::class, 'logout'])->name('recruit_project.logout');

Route::post('recruit_project/login_password_check', [recruit_project_controller::class, 'login_password_check'])->name('recruit_project.login_password_check');

Route::get('recruit_project/top', [recruit_project_controller::class, 'top'])->name('recruit_project.top');

Route::get('recruit_project/information_confirmation', [recruit_project_controller::class, 'information_confirmation'])->name('recruit_project.information_confirmation');

Route::get('recruit_project/information_register_insert', [recruit_project_controller::class, 'information_register_insert'])->name('recruit_project.information_register_insert');
Route::get('recruit_project/information_register_update', [recruit_project_controller::class, 'information_register_update'])->name('recruit_project.information_register_update');

Route::post('recruit_project/information_save', [recruit_project_controller::class, 'information_save'])->name('recruit_project.information_save');
Route::post('recruit_project/information_update', [recruit_project_controller::class, 'information_update'])->name('recruit_project.information_update');

Route::get('recruit_project/information_after_registration', [recruit_project_controller::class, 'information_after_registration'])->name('recruit_project.information_after_registration');

Route::post('recruit_project/job_information_publish_flg_change', [recruit_project_controller::class, 'job_information_publish_flg_change'])->name('recruit_project.job_information_publish_flg_change');

Route::get('recruit_project/job_publish_info', [recruit_project_controller::class, 'job_publish_info'])->name('recruit_project.job_publish_info');
Route::get('recruit_project/job_password_check', [recruit_project_controller::class, 'job_password_check'])->name('recruit_project.job_password_check');
Route::get('recruit_project/job_password_date_setting', [recruit_project_controller::class, 'job_password_date_setting'])->name('recruit_project.job_password_date_setting');
Route::post('recruit_project/job_publish_confirmation_process', [recruit_project_controller::class, 'job_publish_confirmation_process'])->name('recruit_project.job_publish_confirmation_process');


Route::get('recruit_project/job_information_confirmation', [recruit_project_controller::class, 'job_information_confirmation'])->name('recruit_project.job_information_confirmation');
Route::get('recruit_project/job_information_register', [recruit_project_controller::class, 'job_information_register'])->name('recruit_project.job_information_register');

Route::post('recruit_project/job_information_save', [recruit_project_controller::class, 'job_information_save'])->name('recruit_project.job_information_save');


Route::match(['get', 'post'], 'recruit_project/job_information_ledger', [recruit_project_controller::class, 'job_information_ledger'])->name('recruit_project.job_information_ledger');

//リクルートプロジェクト  End



