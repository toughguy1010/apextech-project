<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;
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
            Route::delete('destroy/{id}', [TasksController::class, 'destroy']);
        });
    });
    // employee
    Route::prefix('employee')->group(function () {
        Route::get('/',  [EmployeeController::class, 'index'])->name('employee.home');
        // Route::get('personal-info',  [EmployeeController::class, 'getPersonalInfo']);
    });
    // leader
    Route::prefix('leader')->group(function () {
        Route::get('/',  [LeaderController::class, 'index'])->name('leader.home');
        Route::get('list-employee/{id?}',  [LeaderController::class, 'listEmployee']);
        Route::delete('remove-employee/{id?}',  [LeaderController::class, 'removeEmployee']);
        Route::get('export/{id?}',  [LeaderController::class, 'export']);
    });
    Route::prefix('ceo')->group(function () {
        Route::get('/',  [CeoController::class, 'index'])->name('ceo.home');
        Route::prefix('user')->group(function () {
            Route::get('upsert/{id?}', [UserController::class, 'viewUpsert'])->name('admin.user.upsert');
            Route::post('upsert/{id?}', [UserController::class, 'store']);
            Route::get('/', [UserController::class, 'index']);
            Route::delete('destroy/{id}', [UserController::class, 'destroy']);
            Route::get('/export', [UserController::class, 'export']);
        });
        Route::prefix('department')->group(function () {
            Route::get('upsert/{id?}', [DepartmentController::class, 'viewUpsert']);
            Route::post('upsert/{id?}', [DepartmentController::class, 'store']);
            Route::post('update-employee/', [DepartmentController::class, 'updateEmployee']);
            Route::get('/', [DepartmentController::class, 'index']);
        });
    });

    Route::get('personal-info/{id?}',  [InformationController::class, 'getPersonalInfo'])->name('personalInfo');
    Route::post('personal-info/{id?}',  [InformationController::class, 'store']);
    Route::get('change-password/{id?}',  [InformationController::class, 'showChangePasswordForm']);
    Route::post('change-password/{id?}',  [InformationController::class, 'changePassword']);
});
Route::get('/logout',  [LoginController::class, 'logout'])->name('logout');
Route::get('/check-after-reset',  [ResetPasswordController::class, 'checkAfterReset']);

Route::post('upload', [UploadController::class, 'store']);
// 
