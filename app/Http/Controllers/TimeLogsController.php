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
        $date = new \DateTime($dateString);

        $checkin = TimeLog::where('user_id', $user_id)->where('date', $date)->first();
        if ($checkin) {
            return response()->json([
                'message' => 'Đã có thông tin chấm công cho ngày này'
            ]);
        } else {
            TimeLog::create([
                'user_id' => $user_id,
                'date' => $date,
                'check_in' => $checkin_time,
            ]);
            return response()->json([
                'message' => 'Check in thành công'
            ]);
        }
    }

    public function checkout(Request $request)
    {
        $user_id = $request->post('userId');
        $dateString = $request->post('date');
        $checkout_time = $request->post('time');
        $date = new \DateTime($dateString);

        $checkout =  TimeLog::where('user_id', $user_id)->where('date', $date)->first();
        if ($checkout) {
            $checkout->check_out = $checkout_time;
            $test = "08:00:00";
            $checkout->hours_worked = $this->countWordHour($checkout->check_in, $test);
            $checkout->save();

            return response()->json(
                ['message' => 'Checkout thành công']
            );
        } else {
            return response()->json(
                ['message' => 'Checkout thất bại']
            );
        }
    }

    // Hàm tính thời gian làm
    private function countWordHour($check_in, $check_out)
    {
        $thoiGianDen = strtotime($check_in);
        $thoiGianVe = strtotime($check_out);

        $hours_worked = ($thoiGianVe - $thoiGianDen) / 3600;

        return round($hours_worked, 2);
    }
}
