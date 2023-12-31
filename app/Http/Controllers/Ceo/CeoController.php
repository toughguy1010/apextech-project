<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Benefit;
use App\Models\User;
use App\Models\ReportNotification;

class CeoController extends Controller
{
    //
    private $user;

    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }
    public function index(Request $request)
    {
        $limit = 5;
        $all = null;
        $search = $request->input('search', '');
        $departments = Department::getAllDepartment($limit, $search, $all);
        return view('ceo.home', [
            'user_name' => $this->user->getUserName(),
            'departments' => $departments
        ]);
    }
    // public function taskManagement($id)
    // {
    //     $option = 'all';
    //     $tasks = Task::getTaskByUser($id,$option);
    //     return view('ceo.task',[
    //         'tasks' => $tasks,
    //     ]);
    // }
    public function confirmTaskStatus(Request $request, $id = null)
    {
        $task = Task::findOrFail($id);
        $status = $request->post('status');
        if ($status != 3) {
            $task->status =  3;
        } else {
            $task->status =  4;
        }
        $status_name = Task::getStatus($task->status);
        $result =  $task->save();
        if ($result) {
            return response()->json([
                'message' => 'Cập nhật trạng thái ' . $status_name . ' thành công.',
                'status' => $task->status,
            ]);
        } else {
            return response()->json([
                'message' => 'Cập nhật trạng thái ' . $status_name . ' thất bại.',
            ]);
        }
    }
    public function confirmNotification(Request $request, $id = null)
    {
        $task_id = $id;
        $task = Task::findOrFail($task_id);
        if ($task) {
            $from_user = $request->post('fromUser');
            $managers = $task->managers->pluck('id')->toArray();
            $assignees = $task->assignees->pluck('id')->toArray();

            $currentUserId = auth()->id();

            $managers = collect($managers)->reject(function ($manager) use ($currentUserId) {
                return $manager == $currentUserId;
            })->toArray();

            $receriver_ids = array_merge($managers, $assignees);
            $type = 2;
            $addReport = ReportNotification::addNotification($from_user, $receriver_ids, $type, $task_id);
            if ($addReport) {
                return response()->json([
                    'success' => true,
                    'message' => "Đã xác nhận  $task->name ",
                ]);
            }
        }
    }
    public function taskManagement(Request $request)
    {
        $limit = 5;
        $search = null;
        $search = $request->input('search', '');
        $tasks = Task::getAllTask($limit, $search);
        return view('ceo.task', [

            'tasks' => $tasks,
            'search' => $search,
        ]);
    }
    public function listBenefits(Request $request){
        $limit = 5;
        $all = null;
        $search = $request->input('search', '');
        $benefits = Benefit::getAllBenefits($limit, $search, $all);
        return view('ceo.benefits', [
            'search' => $search,
            'benefits' => $benefits,
        ]);
    }
    public function deparmentDetail(Request $request, $id = null){
        if($id != null ){
            $department = Department::findOrFail($id);
            $leader = User::findOrFail($department->leader_id) ;
            $per_page = 2;
            $search = $request->input("search", "");
            $all = null;
            $employees = Department::getAllUsersByDepartment($department->id, $per_page, $search, $all);
            
        }
       
        return view('ceo.department',[
            "department" => $department,
            "leader" => $leader,
            "employees" => $employees,
            "search" => $search,
        ]);
    }
}
