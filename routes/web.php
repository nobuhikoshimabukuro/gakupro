<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\topmenu_controller;
use App\Http\Controllers\Master\mailaddresscheck_t_controller;
use App\Http\Controllers\Master\maincategory_m_controller;
use App\Http\Controllers\Master\subcategory_m_controller;
use App\Http\Controllers\Master\majorsubject_m_controller;
use App\Http\Controllers\Master\member_m_controller;
use App\Http\Controllers\Master\school_m_controller;
use App\Http\Controllers\Master\staff_m_controller;

use App\Http\Controllers\photoproject_controller;
use App\Http\Controllers\recruitproject_controller;








Route::get('/', [topmenu_controller::class, 'index'])->name('headquarters.index');

Route::get('master', [topmenu_controller::class, 'master_index'])->name('master.index');
// Route::get('photoproject', [topmenu_controller::class, 'photoproject_index'])->name('photoproject.index');



Route::get('master/maincategory/', [maincategory_m_controller::class, 'index'])->name('master.maincategory');
Route::post('master/maincategory/save', [maincategory_m_controller::class, 'save'])->name('master.maincategory.save');
Route::post('master/maincategory/delete', [maincategory_m_controller::class, 'delete'])->name('master.maincategory.delete');
Route::post('master/maincategory/restore', [maincategory_m_controller::class, 'restore'])->name('master.maincategory.restore');

Route::get('master/subcategory/', [subcategory_m_controller::class, 'index'])->name('master.subcategory');
Route::post('master/subcategory/save', [subcategory_m_controller::class, 'save'])->name('master.subcategory.save');
Route::post('master/subcategory/delete', [subcategory_m_controller::class, 'delete'])->name('master.subcategory.delete');
Route::post('master/subcategory/restore', [subcategory_m_controller::class, 'restore'])->name('master.subcategory.restore');

Route::get('master/school/', [school_m_controller::class, 'index'])->name('master.school');
Route::post('master/school/save', [school_m_controller::class, 'save'])->name('master.school.save');
Route::post('master/school/delete', [school_m_controller::class, 'delete'])->name('master.school.delete');
Route::post('master/school/restore', [school_m_controller::class, 'restore'])->name('master.school.restore');

//写真プロジェクト  Start

Route::get('photoproject/photoproject_index', [photoproject_controller::class, 'photoproject_index'])->name('photoproject.index');
Route::get('photoproject/info', [photoproject_controller::class, 'info'])->name('photoproject.info');

Route::get('photoproject/password_entry', [photoproject_controller::class, 'password_entry'])->name('photoproject.password_entry');

Route::get('photoproject/photo_upload', [photoproject_controller::class, 'photo_upload'])->name('photoproject.photo_upload');
Route::post('photoproject/photo_upload_execution', [photoproject_controller::class, 'photo_upload_execution'])->name('photoproject.photo_upload_execution');

Route::get('photoproject/create_qrcode', [photoproject_controller::class, 'create_qrcode'])->name('photoproject.create_qrcode');
Route::post('photoproject/create_qrcode_execution', [photoproject_controller::class, 'create_qrcode_execution'])->name('photoproject.create_qrcode_execution');
Route::get('photoproject/qrcode_download', [photoproject_controller::class, 'qrcode_download'])->name('photoproject.qrcode_download');


Route::post('photoproject/photo_confirmation', [photoproject_controller::class, 'photo_confirmation'])->name('photoproject.photo_confirmation');
Route::post('photoproject/batch_download', [photoproject_controller::class, 'batch_download'])->name('photoproject.batch_download');
//写真プロジェクト  End





Route::get('recruitproject/mailaddress_temporary_registration', [recruitproject_controller::class, 'mailaddress_temporary_registration'])->name('recruitproject.mailaddress_temporary_registration');
Route::post('recruitproject/mailaddress_temporary_registration_process', [recruitproject_controller::class, 'mailaddress_temporary_registration_process'])->name('recruitproject.mailaddress_temporary_registration_process');

Route::get('recruitproject/mailaddress_approval', [recruitproject_controller::class, 'mailaddress_approval'])->name('recruitproject.mailaddress_approval');
Route::post('recruitproject/mailaddress_approval_check', [recruitproject_controller::class, 'mailaddress_approval_check'])->name('recruitproject.mailaddress_approval_check');

Route::get('recruitproject', [recruitproject_controller::class, 'index'])->name('recruitproject.index');

Route::get('recruitproject/login', [recruitproject_controller::class, 'login'])->name('recruitproject.login');
Route::get('recruitproject/logout', [recruitproject_controller::class, 'logout'])->name('recruitproject.logout');

Route::post('recruitproject/login_password_check', [recruitproject_controller::class, 'login_password_check'])->name('recruitproject.login_password_check');



Route::get('recruitproject/employer_top', [recruitproject_controller::class, 'employer_top'])->name('recruitproject.employer_top');

Route::get('recruitproject/employer_information_confirmation', [recruitproject_controller::class, 'employer_information_confirmation'])->name('recruitproject.employer_information_confirmation');

Route::get('recruitproject/employer_information_register', [recruitproject_controller::class, 'employer_information_register'])->name('recruitproject.employer_information_register');
Route::post('recruitproject/employer_information_save', [recruitproject_controller::class, 'employer_information_save'])->name('recruitproject.employer_information_save');
Route::post('recruitproject/employer_information_update', [recruitproject_controller::class, 'employer_information_update'])->name('recruitproject.employer_information_update');

Route::get('recruitproject/employer_information_after_registration', [recruitproject_controller::class, 'employer_information_after_registration'])->name('recruitproject.employer_information_after_registration');


Route::get('recruitproject/job_information_confirmation', [recruitproject_controller::class, 'job_information_confirmation'])->name('recruitproject.job_information_confirmation');
Route::get('recruitproject/job_information_register', [recruitproject_controller::class, 'job_information_register'])->name('recruitproject.job_information_register');


Route::get('recruitproject/test2', [recruitproject_controller::class, 'test2'])->name('recruitproject.test2');

