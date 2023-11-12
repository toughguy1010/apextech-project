<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    //
    private $user;

    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }
    public function index()
    {
        return view('employee.home', [
            'user_name' => $this->user->getUserName()
        ]);
    }
    public function getPersonalInfo()
    {
        $user = Auth::user();
        $user_id = $user->id;
        return $user_id;
    }
    public function getUserDepartment(Request $request, $id = null)
    {
        $perPage = 2;
        $search = $request->input('search', '');
        $department = Department::getDepartmentByUser($id);
    
        if ($department === null) {
            return view('employee.department')->with('message', 'Người dùng không có phòng ban.');
        }
    
        $users = Department::getAllUsersByDepartment($department->id, $perPage, $search);
    
        if ($users === null) {
            return view('employee.department')->with('message', 'Không có nhân viên trong phòng ban.');
        }
    
        return view('employee.department', [
            'department' => $department,
            'users' => $users,
            'search' => $search,
        ]);
    }
    public function getUserTask($id = null){
        $task = Task::getTaskByUser($id);
        dd($task);
    }
}
