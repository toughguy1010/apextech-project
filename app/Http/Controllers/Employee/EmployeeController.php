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
        $tasks = Task::getTaskByUser($id);
        return view('employee.task',[
            'tasks' => $tasks,
        ]);
    }
    public function updateTaskStatus(Request $request, $id = null){
        $task = Task::findOrFail($id);
        $status = $request->post('status');
        $task->status =  $status ;
        $status_name = Task::getStatus($status);
        $result =  $task->save();
        if($result){
            return response()->json([
                'message' => 'Cập nhật trạng thái '.$status_name.' thành công.',
            ]);
        }else{
            return response()->json([
                'message' => 'Cập nhật trạng thái '.$status_name.' thất bại.',
            ]);
        }
    }
}
