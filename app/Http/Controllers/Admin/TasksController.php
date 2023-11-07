<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TasksController extends Controller
{
    //
    public function index(Request $request){
        $limit = 5;
        $search = $request->input('search', '');
        $tasks = Task::getAllTask($limit,$search  );
        return view('admin.tasks.index',[
            'tasks' => $tasks,
            'search' => $search,
        ]);
    }
    public function viewUpsert($id = null){
        $task = $id ? Task::findOrFail($id) : null;
        return view('admin.tasks.upsert',[
            'id' => $id,
            'task' => $task,
        ]);
    }
    public function store( Request $request, $id = null){
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
            $task->save();
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
}
