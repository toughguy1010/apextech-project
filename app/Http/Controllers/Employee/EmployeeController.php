<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Position;
use App\Models\ReportNotification;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Benefit;
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

        $option = 'assignees';
        $user_id =  Auth::user()->id;
        $user = User::findorFail($user_id);
        $limit = 5;

        $tasks = Task::getTaskByUser($user_id, $option, $limit, null);
        $tasks_total = Task::getTaskByUser($user_id, $option, null, null);
        $department = Department::getDepartmentByUser($user->id);
        return view('employee.home', [
            'user_name' => $this->user->getUserName(),
            'tasks' =>  $tasks,
            'tasks_total' =>  $tasks_total,
            'user' =>  $user,
            'department' =>  $department,
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
    public function getUserTask($id = null)
    {
        $option = 'assignees';
        $tasks = Task::getTaskByUser($id, $option, null, null);
        return view('employee.task', [
            'tasks' => $tasks,
        ]);
    }
    public function updateTaskStatus(Request $request, $id = null)
    {
        $task = Task::findOrFail($id);
        $status = $request->post('status');
        $task->status =  $status;
        $status_name = Task::getStatus($status);
        $result =  $task->save();
        if ($result) {
            return response()->json([
                'message' => 'Cập nhật trạng thái ' . $status_name . ' thành công.',
                'status' => $task->status
            ]);
        } else {
            return response()->json([
                'message' => 'Cập nhật trạng thái ' . $status_name . ' thất bại.',
            ]);
        }
    }
    public function showTaskDetail($id = null)
    {
        $task = Task::findOrFail($id);

        if ($task) {
            $current_task_assignees = Task::getCurrentUserAndAssigneesId($task->id);
            return view('layouts.task-modal', [
                'task' => $task,
                'current_task_assignees' => $current_task_assignees,
            ]);
        } else {
            return response()->json([
                'task' => [],
                'message' => "Không tìm thấy task"
            ]);
        }
    }
    public function reportTaskStatus(Request $request, $id = null)
    {
        $task_id = $id;
        $task = Task::find($task_id);
       
        if ($task) {
         
                $receiver_ids = $task->managers->pluck('id')->toArray();
            if (empty($receiver_ids)) {
                return response()->json([
                    'success' => false,
                    'message' => "Không có người theo dõi",
                ]);
            }
            if ($task->status == 0 ) {
                return response()->json([
                    'success' => false,
                    'message' => "Công việc chưa được tiến hành",
                ]);
            }
            $from_user = $request->post('fromUser');

            $type = 1;
            $addReport = ReportNotification::addNotification($from_user, $receiver_ids, $type, $task_id);
            if ($addReport) {
                return response()->json([
                    'success' => true,
                    'message' => "Đã báo cáo  $task->name ",
                ]);
            }
        }
        return response()->json([
            'success' => false,
            'message' => "Báo cáo thất bại",
        ]);
    }
    public function listBenefits(Request $request){
        $limit = 5;
        $all = null;
        $search = $request->input('search', '');
        $benefits = Benefit::getAllBenefits($limit, $search, $all);
        return view('employee.benefits', [
            'search' => $search,
            'benefits' => $benefits,
        ]);
    }
}
