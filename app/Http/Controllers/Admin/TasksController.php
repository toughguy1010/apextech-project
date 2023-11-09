<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class TasksController extends Controller
{
    //
    public function index(Request $request)
    {
        $limit = 5;
        $search = $request->input('search', '');
        $tasks = Task::getAllTask($limit, $search);
        return view('admin.tasks.index', [
            'tasks' => $tasks,
            'search' => $search,
        ]);
    }
    public function viewUpsert($id = null)
    {
        $task = $id ? Task::findOrFail($id) : null;
        $employees = User::getUserEmployee();
        return view('admin.tasks.upsert', [
            'id' => $id,
            'task' => $task,
            'employees' => $employees,
        ]);
    }
    public function store(Request $request, $id = null)
    {
        if ($id === null) {
            $task = new Task();
        } else {
            $task = Task::findOrFail($id);
        }

        try {
            $task->name = $request->input('name');
            $task->description = $request->input('description');
            $task->start_date = $request->input('start_date');
            $task->end_date = $request->input('end_date');
            $task->content = $request->input('content');
            $task->priority = $request->input('priority');
            $employeesID = $request->input('employees_id');

            $task->save();

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
                }
            } else {
                // Nếu không có nhân viên được chọn, loại bỏ tất cả nhân viên được gán trước đó
                $task->assignees()->detach();
            }
            if ($id === null) {
                Session::flash('success', 'Tạo công việc thành công');
            } else {
                Session::flash('success', 'Cập nhật công việ thành công');
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
}
