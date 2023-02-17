<?php

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Route;

use App\Original\get_data;

use App\Http\Controllers\headquarters\master\project_m_controller;
use App\Http\Controllers\headquarters\master\maincategory_m_controller;
use App\Http\Controllers\headquarters\master\subcategory_m_controller;
use App\Http\Controllers\headquarters\master\staff_m_controller;
use App\Http\Controllers\headquarters\master\staff_with_project_t_controller;
use App\Http\Controllers\headquarters\master\school_m_controller;
use App\Http\Controllers\headquarters\master\majorsubject_m_controller;
use App\Http\Controllers\headquarters\master\member_m_controller;

use App\Http\Controllers\HP\hp_controller;

use App\Http\Controllers\headquarters\headquarters_controller;
use App\Http\Controllers\photo_project\photo_project_controller;
use App\Http\Controllers\recruit_project\recruit_project_controller;

use App\Http\Controllers\member\member_controller;





Route::get('/', [hp_controller::class, 'index'])->name('hp.index');





Route::get('headquarters/test', [headquarters_controller::class, 'test'])->name('headquarters.test');
Route::get('headquarters/test1', [headquarters_controller::class, 'test1'])->name('headquarters.test1');


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

Route::get('headquarters/master/project/', [project_m_controller::class, 'index'])->name('master.project');
Route::post('headquarters/master/project/save', [project_m_controller::class, 'save'])->name('master.project.save');
Route::post('headquarters/master/project/delete_or_restore', [project_m_controller::class, 'delete_or_restore'])->name('master.project.delete_or_restore');

Route::get('headquarters/master/maincategory/', [maincategory_m_controller::class, 'index'])->name('master.maincategory');
Route::post('headquarters/master/maincategory/save', [maincategory_m_controller::class, 'save'])->name('master.maincategory.save');
Route::post('headquarters/master/maincategory/delete_or_restore', [maincategory_m_controller::class, 'delete_or_restore'])->name('master.maincategory.delete_or_restore');

Route::post('headquarters/master/maincategory/delete', [maincategory_m_controller::class, 'delete'])->name('master.maincategory.delete');
Route::post('headquarters/master/maincategory/restore', [maincategory_m_controller::class, 'restore'])->name('master.maincategory.restore');

Route::get('headquarters/master/subcategory/', [subcategory_m_controller::class, 'index'])->name('master.subcategory');
Route::post('headquarters/master/subcategory/save', [subcategory_m_controller::class, 'save'])->name('master.subcategory.save');
Route::post('headquarters/master/subcategory/delete_or_restore', [subcategory_m_controller::class, 'delete_or_restore'])->name('master.subcategory.delete_or_restore');

Route::get('headquarters/master/staff/', [staff_m_controller::class, 'index'])->name('master.staff');
Route::post('headquarters/master/staff/save', [staff_m_controller::class, 'save'])->name('master.staff.save');
Route::post('headquarters/master/staff/delete_or_restore', [staff_m_controller::class, 'delete_or_restore'])->name('master.staff.delete_or_restore');
Route::get('headquarters/master/staff/login_info_check', [staff_m_controller::class, 'login_info_check'])->name('master.staff.login_info_check');
Route::post('headquarters/master/staff/login_info_update', [staff_m_controller::class, 'login_info_update'])->name('master.staff.login_info_update');

Route::get('headquarters/master/staff/staff_with_project', [staff_with_project_t_controller::class, 'index'])->name('master.staff_with_project');
Route::post('headquarters/master/staff/staff_with_project/save', [staff_with_project_t_controller::class, 'save'])->name('master.staff_with_project.save');


Route::get('headquarters/master/school/', [school_m_controller::class, 'index'])->name('master.school');
Route::post('headquarters/master/school/save', [school_m_controller::class, 'save'])->name('master.school.save');
Route::post('headquarters/master/school/delete_or_restore', [school_m_controller::class, 'delete_or_restore'])->name('master.school.delete_or_restore');

Route::get('headquarters/master/majorsubject/index', [majorsubject_m_controller::class, 'index'])->name('master.majorsubject');
Route::post('headquarters/master/majorsubject/save', [majorsubject_m_controller::class, 'save'])->name('master.majorsubject.save');
Route::post('headquarters/master/majorsubject/delete_or_restore', [majorsubject_m_controller::class, 'delete_or_restore'])->name('master.majorsubject.delete_or_restore');


Route::get('headquarters/master/member/', [member_m_controller::class, 'index'])->name('master.member');
Route::post('headquarters/master/member/save', [member_m_controller::class, 'save'])->name('master.member.save');
Route::post('headquarters/master/member/delete_or_restore', [member_m_controller::class, 'delete_or_restore'])->name('master.member.delete_or_restore');
Route::get('headquarters/master/member/login_info_check', [member_m_controller::class, 'login_info_check'])->name('master.member.login_info_check');
Route::post('headquarters/master/member/login_info_update', [member_m_controller::class, 'login_info_update'])->name('master.member.login_info_update');




Route::get('headquarters/get_data/school_list_get', [get_data::class, 'school_list_get'])->name('get_data.school_list_get');
Route::get('headquarters/get_data/majorsubject_list_get', [get_data::class, 'majorsubject_list_get'])->name('get_data.majorsubject_list_get');
Route::get('headquarters/get_data/school_info_get', [get_data::class, 'school_info_get'])->name('get_data.school_info_get');
Route::get('headquarters/get_data/majorsubject_info_get', [get_data::class, 'majorsubject_info_get'])->name('get_data.majorsubject_info_get');

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

Route::get('recruit_project/information_register', [recruit_project_controller::class, 'information_register'])->name('recruit_project.information_register');
Route::post('recruit_project/information_save', [recruit_project_controller::class, 'information_save'])->name('recruit_project.information_save');
Route::post('recruit_project/information_update', [recruit_project_controller::class, 'information_update'])->name('recruit_project.information_update');

Route::get('recruit_project/information_after_registration', [recruit_project_controller::class, 'information_after_registration'])->name('recruit_project.information_after_registration');


Route::get('recruit_project/job_information_confirmation', [recruit_project_controller::class, 'job_information_confirmation'])->name('recruit_project.job_information_confirmation');
Route::get('recruit_project/job_information_register', [recruit_project_controller::class, 'job_information_register'])->name('recruit_project.job_information_register');
//リクルートプロジェクト  End



