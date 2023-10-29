<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Department extends Model
{
    use HasFactory;


    public static function getAllDepartment($limit, $search){
        $limit = $limit !== null ? $limit : 10;
        $query = Department::query();
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
       

        $departments = $query->paginate($limit);
        return $departments;
    }
    public  function getLeaderName($leader_id){
        if ($leader_id === null) {
            return "Không có trưởng phòng";
        }
        $user = User::findOrFail($leader_id);
        return $user->name ;
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
