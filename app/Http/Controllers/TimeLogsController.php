<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class TimeLogsController extends Controller
{
    //
    public function index(Request $request)
    {
        $currentDate = now();
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentDate->month, $currentDate->year);


        $department = $request->input('department');
        $position = $request->input('position');
        $orderby = $request->input('orderby');
        $option = [
            'department' => $department,
            'position' => $position,
            'orderby' => $orderby,
        ];
        $users = User::getTimeLogsUser($option);
        $positions = Position::whereNotIn('id', [1, 4])->get();
        $departments = Department::all();
        $allDaysInMonth = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($currentDate->year, $currentDate->month, $day);
            $date->locale('vi');
            $allDaysInMonth[] = [
                'day' => $day,
                'month' => $currentDate->month,
                'weekday' => $this->translateDay($date->format('D')),
                'weekday_vi' => $date->format('l'),
                'date' => $date->toDateString(),
            ];
        }
        return view('layouts.time_logs.time_logs', [
            "days" => $allDaysInMonth,
            "users" => $users,
            "positions" => $positions,
            "departments" => $departments,
            "currentMonth" => $this->translateMonth($currentDate->month),
            "currentYear" => $currentDate->year,

        ]);
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
    public static function translateDay($englishDay)
    {
        $translations = [
            'Mon' => 'Thứ hai',
            'Tue' => 'Thứ ba',
            'Wed' => 'Thứ tư',
            'Thu' => 'Thứ năm',
            'Fri' => 'Thứ sáu',
            'Sat' => 'Thứ bảy',
            'Sun' => 'Chủ nhật',
        ];

        return $translations[$englishDay] ?? $englishDay;
    }

    public function checkin(Request $request)
    {
        $user_id = $request->post('userId');
        $dateString = $request->post('date');
        $checkin_time = $request->post('time');
        $checkin = TimeLog::where('user_id', $user_id)->where('date', $dateString)->first();
        if ($checkin) {
            return response()->json([
                'message' => 'Đã có thông tin chấm công cho ngày này',
                'success' => false
            ]);
        } else {
            $test = "08:00:00";

            TimeLog::create([
                'user_id' => $user_id,
                'date' => $dateString,
                'check_in' => $test,
                // 'check_in' => $checkin_time,
            ]);
            return response()->json([
                'message' => 'Check in thành công',
                'success' => true
            ]);
        }
    }

    public function checkout(Request $request)
    {
        $user_id = $request->post('userId');
        $dateString = $request->post('date');
        $checkout_time = $request->post('time');

        $checkout = TimeLog::where('user_id', $user_id)->where('date', $dateString)->first();

        if ($checkout) {
            // Lấy giờ làm việc từ check_in đến check_out (loại bỏ thời gian nghỉ trưa)
            $test = "17:00:00";
            $workedHours = $this->countWorkedHours($checkout->check_in, $test);

            // Cập nhật thông tin chấm công
            $checkout->check_out = $test;
            $checkout->hours_worked = $workedHours;
            $checkout->save();

            return response()->json([
                'message' => 'Checkout thành công',
                'success' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Checkout thất bại',
                'success' => false
            ]);
        }
    }

    private function countWorkedHours($check_in, $check_out)
    {
        $startWorkingTime = strtotime('08:00:00'); // Thời gian bắt đầu làm việc
        $endWorkingTime = strtotime('17:00:00');   // Thời gian kết thúc làm việc
        $lunchStart = strtotime('12:00:00');       // Thời gian bắt đầu nghỉ trưa
        $lunchEnd = strtotime('13:00:00');         // Thời gian kết thúc nghỉ trưa

        $timeIn = strtotime($check_in);
        $timeOut = strtotime($check_out);

        $workedHours = 0;

        // Nếu check-in hoặc check-out sau giờ kết thúc làm việc, chỉ tính giờ làm đến giờ làm việc cuối cùng
        if ($timeIn >= $endWorkingTime || $timeOut <= $startWorkingTime) {
            return $workedHours;
        }

        // Loại bỏ thời gian nghỉ trưa nếu có
        if ($timeIn < $lunchStart && $timeOut > $lunchEnd) {
            $workedHours += ($lunchStart - $startWorkingTime) + ($endWorkingTime - $lunchEnd);
        } else {
            // Tính giờ làm việc không bao gồm thời gian nghỉ trưa
            if ($timeIn < $lunchStart && $timeOut <= $lunchStart) {
                $workedHours += $endWorkingTime - $lunchStart;
            } elseif ($timeIn >= $lunchEnd && $timeOut > $lunchEnd) {
                $workedHours += $endWorkingTime - $startWorkingTime;
            } else {
                $workedHours += min($lunchStart - $startWorkingTime, $timeIn - $startWorkingTime);
                $workedHours += min($endWorkingTime - $lunchEnd, $endWorkingTime - $timeOut);
            }
        }

        return round($workedHours / 3600, 2); // Chuyển đổi kết quả về giờ
    }
}
