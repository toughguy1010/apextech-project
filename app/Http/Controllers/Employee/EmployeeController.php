<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    //
    private $user;

    public function __construct( User $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }
    public function index()
    {
        return view('employee.home', [
            'user_name' => $this->user->getUserName()
        ]);
    }
    public function getPersonalInfo(){
        $user = Auth::user();
        $user_id = $user->id;
        return $user_id;
    }
}
