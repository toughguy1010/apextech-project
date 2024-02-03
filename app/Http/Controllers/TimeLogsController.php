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
        $currentDate = now()->timezone('Asia/Ho_Chi_Minh');
        // $currentDate = now()->startOfMonth()->month(1)->year(2023)->timezone('Asia/Ho_Chi_Minh');
        // dd($currentDate);
        
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentDate->month, $currentDate->year);


        $department = $request->input('department');
        $position = $request->input('position');
        $orderby = $request->input('orderby');
        $option = [
            'department' => $department,
            'position' => $position,
            'order_by' => $orderby,
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
            $test = "06:00:00";

            TimeLog::create([
                'user_id' => $user_id,
                'date' => $dateString,
                // 'check_in' => $test,
                'check_in' => $checkin_time,
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
        // $dateString = '2022-10-26';
        $checkout = TimeLog::where('user_id', $user_id)->where('date', $dateString)->first();

        if ($checkout) {
            // Lấy giờ làm việc từ check_in đến check_out (loại bỏ thời gian nghỉ trưa)
            $test = "18:00:00";
            $workedHours = $this->countWorkedHours($checkout->check_in, $checkout_time);

            // Cập nhật thông tin chấm công
            $checkout->check_out = $checkout_time;
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
    public function dateTimeLogs(Request $request)
    {
        $user_id = $request->post('userId');
        $dateString = $request->post('date');
        $date_time_logs = TimeLog::where('user_id', $user_id)->where('date', $dateString)->first();
        if ($date_time_logs) {
            return view('layouts.time_logs.time_logs_date_modal', [
                'date_time_logs' => $date_time_logs
            ]);
        }
    }
    public function updateTimeLogs(Request $request, $id)
    {
        $request->validate([
            'checkin' => [
                'check_in' => 'bail|date_format:H:i:s', 
                'before:checkout',
                'after_or_equal:08:00:00',
            ],
            'checkout' => [
                'date_format:H:i:s',
                'after:checkin',
                'before:17:00:00',
            ], [
                'checkin.before' => 'Checkin time must be before checkout time.',
                'checkin.after_or_equal' => 'Checkin time must be greater than or equal to 8:00 AM.',
                'checkout.required' => 'Checkout time is required.',
                'checkout.date_format' => 'Invalid format for checkout time.',
                'checkout.after' => 'Checkout time must be after checkin time.',
                'checkout.before' => 'Checkout time must be before 5:00 PM.',
            ]
        ]);
        // If the validation passes, update the timelog
        $timelog = TimeLog::findOrFail($id);
        $timelog->check_in = $request->post('check_in');
        $timelog->check_out = $request->post('check_out');
        // Calculate the worked hours
        $workedHours = $this->countWorkedHours($request->post('check_in'), $request->post('check_out'));
        // Assign the calculated worked hours to the hours_worked field
        $timelog->hours_worked = $workedHours;
        $timelog->save();
        return redirect()->back()->with('success', 'Timelog updated successfully.');
    }


    private function countWorkedHours($check_in, $check_out)
    {
        $startWorkingTime = strtotime('07:00:00'); // Thời gian bắt đầu làm việc
        $endWorkingTime = strtotime('18:00:00');   // Thời gian kết thúc làm việc
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
       
            // Tính giờ làm việc không bao gồm thời gian nghỉ trưa
            $workedHours += max(0, min($lunchStart, $timeOut) - max($startWorkingTime, $timeIn));
            $workedHours += max(0, min($endWorkingTime, $timeOut) - max($lunchEnd, $timeIn));


        return round($workedHours / 3600, 2);
    }
}
