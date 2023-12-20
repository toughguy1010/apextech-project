<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'user_id',
        'month',
        'year',
        'hours_worked',
        'standard_hour',
        'calculated_salary',
        'create_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateSalary($month, $year)
    {
        $user = $this->user;

        if ($user && $this->hours_worked > 0 && $user->base_salary > 0) {

            $standard_hours = $this->gerStandardHour($month, $year);
            $salary = ($this->hours_worked / $standard_hours) * $user->base_salary;

            // Làm tròn số lương nếu cần
            $salary = round($salary, 2);

            return $salary;
        }

        return 0; // Hoặc giá trị mặc định khác tùy thuộc vào yêu cầu của bạn
    }

    public function gerStandardHour($month, $year)
    {
        $hoursPerDay = 8;

        // Tính số ngày làm việc trong tháng và năm cụ thể
        $workingDaysInMonth = $this->getWeekdaysInMonth($month, $year);

        $standard_hours = $hoursPerDay * $workingDaysInMonth;
        return $standard_hours;
    }
    // Phương thức lấy số ngày làm việc trong tháng
    public function getWeekdaysInMonth($month, $year)
    {
        // Lấy ngày đầu tiên của tháng và năm
        $firstDayOfMonth = now()->setYear($year)->setMonth($month)->setDay(1)->startOfDay();

        // Lấy ngày cuối cùng của tháng và năm
        $lastDayOfMonth = $firstDayOfMonth->copy()->endOfMonth();

        // Đếm số ngày làm việc (thứ 2 đến thứ 6) trong khoảng thời gian đó
        $weekdays = 0;
        while ($firstDayOfMonth <= $lastDayOfMonth) {
            if ($firstDayOfMonth->isWeekday()) {
                $weekdays++;
            }
            $firstDayOfMonth->addDay();
        }
        return $weekdays;
    }
    public static function getSalaryByUserId($userId, $month = null, $year = null, $perPage = null){

        
        $query = self::where('user_id', $userId);

        if ($month !== null) {
            $query->where('month', $month);
        }

        if ($year !== null) {
            $query->where('year', $year);
        }
        if($perPage){

            return $query->paginate($perPage);
        }else{
            return $query->get();

        }
    }
}
