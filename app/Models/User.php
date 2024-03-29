<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'birthday',
        'gender',
        'phone_number',
        'address',
        'education',
        'marital_status',
        'on_board',
        'off_board',
        'status',
        'position_id ',
        'department_id',
        'role',
        'base_salaray',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    // role

    const USER_MANAGER  =  1;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function getUserName()
    {
        $userName = Auth::user()->name;
        return $userName;
    }
    public static function getUserNameByID($id)
    {
        $user = User::find($id);

        if ($user) {
            return $user->name;
        } else {
            return null;
        }
    }
    public function getAllUsers($limit, $search)
    {
        $limit = $limit !== null ? $limit : 10;
        $query = User::query();
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }


        $users = $query->paginate($limit);
        return $users;
    }
    public static function getTimeLogsUser($option)
    {
        $query = User::query();
        $users = [];
        if (isset($option['department'])) {
            $query->where('department_id', $option['department']);
        }
        if (isset($option['position'])) {
            $query->Where('position_id', $option['position']);
        }
        if (isset($option['order_by'])) {
            $query->orderBy('id', $option['order_by']);
        }
        $query->where(function ($query) {
            $query->where('status', 1)
                ->where(function ($query) {
                    $query->where('position_id', 2)
                        ->orWhere('position_id', 3);
                });
        });
        $users = $query->get();
        return $users;
    }


    public static function getSalaryUser($option)
    {
        $query = User::query();
        $users = [];
        if (isset($option['department'])) {
            $query->where('department_id', $option['department']);
            $query->with(['leaderDepartment' => function ($query) {
                $query->select('*');
            }]);
        }
        if (isset($option['month']) && isset($option['year'])) {
            $query->with(['salaries' => function ($query) use ($option) {
                $query->where('month', $option['month']);
                $query->where('year', $option['year']);
            }]);
        }
        $query->where(function ($query) {
            $query->where('status', 1)
                ->where(function ($query) {
                    $query->where('position_id', 2)
                        ->orWhere('position_id', 3);
                });
        });
        $users = $query->get();
        return $users;
    }



    public static function getUserLeader()
    {
        $query = User::query();
        $leader = $query->where('position_id', 3)->get();
        return $leader;
    }
    public static function getUserEmployee()
    {
        $query = User::query();
        $employees = $query->where('status', 1)->get();
        $employees = $query->where('position_id', 2)->get();
        return $employees;
    }
    public static function getTaskManager()
    {
        $query = User::query();
        $task_managers = $query->where('position_id', '!=', 2)
            ->where('position_id', '!=', 1)
            ->where('position_id', '!=', 4)
            ->get();
        return $task_managers;
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public static function getAvatarByUserID($id)
    {
        $user = User::findOrFail($id);
        $avatar_src = $user->avatar;
        return $avatar_src;
    }
    public function getDepartmentName()
    {
        return $this->department ? $this->department->name : 'Chưa có phòng ban';
    }
    public function leaderDepartment()
    {
        return $this->hasOne(Department::class, 'leader_id');
    }
    public function assignedProcesses()
    {
        return $this->belongsToMany(TaskProcess::class, 'task_process_assignees', 'user_id', 'task_process_id');
    }
    public function receivedNotifications()
    {
        return $this->hasMany(ReceiverNotification::class, 'receiver_ids');
    }
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
    public function timeLogs()
    {
        return $this->hasMany(TimeLog::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class, 'user_id');
    }
    public function role()
    {
        return $this->hasOne(Role::class);
    }
}
