<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BenefitController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\TasksController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Ceo\CeoController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\Leader\LeaderController;
use App\Http\Controllers\Notification;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeLogsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Auth::routes();
Route::get('/', function () {
    if (Auth::check()) {
        return view('home');
    } else {
        return view('auth.login');
    }
})->name('home');
Route::post('/', [LoginController::class, 'login']);


Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/',  [AdminController::class, 'index'])->name('admin.home');
        Route::prefix('user')->group(function () {
            Route::get('upsert/{id?}', [UserController::class, 'viewUpsert'])->name('admin.user.upsert');
            Route::post('upsert/{id?}', [UserController::class, 'store']);
            Route::get('/', [UserController::class, 'index']);
            Route::delete('destroy/{id}', [UserController::class, 'destroy']);
            Route::get('/export', [UserController::class, 'export']);
            Route::get('role', [UserController::class, 'viewRole']);
            Route::post('filter-role-user/{id}', [UserController::class, 'filterRoleUser']);
            Route::post('update-role/{id}', [UserController::class, 'updateRole']);
        });
        Route::prefix('department')->group(function () {
            Route::get('upsert/{id?}', [DepartmentController::class, 'viewUpsert']);
            Route::post('upsert/{id?}', [DepartmentController::class, 'store']);
            Route::post('update-employee/', [DepartmentController::class, 'updateEmployee']);
            Route::get('/', [DepartmentController::class, 'index']);
            Route::delete('destroy/{id}', [DepartmentController::class, 'destroy']);
            Route::get('search/{search?}', [DepartmentController::class, 'search']);
        });
        Route::prefix('task')->group(function () {
            Route::get('upsert/{id?}', [TasksController::class, 'viewUpsert']);
            Route::post('upsert/{id?}', [TasksController::class, 'store']);
            Route::get('/', [TasksController::class, 'index']);
            Route::get('list-task-management/{id?}', [TasksController::class, 'taskManagement']);
            Route::delete('destroy/{id}', [TasksController::class, 'destroy']);
        });
        Route::prefix('benefit')->group(function () {
            Route::get('upsert/{id?}', [BenefitController::class, 'viewUpsert']);
            Route::post('upsert/{id?}', [BenefitController::class, 'store']);
            Route::get('/', [BenefitController::class, 'index']);
            Route::delete('destroy/{id}', [BenefitController::class, 'destroy']);
            Route::get('download/{id}', [BenefitController::class, 'download']);
        });
        Route::get('list-benefits', [CeoController::class, 'listBenefits']);

    });
    // employee
    Route::prefix('employee')->group(function () {
        Route::get('/',  [EmployeeController::class, 'index'])->name('employee.home');
        Route::get('department/{id?}',  [EmployeeController::class, 'getUserDepartment']);
        Route::get('task/{id?}',  [EmployeeController::class, 'getUserTask']);
        Route::post('update-task-status/{id?}',  [EmployeeController::class, 'updateTaskStatus']);
        Route::post('show-task-detail/{id?}',  [EmployeeController::class, 'showTaskDetail']);
        Route::post('report-task-status/{id?}',  [EmployeeController::class, 'reportTaskStatus']);
        Route::get('list-benefits',  [EmployeeController::class, 'listBenefits']);

        Route::prefix('user')->group(function () {
            Route::get('upsert/{id?}', [UserController::class, 'viewUpsert'])->name('admin.user.upsert');
            Route::post('upsert/{id?}', [UserController::class, 'store']);
            Route::get('/', [UserController::class, 'index']);
        });

        Route::prefix('department-manager')->group(function () {
            Route::post('update-employee/{id?}', [DepartmentController::class, 'updateEmployee']);
            Route::get('list', [DepartmentController::class, 'index']);
            Route::get('search/{search?}', [DepartmentController::class, 'search']);
        });
    });
    // leader
    Route::prefix('leader')->group(function () {
        Route::get('/',  [LeaderController::class, 'index'])->name('leader.home');
        Route::get('list-employee/{id?}',  [LeaderController::class, 'listEmployee']);
        Route::delete('remove-employee/{id?}',  [LeaderController::class, 'removeEmployee']);
        Route::get('export/{id?}',  [LeaderController::class, 'export']);
        Route::post('update-task-status/{id?}',  [LeaderController::class, 'updateTaskStatus']);
        Route::post('show-task-detail/{id?}',  [LeaderController::class, 'showTaskDetail']);
        Route::post('report-task-status/{id?}',  [LeaderController::class, 'reportTaskStatus']);
        Route::get('list-task-management/{id?}', [LeaderController::class, 'taskManagement']);
        Route::prefix('task')->group(function () {
            Route::get('upsert/{id?}', [TasksController::class, 'viewUpsert']);
            Route::post('upsert/{id?}', [TasksController::class, 'store']);
            // Route::get('list-task-management/{id?}', [CeoController::class, 'taskManagement']);
            Route::get('/', [TasksController::class, 'index']);
        });
        Route::get('list-benefits',  [LeaderController::class, 'listBenefits']);
    });
    // ceo
    Route::prefix('ceo')->group(function () {
        Route::get('/',  [CeoController::class, 'index'])->name('ceo.home');
        Route::prefix('user')->group(function () {
            Route::get('upsert/{id?}', [UserController::class, 'viewUpsert'])->name('admin.user.upsert');
            Route::post('upsert/{id?}', [UserController::class, 'store']);
            Route::get('/', [UserController::class, 'index']);
            Route::delete('destroy/{id}', [UserController::class, 'destroy']);
            Route::get('role', [UserController::class, 'viewRole']);
            Route::get('/export', [UserController::class, 'export']);
        });
        Route::prefix('department')->group(function () {
            Route::get('upsert/{id?}', [DepartmentController::class, 'viewUpsert']);
            Route::post('upsert/{id?}', [DepartmentController::class, 'store']);
            Route::post('update-employee/', [DepartmentController::class, 'updateEmployee']);
            Route::get('/', [DepartmentController::class, 'index']);
            Route::get('detail/{id?}', [CeoController::class, 'deparmentDetail']);
        });
        Route::prefix('task')->group(function () {
            Route::get('upsert/{id?}', [TasksController::class, 'viewUpsert']);
            Route::post('upsert/{id?}', [TasksController::class, 'store']);
            Route::get('/', [TasksController::class, 'index']);
        });
        Route::prefix('benefit')->group(function () {
            Route::get('upsert/{id?}', [BenefitController::class, 'viewUpsert']);
            Route::post('upsert/{id?}', [BenefitController::class, 'store']);
            Route::get('/', [BenefitController::class, 'index']);
            Route::delete('destroy/{id}', [BenefitController::class, 'destroy']);
            Route::get('download/{id}', [BenefitController::class, 'download']);
        });
        Route::post('confirm-task-status/{id?}', [CeoController::class, 'confirmTaskStatus']);
        Route::post('confirm-notification/{id?}', [CeoController::class, 'confirmNotification']);
        Route::get('task-management', [CeoController::class, 'taskManagement']);
        Route::get('list-benefits', [CeoController::class, 'listBenefits']);
    });
    Route::prefix('time')->group(function () {
        Route::get('/', [TimeLogsController::class, 'index']);
        Route::post('checkin', [TimeLogsController::class, 'checkin']);
        Route::post('checkout', [TimeLogsController::class, 'checkout']);
        Route::post('date-time-log', [TimeLogsController::class, 'dateTimeLogs']);
        Route::post('update-time-log/{id}', [TimeLogsController::class, 'updateTimeLogs']);
    });
    Route::prefix('salary')->group(function () {
        Route::get('create-month-salary', [SalaryController::class, 'createMonthSalary']);
        Route::post('create-month-salary', [SalaryController::class, 'storeMonthSalary']);
        Route::get('user-salary-statistics/{id}', [SalaryController::class, 'userSalaryStatistics']);
        Route::post('detail-salary/{id}', [SalaryController::class, 'detailSalary']);
        Route::get('statistic', [SalaryController::class, 'statistic']);
        Route::get('export/{id}', [SalaryController::class, 'export']);
        Route::post('export-statistic-ajax', [SalaryController::class, 'exportStatisticToExcelAjax']);
        Route::get('download-excel/{fileName}', [SalaryController::class, 'downloadExcel'])->name('download-excel');
    });
    Route::prefix('task-comment')->group(function () {
        Route::post('add-comment', [TaskController::class, 'addComment']);
    });

    Route::get('personal-info/{id?}',  [InformationController::class, 'getPersonalInfo'])->name('personalInfo');
    Route::post('personal-info/{id?}',  [InformationController::class, 'store']);
    Route::get('change-password/{id?}',  [InformationController::class, 'showChangePasswordForm']);
    Route::post('change-password/{id?}',  [InformationController::class, 'changePassword']);
    Route::post('is-read-notification/{id?}',  [Notification::class, 'isReadNotification']);
    Route::get('get-notification/{id?}',  [Notification::class, 'getNotification']);
    Route::post('change-proccess-status/{id?}',  [TaskController::class, 'changeProccessStatus']);
});
Route::get('/logout',  [LoginController::class, 'logout'])->name('logout');
Route::get('/check-after-reset',  [ResetPasswordController::class, 'checkAfterReset']);

Route::post('upload', [UploadController::class, 'store']);
// 
