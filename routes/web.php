<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;

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
    return view('auth.login');
});
Route::post('/', [LoginController::class,'login']);


Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function(){
        Route::get('/',  [AdminController::class, 'index'])->name('admin.home');
        Route::prefix('user')->group(function(){
            Route::get('upsert/{id?}',[UserController::class,'viewUpsert'])->name('admin.user.upsert');
            Route::post('upsert/{id?}',[UserController::class,'store']);
            Route::get('/',[UserController::class,'index']);
            Route::delete('destroy/{id}',[UserController::class,'destroy']);
            Route::get('/export', [UserController::class,'export']);
        });
        Route::prefix('department')->group(function(){
            Route::get('upsert/{id?}',[DepartmentController::class,'viewUpsert']);
            Route::post('upsert/{id?}',[DepartmentController::class,'store']);
            Route::post('update-employee/',[DepartmentController::class,'updateEmployee']);
            Route::get('/',[DepartmentController::class,'index']);
            Route::delete('destroy/{id}',[DepartmentController::class,'destroy']);
        });
    });
    Route::prefix('employee')->group(function(){
        Route::get('/',  [EmployeeController::class, 'index'])->name('employee.home');
        Route::get('/personal-info',  [EmployeeController::class, 'getPersonalInfo']);
    });

});
Route::get('/logout',  [LoginController::class,'logout'])->name('logout');
Route::get('/check-after-reset',  [ResetPasswordController::class,'checkAfterReset']);

Route::post('upload',[UploadController::class,'store']);
// 
