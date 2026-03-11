<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Employee\Http\Controllers\PayrollController;
use Modules\Setting\Http\Controllers\CompanyProfileController;
use Modules\Setting\Http\Controllers\PopUpController;
use Modules\Setting\Http\Controllers\CounterController;
use Modules\Setting\Http\Controllers\AVideoController;


Route::prefix('setting')->group(function () {
    Route::get('/', 'SettingController@index');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('company', 'CompanyProfileController');
    Route::get('why/us', [CompanyProfileController::class, 'whyUs'])->name('whyus.index');
    Route::get('/features', [CompanyProfileController::class, 'features'])->name('features');
    Route::get('/plans', [CompanyProfileController::class, 'plans'])->name('plans');
    Route::get('/askedQuestions', [CompanyProfileController::class, 'askedQuestions'])->name('askedQuestions');
    Route::get('/customerSays', [CompanyProfileController::class, 'customerSays'])->name('customerSays');
    Route::get('/Interface', [CompanyProfileController::class, 'Interface'])->name('Interface');
    Route::get('/Videos', [CompanyProfileController::class, 'Video'])->name('Video');
    // Route::get('/videos', [VideosssController::class, 'Video'])->name('Video');
    Route::get('setsalary', [PayrollController::class, 'index'])->name('setsalary.index');
    Route::get('payslip', [PayrollController::class, 'payslip'])->name('setsalary.payslip.index');
    Route::get('/payslip/fetch', [PayrollController::class, 'fetchPayslip'])->name('payslip.fetch');
    Route::post('/payslip/markAsPaid', [PayrollController::class, 'markAsPaid'])->name('payslip.markAsPaid');
    Route::post('payslip/store', [PayrollController::class, 'payslipStore'])->name('payslip.store');
    Route::post('/payslip/delete', [PayrollController::class, 'deletePayslip'])->name('payslip.delete');
    route::get('/payslip/view', [PayrollController::class, 'viewPayslip'])->name('payslip.view');
    Route::post('employee-salary/store', [PayrollController::class, 'StoreEmployeeSalary'])->name('employeesalary.store');
    Route::put('employee-salary/update', [PayrollController::class, 'updateEmployeeSalary'])->name('employeesalary.update');
    Route::get('employee/details/{id}', [PayrollController::class, 'show'])->name('employee.details');
    Route::post('employee-allowance/store', [PayrollController::class, 'StoreEmployeeAllowance'])->name('employeeallowance.store');
    Route::get('employee-allowance/delete/{id}', [PayrollController::class, 'DeleteEmployeeAllowance'])->name('employeeallowance.delete');
    Route::put('employee-allowance/update/{id}', [PayrollController::class, 'updateEmployeeAllowance'])->name('employeeallowance.update');
    //employee insentive
    Route::post('employee-insentive/store', [PayrollController::class, 'storeEmployeeInsentive'])->name('employeeinsentive.store');
    Route::get('employee-insentive/delete/{id}', [PayrollController::class, 'deleteEmployeeinsentive'])->name('employeeinsentive.delete');
    Route::put('employee-insentive/update/{id}', [PayrollController::class, 'updateEmployeeinsentive'])->name('employeeinsentive.update');

    //employee advanced pay
    Route::post('employee-advancedpay/store', [PayrollController::class, 'storeEmployeeadvancedpay'])->name('employeeadvancedpay.store');
    Route::get('employee-advancedpay/delete/{id}', [PayrollController::class, 'deleteEmployeeadvancedpay'])->name('employeeadvancedpay.delete');
    Route::put('employee-advancedpay/update/{id}', [PayrollController::class, 'updateEmployeeadvancedpay'])->name('employeeadvancedpay.update');
    //employee fund
    Route::post('employee-fund/store', [PayrollController::class, 'storeEmployeefund'])->name('employeefund.store');
    Route::get('employee-fund/delete/{id}', [PayrollController::class, 'deleteEmployeefund'])->name('employeefund.delete');
    Route::put('employee-fund/update/{id}', [PayrollController::class, 'updateEmployeefund'])->name('employeefund.update');
    // employee service
    Route::post('employee-service/store', [PayrollController::class, 'storeEmployeeservice'])->name('employeeservice.store');
    Route::get('employee-service/delete/{id}', [PayrollController::class, 'deleteEmployeeservice'])->name('employeeservice.delete');
    Route::put('employee-service/update/{id}', [PayrollController::class, 'updateEmployeeservice'])->name('employeeservice.update');

    Route::post('whyus/store', [CompanyProfileController::class, 'WhyUsStore'])->name('whyus.store');
    Route::put('whyus/update/{id}', [CompanyProfileController::class, 'WhyUsUpdate'])->name('whyus.update');
    Route::get('whyus/delete/{id}', [CompanyProfileController::class, 'WhyUsDelete'])->name('whyus.delete');
    
    Route::post('features/store', [CompanyProfileController::class, 'featuresStore'])->name('features.store');
    Route::put('features/update/{id}', [CompanyProfileController::class, 'featuresUpdate'])->name('features.update');
    Route::get('features/delete/{id}', [CompanyProfileController::class, 'featuresDelete'])->name('features.delete');

    Route::post('plans/store', [CompanyProfileController::class, 'plansStore'])->name('plans.store');
    Route::put('plans/update/{id}', [CompanyProfileController::class, 'plansUpdate'])->name('plans.update');
    Route::get('plans/delete/{id}', [CompanyProfileController::class, 'plansDelete'])->name('plans.delete');

    Route::post('askedQuestions/store', [CompanyProfileController::class, 'askedQuestionsStore'])->name('askedQuestions.store');
    Route::put('askedQuestions/update/{id}', [CompanyProfileController::class, 'askedQuestionsUpdate'])->name('askedQuestions.update');
    Route::get('askedQuestions/delete/{id}', [CompanyProfileController::class, 'askedQuestionsDelete'])->name('askedQuestions.delete');

    Route::post('customerSays/store', [CompanyProfileController::class, 'customerSaysStore'])->name('customerSays.store');
    Route::put('customerSays/update/{id}', [CompanyProfileController::class, 'customerSaysUpdate'])->name('customerSays.update');
    Route::get('customerSays/delete/{id}', [CompanyProfileController::class, 'customerSaysDelete'])->name('customerSays.delete');
    
    Route::post('Interface/store', [CompanyProfileController::class, 'InterfaceStore'])->name('interfaces.store');
    Route::put('Interface/update/{id}', [CompanyProfileController::class, 'InterfaceUpdate'])->name('interfaces.update');
    Route::get('Interface/delete/{id}', [CompanyProfileController::class, 'InterfaceDelete'])->name('interfaces.delete');
    // Route::get('customerSays/status', [CompanyProfileController::class, 'customerSaysst'])->name('customerSays.delete');

    // Counter Module Routes
    Route::post('/open-counter', [CounterController::class, 'open'])->name('openCounter');
    Route::post('/close-counter', [CounterController::class, 'close'])->name('closeCounter');
    Route::get('/counter/today-state', [CounterController::class, 'getTodayCounter'])->name('todayCounterState');

    

   Route::get('company-profile/videos', [CompanyProfileController::class, 'Video'])
    ->name('company-profile.videos');

// Store new video (from modal/form)
Route::post('company-profile/videos/store', [CompanyProfileController::class, 'VideoStore'])
    ->name('company-profile.videos.store');

    Route::post('admin/company-profile/videos/{id}/delete', [CompanyProfileController::class,'VideoDelete'])->name('company-profile.videos.delete');



    Route::get('/counter/today-state', [CounterController::class, 'getTodayCounter'])->name('getTodayCounter');
});



