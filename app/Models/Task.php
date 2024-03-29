<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;


    // status
    const NOT_START = 0;
    const INPROGRESS = 1;
    const TESTING = 2;
    const COMPLETE = 3;
    const NOTCOMPLETE = 4;
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
            case self::COMPLETE:
                return 'Hoàn thành';
            case self::NOTCOMPLETE:
                return 'Chưa hoàn thành';
            default:
                return 'Không xác định';
        }
    }
    public static function countTasksByStatus($status, $userId, $role)
    {
        $user = Auth::user();
        $role_statement = $role == 'managers' ? 'manager_id' : 'user_id';
        if ($role == 'ceo') {
            return self::where('status', $status)->count();
        }
        return self::where('status', $status)->whereHas($role, function ($query) use ($userId, $role_statement,$user) {
            $query->where($role_statement, $userId);
            if($user !== 2){
                $query->orWhere('task_creater', $userId);
            }
        })
            ->count();
    }
    public static function getTaskByUser($id = null, $option = null, $limit = null, $task_creater)
    {
        if ($id === null && $option === null) {
            return [];
        }

        $position_id = $option == 'managers' ? 'manager_id' : 'user_id';
       
        $query = Task::whereHas($option, function ($query) use ($id, $position_id, $task_creater) {
            $query->where($position_id, $id);
            if ($task_creater !== null) {
                // var_dump($task_creater);
                $query->orWhere('task_creater', $task_creater);
            };
        });
        $query->orderBy('created_at', 'desc');
        if ($limit !== null) {
            $tasks = $query->paginate($limit);
        } else {
            $tasks = $query->get();
        }

        return $tasks;
    }
    public static function getTaskNameByID($id)
    {
        $task = Task::find($id);
        if ($task) {
            return $task->name;
        } else {
            return null;
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
    public static function getAllTask($limit, $search)
    {
        $limit = $limit !== null ? $limit : 10;
        $query = Task::query();
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->orderBy('id', 'DESC');
        $tasks = $query->paginate($limit);
        return $tasks;
    }
    public static function getCurrentAssigne($user_id)
    {
        // Find the task associated with the user
        $task = self::whereHas('assignees', function ($query) use ($user_id) {
            $query->where('users.id', $user_id);
        })->first();

        // If the task is found, get the assignees
        if ($task) {
            $assignees = $task->assignees()->wherePivot('user_id', $user_id)->get();

            // You can further process the assignees if needed
            return $assignees;
        }

        // If no assignee is found, you can return null or an empty collection
        return null;
    }

 
    public static function getCurrentUserAndAssigneesId($taskId)
    {
        $user = Auth::user();
        $task = self::find($taskId);

        if ($user && $task) {
            $assignee = $task->assignees->where('id', $user->id)->first();

            if ($assignee) {
                return [
                    'userID' => $user->id,
                    'task_assignees_id' => $assignee->pivot->id,
                ];
            }
        }

        return null;
    }


    
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_assignees', 'task_id', 'user_id')
            ->withPivot('id');
    }
    public function managers()
    {
        return $this->belongsToMany(User::class, 'task_managers', 'task_id', 'manager_id');
    }

   
    public static function getTaskByCreater($task_creater, $limit = null, $search = null)
    {
        $query = Task::where('task_creater', $task_creater);
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        if ($limit !== null) {
            $tasks = $query->paginate($limit);
        } else {
            $tasks = $query->get();
        }

        return $tasks;
    }
    public function comments()
    {
        return $this->hasMany(TaskComments::class);
    }
    public function processes()
    {
        return $this->hasMany(TaskProcess::class, 'task_id', 'id');
    }

}
