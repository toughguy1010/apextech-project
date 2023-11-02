<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Http\Requests\Admin\UserRequest;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    //
    private $user;
    private $position;
    public function __construct(User $user, Position $position)
    {
        $this->user = $user;
        $this->position = $position;
    }
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function index(Request $request)
    {
        $limit = 5;
        $search = $request->input('search', '');
        $users = $this->user->getAllUsers($limit,  $search);
        return view('admin.user.index', [
            'users' => $users,
            'search' => $search,

        ]);
    }
    public function viewUpsert($id = null)
    {
        $positions = $this->position::all();
        $user = $id ? User::findOrFail($id) : null;
        return view('admin.user.upsert', [
            'id' => $id,
            'positions' => $positions,
            'user' => $user,
        ]);
    }
    public function store(UserRequest $request, $id = null)
    {
        if ($id === null) {
            $user = new User();
        } else {
            $user = User::findOrFail($id);
        }
        try {
            if ($id === null) {
                $user->username = $request->input('username');
                $user->password = $request->input('password');
            }
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
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();

        if ($user) {
            $deleted = $user->delete();
            if ($deleted) {
                return response()->json([
                    'success' => 'Xóa người dùng thành công.',
                    'id' => $user->id,
                ]);
            } else {
                return response()->json([
                    'error' => 'Xóa người dùng thất bại.'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Người dùng không tồn tại.'
            ]);
        }
    }
}
