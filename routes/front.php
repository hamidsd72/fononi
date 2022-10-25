<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 
//index
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/off-code-check', 'HomeController@off_code_check')->name('off.code.check');

//email packages لیست پکیج های ایمیل
Route::get('packages/email', 'Package\EmailController@index')->name('packages.email');
Route::post('packages/email/store', 'Package\EmailController@store')->name('packages.email.store');
Route::post('/packages/email/{packageId}/check-discount-code', 'Package\EmailController@checkDiscountCode')->name('packages.email.check-discount-code');

//job fixer  جاب فیکسر
Route::get('job-fixer/level', 'JobFixer\JobFixerController@level')->name('job-offer.level');
Route::post('job-fixer/level/store', 'JobFixer\JobFixerController@store')->name('job-offer.level.store');
Route::get('job-fixer/level/package', 'JobFixer\JobFixerController@package')->name('job-offer.level.package');
Route::get('job-fixer/level/package/show/{id}', 'JobFixer\JobFixerController@package_show')->name('job-offer.level.package.show');
Route::post('job-fixer/level/package/sale/{id}', 'JobFixer\JobFixerController@package_sale')->name('job-offer.level.package.sale');
Route::get('job-fixer/level/package/{id}/video/download', 'JobFixer\JobFixerController@video_download')->name('job-offer.level.package.video.download');

//job list لیست شغل ها
Route::get('job-fixer/job-list', 'JobFixer\JobListController@index')->name('job-list');
Route::get('job-fixer/job-list/{id}/request', 'JobFixer\JobListController@job_request')->name('job-list.request');

//entrepreneurship کارآفرینی
Route::get('entrepreneurship', 'EntrepreneurshipController@index')->name('entrepreneurship.show');
Route::post('entrepreneurship/store', 'EntrepreneurshipController@store')->name('entrepreneurship.store');
Route::get('entrepreneurship/project/request/{id}', 'EntrepreneurshipController@project_request')->name('entrepreneurship.project.request');

//project پروژه املاک
Route::get('property-project/list', 'Property\ProjectController@index')->name('property.project.list');
Route::get('property-project/show/{id}', 'Property\ProjectController@show')->name('property.project.show');

//counseling مشاوره
Route::get('counseling', 'CounselingController@index')->name('counseling.show');
Route::post('counseling/store/{id}', 'CounselingController@store')->name('counseling.store');
Route::get('counseling/date/check/{id}', 'CounselingController@date_check')->name('counseling.date.check');
 
//agent نمایندگی
Route::get('agent-register', 'Agent\AgentRegisterController@index')->name('agent.register.show');
Route::post('agent-register/store', 'Agent\AgentRegisterController@store')->name('agent.register.store');