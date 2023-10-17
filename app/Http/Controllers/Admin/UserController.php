<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    //
    private $user;
    private $position;
    public function __construct(User $user , Position $position) {
        $this->user = $user;
        $this->position = $position;
    }
    public function viewUpsert($id = null){
        $positions = $this->position::all();
        return view('admin.user.upsert',[
            'id' => $id,
            'positions' => $positions
        ]);
    }
}
