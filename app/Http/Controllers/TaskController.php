<?php

namespace App\Http\Controllers;

use App\Models\TaskComments;
use App\Models\TaskProcess;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function changeProccessStatus(Request $request, $id = null)
    {
        if ($id != null) {
            $task_process = TaskProcess::findOrFail($id);
            $status = $request->post('status');
            $userComplete = $request->post('userComplete');
            $task_process->process_status = $status;
            $task_process->user_complete = $userComplete;

            $result = $task_process->save();
            if ($result) {
                $user = User::findOrFail($userComplete);
                $user_name = $user->name;
                return response()->json([
                    'success' => true,
                    'message' => "Cập nhật trạng thái tiến trình thành công",
                    'status' => $task_process->process_status,
                    'user_name' => $user_name,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Cập nhật trạng thái tiến trình thất bại",
                ]);
            }
        }
    }
    public function addComment(Request $request)
    {
        $comment = new TaskComments();

        $comment->user_id = $request->post("userId");
        $comment->task_id = $request->post("taskId");
        $comment->comment = $request->post("comment");
        if ($comment->save()) {

            $user = User::findorFail($comment->user_id);
            
            return response()->json([
                'success' => true,
                'message' => "Bình luận thành công",
                'user_name' => $user->name,
                'user_avatar' => $user->avatar,
                'task_id' => $comment->task_id,
                'comment' => $comment->comment,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Bình luận thất bại",
            ]);
        }
    }
}
