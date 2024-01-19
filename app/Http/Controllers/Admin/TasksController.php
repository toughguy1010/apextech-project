<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\ReceiverNotification;
use App\Models\ReportNotification;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskProcess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TasksController extends Controller
{
    //
    public function index(Request $request)
    {
        $limit = 5;
        $search = $request->input('search', '');
        $user = Auth::user(); 
        $task_creater = $user->id;
        if ($user->position_id == 3 || $user->position_id == 1) {
            $tasks = Task::getTaskByCreater( $task_creater, $limit ,$search );
        } else {
            $tasks = Task::getAllTask($limit, $search);
        }
        return view('admin.tasks.index', [
            'tasks' => $tasks,
            'search' => $search,
        ]);
    }
    public function viewUpsert($id = null)
    {
        $task = $id ? Task::findOrFail($id) : null;
        $user = Auth::user();
        if ($user->position_id == 3) {
            $department = Department::getDepartmentByLeader($user->id);
            if ($department instanceof Department) {
                $employees = Department::getAllUsersByDepartment($department->id, null, $search = null, $all = 1);
            }
            $task_managers = null;
            
        } else {
            
            $task_managers = User::getTaskManager();
            $employees = User::getUserEmployee();
        }
        return view('admin.tasks.upsert', [
            'id' => $id,
            'task' => $task,
            'employees' => $employees,
            'task_managers' => $task_managers,
        ]);
    }
    public function store(Request $request, $id = null)
    {

        $task_creater = Auth::user()->id;
        if ($id === null) {
            $task = new Task();
        } else {
            $task = Task::findOrFail($id);
        }

        try {
            $validationRules = [
                'name' => 'required|string|max:255', 
                'priority' => 'required', 
                'start_date' => 'required', 
                'end_date' => 'required', 
            ];
            $customMessages = [
                'name.required' => 'Tên công việc không được để trống.',
                'priority.required' => 'Độ ưu tiên công việc không được để trống.',
                'start_date.required' => 'Thời gian bắt đầu không được để trống.',
                'end_date.required' => 'Thời gian kết thúc không được để trống.',
            ];
            $validator = Validator::make($request->all(), $validationRules, $customMessages);
            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $task->name = $request->input('name');
            $task->description = $request->input('description');
            $task->start_date = $request->input('start_date');
            $task->end_date = $request->input('end_date');
            $task->content = $request->input('content');
            $task->priority = $request->input('priority');
            $task->task_creater = $task_creater;
            $employeesID = $request->input('employees_id');
            $task_mangersID = $request->input('task_manager');
            $process_details = $request->input('proccess_detail');
            $task->save();


            // Lấy danh sách task_process hiện tại
            $currentProcesses = $task->processes;

            // Lặp qua process_details từ form
            foreach ($process_details as $index => $detail) {
                // Nếu process có sẵn, cập nhật nó
                if (isset($currentProcesses[$index])) {
                    $currentProcesses[$index]->process_details = $detail;
                    $currentProcesses[$index]->save();
                } else {
                    // Nếu không có, thêm mới process
                    $taskProcess = new TaskProcess(['process_details' => $detail]);
                    $task->processes()->save($taskProcess);
                }
            }

            // Xóa các task_process không còn tồn tại trong process_details mới
            $deletedProcesses = count($process_details);
            if ($task->processes->count() > $deletedProcesses) {
                $task->processes->splice($deletedProcesses)->each->delete();
            }
            // var_dump($currentProcesses);
            // employee handle
            if ($employeesID !== null) {
                // Lấy danh sách nhân viên đã được gán cho công việc
                $currentEmployees = $task->assignees->pluck('id')->toArray();

                if (!empty($currentEmployees)) {
                    // Tìm những nhân viên bị bỏ chọn
                    $uncheckedEmployees = array_diff($currentEmployees, $employeesID);

                    // Cập nhật danh sách nhân viên gán cho công việc
                    $task->assignees()->sync($employeesID);

                    if (!empty($uncheckedEmployees)) {
                        // Bỏ gán những nhân viên bị bỏ chọn
                        $task->assignees()->detach($uncheckedEmployees);
                    }
                } else {
                    // Nếu không có nhân viên nào được gán trước đó, thì gán mới
                    $task->assignees()->sync($employeesID);
                    // Add notification
                }
            } else {
                // Nếu không có nhân viên được chọn, loại bỏ tất cả nhân viên được gán trước đó
                $task->assignees()->detach();
            }

            // task manager handle

            if ($task_mangersID != null) {
                $currentTaskManagers = $task->managers->pluck('id')->toArray();
                $task->managers()->sync($task_mangersID);
                if (!empty($currentTaskManagers)) {
                    $uncheckedManagers = array_diff($currentTaskManagers, $task_mangersID);
                    if (!empty($uncheckedManagers)) {
                        $task->managers()->detach($uncheckedManagers);
                    }
                } else {
                    $task->managers()->sync($task_mangersID);
                }
            } else {
                // $task->managers()->detach();
                $task->managers()->sync($task->task_creater);
            }
            if ($id === null) {
                Session::flash('success', 'Tạo công việc thành công');
            } else {
                Session::flash('success', 'Cập nhật công việc thành công');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        $task = Task::where('id', $id)->first();

        if ($task) {
            $deleted = $task->delete();
            if ($deleted) {
                return response()->json([
                    'success' => 'Xóa công việc thành công.',
                    'id' => $task->id,
                ]);
            } else {
                return response()->json([
                    'error' => 'Xóa công việc thất bại.'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'công việc không tồn tại.'
            ]);
        }
    }
    public function taskManagement($id = null)
    {
        $option = 'managers';
        $task_creater = Auth::user()->id;
        $tasks = Task::getTaskByUser($id, $option, null, $task_creater);
        return view('admin.tasks.task', [
            'tasks' => $tasks,
        ]);
    }
}
