<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\TimeLog;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class SalaryController extends Controller
{
    //
    public function createMonthSalary()
    {
        return view("layouts.salary.create-salary-month");
    }
    public function storeMonthSalary(Request $request)
    {
        $time = $request->input('selected_month');
        $year = now()->parse($time)->year;
        $month = now()->parse($time)->month;

        $result = $this->calculateAndStoreSalaries($month, $year);
        if ($result == true) {
            Session::flash('success', "Đã tạo lương thành công cho tháng $month năm $year.");
        } else {
            Session::flash('error', "Có lỗi xảy ra khi tạo lương. Vui lòng thử lại sau.");
        }

        return back();
    }

    private function calculateAndStoreSalaries($month, $year)
    {
        // Lấy danh sách người dùng đã chấm công trong tháng đó
        $usersWithLoggedHours = TimeLog::getUsersWithLoggedHoursInMonth($month, $year);
        $success = true;
        $create_by_id = Auth::user()->id;
    
        // Kiểm tra xem đã có phiếu lương cho tháng đó chưa
        $existingSalary = Salary::where('month', $month)
            ->where('year', $year)
            ->get();
        if ( count($existingSalary  ) > 0) {
            // Nếu đã có, đánh dấu là không thành công và kết thúc hàm
            $success = false;
            return $success;
        }
    
        // Lặp qua danh sách người dùng và tạo phiếu lương
        foreach ($usersWithLoggedHours as $user) {
            // Kiểm tra xem đã có phiếu lương cho người dùng đó trong tháng đó chưa
            $existingSalaryForUser = Salary::where('user_id', $user->id)
                ->where('month', $month)
                ->where('year', $year)
                ->first();
    
            if ($existingSalaryForUser) {
                // Nếu đã có, chuyển sang người dùng tiếp theo
                continue;
            }
    
            // Nếu chưa có, tạo mới phiếu lương
            $hours_worked = TimeLog::getTotalHoursWorkedInMonth($user->id, $month, $year);
            $salary_model = new Salary();
    
            $standard_hour = $salary_model->gerStandardHour($month, $year);
            $salary = new Salary([
                'user_id' => $user->id,
                'month' => $month,
                'year' => $year,
                'hours_worked' => $hours_worked,
                'create_by' => $create_by_id,
                'standard_hour' => $standard_hour,
            ]);
    
            $calculatedSalary = $salary->calculateSalary($month, $year);
            $salary->calculated_salary = $calculatedSalary;
            $salary->save();
        }
    
        return $success;
    }

    public function userSalaryStatistics(Request $request, $id){
        $month = null;
        $year = null;
        $page = 10;

        $salaries = Salary::getSalaryByUserId($id,$month, $year, $page);
        return view('layouts.salary.user-salary-statistics',[
            'salaries' => $salaries
        ]);
    }
    public function detailSalary(Request $request, $id){
        
    }
}
