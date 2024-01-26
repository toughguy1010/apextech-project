<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\UserRequest;
use App\Models\Position;
use App\Models\User;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InformationController extends Controller
{
    //

    private $user;
    private $position;
    public function __construct(User $user, Position $position)
    {
        $this->user = $user;
        $this->position = $position;
    }
    public function getPersonalInfo($id = null)
    {
        $positions = $this->position::all();
        $user = $id ? User::findOrFail($id) : null;
        return view('personal-infomation', [
            'id' => $id,
            'positions' => $positions,
            'user' => $user,
        ]);
    }
    public function store(UserRequest $request, $id = null)
    {
        $user = User::findOrFail($id);
        try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone_number = $request->input('phone_number');
            $user->status = $request->input('status');
            $user->avatar = $request->input('avatar');
            $user->gender = $request->input('gender');
            $user->birthday = $request->input('birthday');
            $user->education = $request->input('education');
            $user->marital_status = $request->input('marital_status');
            $user->position_id = $request->input('position_id');
            $user->on_board = $request->input('on_board');
            $user->off_board = $request->input('off_board');
            $user->save();
            if ($id === null) {
                Session::flash('success', 'Thêm mới người dùng thành công');
            } else {
                Session::flash('success', 'Cập nhật người dùng thành công');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
    public function showChangePasswordForm(Request $request, $id = null)
    {
        return view('change-password', [
            'id' => $id
        ]);
    }
    public function changePassword(Request $request, $id = null)
    {
        
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::find($id); // Tìm người dùng theo ID
  
        if (!$user) {
            return back()->with('error', 'User not found');
        }


        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Mật khẩu cũ không đúng, xin vui lòng nhập lại');
        }else{
            $user->password = Hash::make($request->password);
            $user->save();
        }


        return redirect()->route('home')->with('success', 'Đổi mật khẩu thành công');
    }
}
