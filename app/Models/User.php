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
        'phone_number',
        'on_board',
        'off_board',
        'status',
        'position_id ',
        'note ',
        'department_id'
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function getUserName(){
        $userName = Auth::user()->name;
        return $userName;
    }
    public function getAllUsers($limit, $search){
        $limit = $limit !== null ? $limit : 10;
        $query = User::query();
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');
        }
       

        $users = $query->paginate($limit);
        return $users;
    }
    public static function getUserLeader(){
        $query = User::query();
        $leader = $query->where('position_id',3)->get();
        return $leader;
    }
    public static function getUserEmployee(){
        $query = User::query();
        $employees = $query->where('position_id',2)->get();
        return $employees;
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getDepartmentName()
    {
        return $this->department ? $this->department->name : 'Chưa có phòng ban';
    }

}
