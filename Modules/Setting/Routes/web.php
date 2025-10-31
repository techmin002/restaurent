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

Route::prefix('setting')->group(function () {
    Route::get('/', 'SettingController@index');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('company', 'CompanyProfileController');
    Route::get('why/us', [CompanyProfileController::class, 'whyUs'])->name('whyus.index');
    Route::get('setsalary', [PayrollController::class, 'index'])->name('setsalary.index');
    Route::get('payslip', [PayrollController::class,'payslip'])->name('setsalary.payslip.index');
    Route::get('/payslip/fetch', [PayrollController::class, 'fetchPayslip'])->name('payslip.fetch');
    Route::post('/payslip/markAsPaid', [PayrollController::class, 'markAsPaid'])->name('payslip.markAsPaid');
    Route::post('payslip/store', [PayrollController::class,'payslipStore'])->name('payslip.store');
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
});
