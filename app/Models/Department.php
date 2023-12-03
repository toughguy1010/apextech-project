<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'leader_id',
        'description',
    ];

    public static function getAllDepartment($limit, $search, $all)
    {
        $limit = $limit !== null ? $limit : 10;
        $query = Department::query();
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if($all == null){
            $departments = $query->paginate($limit);
        }else{
            $departments = $query->get();
            
        }
        return $departments;
    }
    public  function getLeaderName($leader_id)
    {
        if ($leader_id === null) {
            return "Không có trưởng phòng";
        }
        $user = User::findOrFail($leader_id);
        return $user->name;
    }

    public static function getDepartmentByLeader($leader_id)
    {
        if ($leader_id === null) {
            return "Không có trưởng phòng";
        }
        $query = Department::query();
        $department =  $query->where('leader_id', $leader_id)->first();
        return  $department;
    }
    public static function getAllUsersByDepartment($department_id, $perPage = 2, $search = null, $all = null)
    {
        if ($department_id === null) {
            return "Không có phòng ban";
        }

        $department = Department::find($department_id);

        $query = $department->users();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        if ($all == 1){
            $users = $query->get();
        }else{
            $users = $query->paginate($perPage);
        }

        if (!$users) {
            return "Không có nhân viên";
        }
        return $users;
    }
    public static function getDepartmentByUser($user_id)
    {
        $department = Department::whereHas('users', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->first();

        return $department ?? null;
    }
   

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function countUsers()
    {
        return $this->users()->count();
    }
}
