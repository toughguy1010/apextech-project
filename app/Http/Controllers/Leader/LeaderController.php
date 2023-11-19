<?php

namespace App\Http\Controllers\Leader;

use App\Exports\UsersByDepartmentExport;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class LeaderController extends Controller
{
    //
        private $user;

        public function __construct(User $user)
        {
            $this->middleware('auth');
            $this->user = $user;
        }
    public function export($department_id)
    {
        return Excel::download(new UsersByDepartmentExport($department_id), 'users_department.xlsx');
    }
    public function index()
    {
        return view('leader.home', [
            'user_name' => $this->user->getUserName()
        ]);
    }
    public function listEmployee(Request $request, $id = null)
    {
        $users = null;
        $department = null;
        $search = $request->input('search', '');
        if ($id != null) {
            $department = Department::getDepartmentByLeader($id);
            if ($department instanceof Department) {
                $users = Department::getAllUsersByDepartment($department->id, 5, $search);
            }
        }
        return view('leader.list-employee', [
            'users' => $users,
            'department' => $department,
            'search' => $search,
        ]);
    }
    public function removeEmployee($id = null)
    {
        $user = User::find($id);

        if ($user) {
            $user->department_id = null;
            $user->save();

            return response()->json([
                'success' => 'Xóa người dùng khỏi phòng ban thành công.',
                'id' => $user->id,
            ]);
        } else {
            return response()->json([
                'error' => 'Không thể xóa người dùng khỏi phòng ban. Người dùng không tồn tại.'
            ]);
        }
    }


    public function taskManagement($id = null){
        $option = 'managers';
        $tasks = Task::getTaskByUser($id,$option);
        return view('leader.task',[
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
