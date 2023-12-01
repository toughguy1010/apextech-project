<?php

namespace App\Http\Controllers;

use App\Models\TaskProcess;
use App\Models\User;
use Illuminate\Http\Request;
class TaskController extends Controller
{
    //
    public function changeProccessStatus( Request $request, $id = null){
        if($id != null){
            $task_process = TaskProcess::findOrFail($id);
            $status = $request->post('status');
            $userComplete = $request->post('userComplete');
            $task_process->process_status = $status;
            $task_process->user_complete = $userComplete;
            
            $result = $task_process->save();
            if($result){
                $user = User::findOrFail($userComplete);
                $user_name = $user->name;
                return response()->json([
                    'success' => true,
                    'message' => "Cập nhật trạng thái tiến trình thành công",
                    'status' => $task_process->process_status,
                    'user_name' => $user_name,
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => "Cập nhật trạng thái tiến trình thất bại",
                ]);
            }
        }          
    }
}
