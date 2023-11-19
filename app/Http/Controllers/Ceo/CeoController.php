<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

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
}
