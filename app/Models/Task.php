<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;


    // status
    const NOT_START = 0;
    const INPROGRESS = 1;
    const TESTING = 2;
    const WAIT_RESPONE = 3;
    const COMPLETE = 4;
    // status

    const LOW = 0;
    const NORMAL = 1;
    const HIGH = 2;
    const URGENT = 3;

  
    public static function getStatus($status)
    {
        switch ($status) {
            case self::NOT_START:
                return 'Chưa bắt đầu';
            case self::INPROGRESS:
                return 'Đang tiến hành';
            case self::TESTING:
                return 'Đang kiểm tra';
            case self::WAIT_RESPONE:
                return 'Chờ phản hồi';
            case self::COMPLETE:
                return 'Hoàn thành';
            default:
                return 'Không xác định';
        }
    }
    public static function getPriority($priority)
    {
        switch ($priority) {
            case self::LOW:
                return 'Thấp';
            case self::NORMAL:
                return 'Bình thường';
            case self::HIGH:
                return 'Cao';
            case self::URGENT:
                return 'Cấp bách';
            default:
                return 'Không xác định';
        }
    }
    public static function getAllTask($limit, $search){
        $limit = $limit !== null ? $limit : 10;
        $query = Task::query();
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
       

        $tasks = $query->paginate($limit);
        return $tasks;
    }

    public function processes() {
        return $this->hasMany(TaskProcess::class, 'task_id', 'id');
    }
    public function assignees() {
        return $this->belongsToMany(User::class, 'task_assignees', 'task_id', 'user_id');
    }
}
