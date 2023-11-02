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

    public static function getAllDepartment($limit, $search)
    {
        $limit = $limit !== null ? $limit : 10;
        $query = Department::query();
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }


        $departments = $query->paginate($limit);
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
    public static function getAllUsersByDepartment($department_id,$perPage = 2,$search = null)
    {
        if ($department_id === null) {
            return "Không có phòng ban";
        }
    
        $department = Department::find($department_id);
    
        $query = $department->users(); 
    
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
    
        $users = $query->paginate($perPage);
    
        if (!$users) {
            return "Không có nhân viên";
        }
        return $users;
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
