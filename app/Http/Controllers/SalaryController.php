<?php

namespace App\Http\Controllers;

use App\Exports\SalaryUserSatistics;
use App\Exports\StatisticExport;
use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\TimeLog;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class SalaryController extends Controller
{
    //
    public function createMonthSalary()
    {
        return view("layouts.salary.create-salary-month");
    }
    public function storeMonthSalary(Request $request)
    {
        $year = $request->input('selected_year');
        $month = $request->input('selected_month');
        $title = $request->input('title');
        $result = $this->calculateAndStoreSalaries($month, $year, $title);
        if ($result == true) {
            Session::flash('success', "Đã tạo lương thành công cho tháng $month năm $year.");
        } else {
            Session::flash('error', "Có lỗi xảy ra khi tạo lương. Vui lòng thử lại sau.");
        }

        return back();
    }

    private function calculateAndStoreSalaries($month, $year, $title)
    {
        // Lấy danh sách người dùng đã chấm công trong tháng đó
        $usersWithLoggedHours = TimeLog::getUsersWithLoggedHoursInMonth($month, $year);
        $success = true;
        $create_by_id = Auth::user()->id;
        // Kiểm tra xem đã có phiếu lương cho tháng đó chưa
        $existingSalary = Salary::where('month', $month)
            ->where('year', $year)
            ->get();
        if (count($existingSalary) > 0) {
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
                'title' => $title,
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

    public function userSalaryStatistics(Request $request, $id)
    {
        $time = $request->input('selected_month');
        if ($time != null) {
            $selectedDate = Carbon::createFromFormat('Y-m', $time);
            $month = $selectedDate->month;
            $year = $selectedDate->year;
        } else {
            $month = null;
            $year = null;
        }

        $page = 10;

        $salaries = Salary::getSalaryByUserId($id, $month, $year, $page);
        return view('layouts.salary.user-salary-statistics', [
            'salaries' => $salaries
        ]);
    }
    public function detailSalary(Request $request, $id)
    {

        $salary = Salary::findOrFail($id);
        $user = User::findOrFail($salary->user_id);

        return view('layouts.salary.detail-salary', [
            'salary' => $salary,
            'user' => $user
        ]);
    }

    public function statistic(Request $request)
    {

        $currentYear = $request->get('selected_year') ? $request->get('selected_year') : date('Y');
        $months = [];
        $departments = Department::all();
        $department = $request->input('department');
        $option = [
            'department' => $department,
        ];
        $users = User::getSalaryUser($option);
        $selectedMonth = $request->input('selected_month', null);
        $startMonth = $selectedMonth ?: 1;
        $endMonth = $selectedMonth ?: 12;
        $months = [];

        for ($i = $startMonth; $i <= $endMonth; $i++) {
            $months[] = [
                'number' => $i,
                'name' => $this->translateMonth($i),
                'year' => $currentYear,
            ];
        }
        return view('layouts.salary.statistic', [
            'months' => $months,
            'users' => $users,
            'year' => $currentYear,
            'departments' => $departments
        ]);
    }

    public function exportStatisticToExcelAjax(Request $request)
    {
        $currentYear = $request->post('selected_year') ? $request->post('selected_year') : date('Y');
        $selectedMonth = $request->post('selected_month', null);
        $startMonth = $selectedMonth ?: 1;
        $endMonth = $selectedMonth ?: 12;
        $department = $request->post('department');
        $months = [];

        $option = [
            'department' => $department,
        ];
        $users = User::getSalaryUser($option);
        for ($i = $startMonth; $i <= $endMonth; $i++) {
            $months[] = [
                'number' => $i,
                'name' => $this->translateMonth($i),
                'year' => $currentYear,
            ];
        }
        $export = new StatisticExport($users, $months);
        $filePath = 'exports/Thong_ke_luong_' . $currentYear . '.xlsx';

        // Save the Excel file to the storage path
        Excel::store($export, $filePath, 'public');

        $url = asset('storage/' . $filePath);

        return response()->json(['url' => $url]);
    }

    public function export($id)
    {
        return Excel::download(new SalaryUserSatistics($id), 'salary_user_statistics.xlsx');
    }

    public static function translateMonth($englishMonth)
    {
        $translations = [
            '1' => 'Tháng một',
            '2' => 'Tháng hai',
            '3' => 'Tháng ba',
            '4' => 'Tháng tư',
            '5' => 'Tháng năm',
            '6' => 'Tháng sáu',
            '7' => 'Tháng bảy',
            '8' => 'Tháng tám',
            '9' => 'Tháng chín',
            '10' => 'Tháng mười',
            '11' => 'Tháng mười một',
            '12' => 'Tháng mười hai',
        ];

        return $translations[$englishMonth] ?? $englishMonth;
    }
    
}
