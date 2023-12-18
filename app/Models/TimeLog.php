<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'date', 'check_in', 'check_out', 'hours_worked'];


    public static function getHoursWorked($userId, $date)
    {
        return self::where('user_id', $userId)
            ->where('date', $date)
            ->value('hours_worked');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function getTotalHoursWorkedInMonth($userId, $month, $year)
    {
        return self::where('user_id', $userId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('hours_worked');
    }
    public static function getUsersWithLoggedHoursInMonth($month, $year)
    {
        $userIds = self::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->pluck('user_id')
            ->unique()
            ->toArray();
    
            return User::whereIn('id', $userIds)
            ->where('base_salary', '>', 0)
            ->get();
    
    }
}
