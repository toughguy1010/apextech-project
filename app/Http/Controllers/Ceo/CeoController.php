<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
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
    public function index()
    {
        return view('ceo.home', [
            'user_name' => $this->user->getUserName()
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
        $status_name = Task::getStatus($status);
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
        if($task){
            $from_user = $request->post('fromUser');
            $managers = $task->managers->pluck('id')->toArray();
            $assignees = $task->assignees->pluck('id')->toArray();
            $receriver_ids = array_merge($managers, $assignees) ;
            $type = 2;
            $addReport = ReportNotification::addNotification($from_user,$receriver_ids,$type,$task_id );
            if($addReport){
                return response()->json([
                    'success' => true,
                    'message' => "Đã xác nhận  $task->name ",
                ]);
            }
        }
    }
}
