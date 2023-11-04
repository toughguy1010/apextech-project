<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CeoController extends Controller
{
    //
    private $user;

    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }
    public function index(){
        return view('ceo.home', [
            'user_name' => $this->user->getUserName()
        ]);
    }
}
