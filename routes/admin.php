<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Report
    Route::get('/report/site', 'Report\ActivityController@index')->name('activity.index');
//Report Sale
    Route::get('/report/sale/job/package/email', 'Report\ReportSaleController@package_email')->name('report.sale.job.mail.index');
    Route::get('/report/sale/job/package/level', 'Report\ReportSaleController@package_level')->name('report.sale.job.level.index');
    Route::get('/report/sale/counseling/package', 'Report\ReportSaleController@package_counseling')->name('report.sale.counseling.package.index');
    Route::post('/report/sale/counseling/package/status/{id}', 'Report\ReportSaleController@package_counseling_status')->name('report.sale.counseling.package.status');

//Report Request
    Route::get('/report/request/entrepreneurship', 'Report\ReportRequestController@entrepreneurship')->name('report.request.entrepreneurship');
    Route::get('/report/request/entrepreneurship/project', 'Report\ReportRequestController@entrepreneurship_project')->name('report.request.entrepreneurship.project');
    Route::get('/report/request/job/work', 'Report\ReportRequestController@job_work')->name('report.request.job.work');
    Route::get('/report/request/job/work/status/{id}/{status}', 'Report\ReportRequestController@job_work_status')->name('report.request.job.work.status');

//Access
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/delete-file/{type}/{id}', 'HomeController@delete_file')->name('delete.file');
    Route::resource('permissionCat', Access\PermissionCatController::class);
    Route::resource('permission', Access\PermissionController::class);
    Route::resource('role', Access\RoleController::class);
//User
    Route::resource('user', User\UserController::class);
    Route::get('/user/job-fixer/list', 'User\JobFixerController@index')->name('user.job.fixer.list');

    Route::patch('/user/profile/update', [App\Http\Controllers\Admin\User\UserController::class, 'update_profile'])->name('user.profile.update-profile');
    Route::post('/user/profile/update-password', [App\Http\Controllers\Admin\User\UserController::class, 'update_password'])->name('user.profile.update-password');
    Route::post('/user/profile/update_jobFixer', [App\Http\Controllers\Admin\User\UserController::class, 'update_jobFixer'])->name('user.profile.update_jobFixer');

    Route::get('user-permission/{id}', 'User\UserController@permission')->name('user.permission');
    Route::post('user-permission/{id}/update', 'User\UserController@permission_update')->name('user.update.permission');
//profile
    Route::get('profile','User\UserController@profilePage')->name('profile');
//Agent-Agent
    Route::resource('agent', Agent\AgentController::class);
//Agent
    Route::resource('agent-level', Agent\LevelController::class);
    Route::post('agent-level/{id}/sort','Agent\LevelController@sort')->name('agent-level.sort');
    Route::resource('agent-package', Agent\PackageController::class);
//JobFixer
    Route::resource('job', JobFixer\JobController::class);
    Route::resource('job-work', JobFixer\JobWorkController::class);
    Route::resource('job-level-assessment', JobFixer\JobLevelAssessmentController::class);
    Route::post('job-level-assessment/{id}/sort', 'JobFixer\JobLevelAssessmentController@sort')->name('job-level-assessment.sort');
    Route::post('job-level-assessment/{id}/{type}/set-level', 'JobFixer\JobLevelAssessmentController@set_level')->name('job-level-assessment.set-level');
    Route::resource('job-level-package', JobFixer\JobLevelPackageController::class);
    Route::resource('job-level-page', JobFixer\JobLevelPageController::class);

//JobFixer > Email

//send email
    Route::get('job-send-email/create','JobFixer\Email\JobSendEmailController@create')->name('job-send-email.create');

    Route::patch('job-send-email/send','JobFixer\Email\JobSendEmailController@send')->name('job-send-email.send');
//Route::get('job-send-email/create',[JobFixer\Email\JobSendEmailController::class,'create'])->name('job-send-email-create');


    Route::resource('job-email-package', JobFixer\Email\JobEmailPackageController::class);
    Route::post('job-email-package/{id}/sort', 'JobFixer\Email\JobEmailPackageController@sort')->name('job-email-package.sort');
    Route::get('job-email-package/{id}/{type}/vip', 'JobFixer\Email\JobEmailPackageController@vip_set')->name('job-email-package.vip');

//Entrepreneurship
    Route::resource('entrepreneurship-page', Entrepreneurship\EntrepreneurshipPageController::class);
    Route::resource('entrepreneurship-project', Entrepreneurship\EntrepreneurshipProjectController::class);
    Route::get('entrepreneurship-project/{id}/{type}/status', 'Entrepreneurship\EntrepreneurshipProjectController@status')->name('entrepreneurship-project.status');

//setting
    Route::resource('off-code', Setting\OffCodeController::class);
    Route::get('off-code/{id}/{type}/status', 'Setting\OffCodeController@status')->name('off-code.status');
    Route::resource('menu', Setting\MenuController::class);
    Route::resource('country', Setting\CountryController::class);
    Route::resource('country-code', Setting\CountryCodeController::class);
    Route::resource('education', Setting\EducationController::class);
    Route::post('education/{id}/sort', 'Setting\EducationController@sort')->name('education.sort');
    Route::resource('job-status', Setting\StatusJobController::class);
    Route::post('job-status/{id}/sort', 'Setting\StatusJobController@sort')->name('job-status.sort');
    Route::resource('marital', Setting\MaritalController::class);
    Route::post('marital/{id}/sort', 'Setting\MaritalController@sort')->name('marital.sort');
    Route::resource('list-lang', Setting\ListLangController::class);
    Route::post('list-lang/{id}/sort', 'Setting\ListLangController@sort')->name('list-lang.sort');
    Route::resource('introduction', Setting\IntroductionController::class);
    Route::post('introduction/{id}/sort', 'Setting\IntroductionController@sort')->name('introduction.sort');

    Route::get('setting/site/edit', [App\Http\Controllers\Admin\Setting\SiteController::class,'edit'])->name('setting.site.edit');
    Route::patch('setting/site/edit', [App\Http\Controllers\Admin\Setting\SiteController::class,'update'])->name('setting.site.update');

//property
    Route::resource('property-locale', Property\LocaleController::class);
    Route::resource('property', Property\PropertyController::class);
    Route::resource('property-project', Property\ProjectController::class);

//counseling
    Route::resource('counseling-cat', Counseling\CatController::class);
    Route::resource('counseling-package', Counseling\PackageController::class);




