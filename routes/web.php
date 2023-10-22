<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UploadController;

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
Route::middleware(['auth'])->group(function () {
   

    Route::prefix('admin')->group(function(){
        Route::get('/',  [AdminController::class, 'index'])->name('admin.home');
        Route::prefix('user')->group(function(){
            Route::get('upsert/{id?}',[UserController::class,'viewUpsert'])->name('admin.user.upsert');
            Route::post('upsert/{id?}',[UserController::class,'store']);
            Route::get('/',[UserController::class,'index']);
            Route::delete('destroy/{id}',[UserController::class,'destroy']);
        });
    });
    Route::prefix('employee')->group(function(){
        Route::get('/',  [EmployeeController::class, 'index'])->name('employee.home');
    });

});
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::post('upload',[UploadController::class,'store']);
// 
